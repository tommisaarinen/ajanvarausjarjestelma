<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Location;
use App\Models\Reservation;
use DateTime;
use DateTimeZone;

class Timetable extends Controller
{

    private function getDelta($serviceID) {
        $delta = Service::find($serviceID)->t_est;
        return $delta;
    }

    private function checkIfServiceAvailable($weekday, $locationID, $serviceID) {
        $data = Location::find($locationID)->available_services;
        $availableServices = array();

        switch ($weekday) {
            case 'Mon':
                $availableServices = $data["ma"];
                break;
            case 'Tue':
                $availableServices = $data["ti"];
              break;
            case 'Wed':
                $availableServices = $data["ke"];
              break;
            case 'Thu':
                $availableServices = $data["to"];
              break;
            case 'Fri':
                $availableServices = $data["pe"];
              break;
            case 'Sat':
                $availableServices = $data["la"];
              break;
            case 'Sun':
                $availableServices = $data["su"];
                break;
        }

        if(!is_null($availableServices)){
            if(in_array($serviceID, $availableServices)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function checkTimesForDate($day, $weekday, $openingTime, $closingTime, $delta, $locationID, $serviceID) {
        
        /*

            Pohjustus:
                -   $day sisältää stringin mallia "today" tai "+(n) days".
                -   $openingTime ja $closingTime sisältävät avaamis- ja sulkemis-
                    kellonajat stringeinä
                =>  $dateString = esim. "today 8:00"

                -   aika-arviot ovat tietokannassa puolen tunnin tarkkuudella
                    desimaalilukuina tunneissa ilmoitettuna - esim. 90min = 1.5
                =>  talletetaan $delta-muuttujaan ja muunnetaan UNIX-timestampiksi
                    kertomalla se 3600:lla (60 * 60 = 3600) laskentaa varten

        */

        $available = $this->checkIfServiceAvailable($weekday, $locationID, $serviceID);
        $available_timeslots = array();

        if(!$available) {
            return $available_timeslots;
        }

        $dateString = "$day $openingTime";
        $closingTimeString = "$day $closingTime";
        $closingTimeUNIX = strtotime($closingTimeString);
        $delta = $delta * 3600;

        //  Haetaan varaukset ja talletetaan niiden alkamis- ja loppumisajat arrayhin.

        $reservations = Reservation::where('location_id', $locationID)
            ->orderBy('t_start', 'asc')
            ->get();

        $reservation_starts = array();
        $reservation_ends = array();

        foreach($reservations as $reservation){
            $datetime_start = new DateTime($reservation->t_start, new DateTimeZone('Europe/Helsinki'));
            $datetime_end = new DateTime($reservation->t_end, new DateTimeZone('Europe/Helsinki'));

            $ts_start = date_timestamp_get($datetime_start);
            $ts_end = date_timestamp_get($datetime_end);
            array_push($reservation_starts, $ts_start);
            array_push($reservation_ends, $ts_end);
        }

        $iter = strtotime($dateString); // Siirretään iteraattori avaamisaikaan,
        $now = strtotime("now");        // otetaan timestamp nykyhetkestä,
        $shift = 0.5 * 60 * 60;         // $shift-muuttujaa käytetään iteraattorin
                                        // siirtämiseen. Tässä määritellään, että
                                        // siirretään puoli tuntia kerrallaan.

        if($now > $iter){                       // Jos olemme ohittaneet iteraattorin
            $rounded = $now - ($now % $shift);  // osoittaman ajankohdan tosielämässä,
            $iter = $rounded + $shift;          // siirretään iteraattori seuraavaan
        }                                       // tasatuntiin tai puoleen.

        if(empty($reservation_starts)){ // Jos varauksia ei ole, unohdetaan laskenta
            while($iter <= ($closingTimeUNIX - $delta)){
                $endpoint = $iter + $delta;
                $startpoint = $iter;
                array_push($available_timeslots, array($startpoint, $endpoint));
                $iter = $iter + $shift;
            }
            return $available_timeslots;
        }

        /*

        VARSINAINEN LASKENTA

        Loopit ja ehtolauseet numeroitu kommenteilla. Etsi koodista looppia tai
        ehtolausetta esittävä numero, selitys löytyy samalla numerolla alla
        olevasta listasta. Vapaista ajoista tehdään aina array(alku, loppu),
        mikä sijoitetaan kaikki aikaslotit sisältävään arrayhin.

        1.  Käydään while-loopilla jokainen varaus läpi. Varauksen alku- ja loppuajan-
            kohdat löytyvät molemmat samasta indeksistä omista arraystaan.

            $reservation_starts[n], $reservation_ends[n] <---- sama varaus

            $i -muuttujalla osoitetaan verrattavaan varaukseen

        2.  $iter = aikaiteraattori, osoittaa siis tiettyyn kellonaikaan. Loopin alussa
            iteraattori osoittaa toimipisteen avaamiskellonaikaan. Siirretään loopin
            lopussa puolella tunnilla eteenpäin. Pyöritetään niin kauan, kunnes aika-
            iteraattori osoittaa sellaista aikaa, missä kohtaa ei ole enää riittävästi
            tilaa palveluun tarvittavalle ajalle ennen sen päivän sulkemisaikaa.

        3.  Käydään uudelleen jokainen varaus läpi ja verrataan osoitettavaan päivään.
            Tämä sen takia, että tämä metodi hakee aikaslotit päiväkohtaisesti, eikä
            siksi tietysti laskennassa haluta verrata sellaisiin aikoihin, jotka ovat
            jollain aiemmalla päivällä. 

        4.  Testataan, onko listassa enempää varauksia.

        5.  Jos on, ja varaus on aiemmalla päivällä, nostetaan $increment-muuttujan
            arvoa. Tällä määritetään se, kuinka monta askelta verrattavaa varausta
            osoittavaa $i-muuttujaa siirretään eteenpäin. Jos ehdot 4 ja 5 ovat epä-
            tosia, $increment = 0 eli $i:n arvo pysyy samana.
        
        6.  Testataan, osoittaako aikaiteraattori verrattavan varauksen alkua edeltävää
            aikaa. Jos ei, siirrytään kohtaan 7.
        
        7.  Jos 6 ei toteudu, testataan, osoittaako aikaiteraattori verrattavan varauksen
            lopun jälkeistä aikaa tai samaa kellonaikaa lopun kanssa. Jos ei, palataan
            loopin numero 2 alkuun ja siirretään aikaiteraattoria puolella tunnilla eteenpäin.

        8.  Jos ehto 7 toteutui, testataan onko listassa olemassa seuraavaa varausta.
            
            Eli näin kertaukseksi sama kysymysmuodossa:

            "Osoittamani aika ei mene varauksen x kanssa päällekäin. Onko sen jälkeen
            vielä varauksia, mistä pitäisi murehtia?"

            Siirrytään kohtaan 10 jos tosi, 9 jos epätosi.

        9.  Ehto 8 on epätosi, eli siis:

            "Ei ole! Merkitsen tämän vapaaksi ajaksi."

        10. Ehto 8 on tosi. Testataan, osoittaako aikaiteraattori seuraavaa varausta
            edeltävään ajankohtaan.

     11/12. Testataan, onko tämän mahdollisen aikaslotin loppumispiste ennen seuraavan
            varauksen alkua. Jos on, slotti ei mene minkään varauksen kanssa päällekäin,
            eli voidaan merkitä vapaaksi ajaksi.

        Lopuksi palautetaan yhden päivän vapaat aikaslotit sisältävä array. Array on siis
        tämän mallinen:

        päivä(slotti[alku, loppu], slotti[alku, loppu], slotti[alku, loppu] ...)

        */

        $i = 0;
        $day0 = "$day 00:00";
        $dayUNIX = strtotime($day0);

        while($i < count($reservation_starts)){ // 1
            while($iter <= ($closingTimeUNIX - $delta)) { // 2
                $endpoint = $iter + $delta;
                $increment = 0;

                for($j = $i; $j < count($reservation_starts); $j++){ // 3
                    if(array_key_exists(($j+1), $reservation_starts)){ // 4
                        if($reservation_starts[$j] < $dayUNIX){ // 5
                            $increment++;
                        } // END 5
                    } // END 4
                } // END 3

                $i = $i + $increment;

                if($iter < $reservation_starts[$i]){ // 6
                    if($endpoint < $reservation_starts[$i]){ // 11
                        $startpoint = $iter;
                        array_push($available_timeslots, array($startpoint, $endpoint));
                    } // END 11
                } else if($iter >= $reservation_ends[$i]) { // END 6 // 7
                    if(array_key_exists(($i+1), $reservation_ends)){ // 8
                        if($iter < $reservation_starts[($i+1)]) { // 10
                            if($endpoint < $reservation_starts[($i+1)]){ // 12
                                $startpoint = $iter;
                                array_push($available_timeslots, array($startpoint, $endpoint)); 
                            } // END 12
                        } // END 10
                    } else { // END 8 // 9
                        $startpoint = $iter;
                        array_push($available_timeslots, array($startpoint, $endpoint));
                    } // END 9
                } // END 7
                $iter = $iter + $shift;
            } // END 2
            $i++;
        } // END 1

        return $available_timeslots;
    }

    private function getBusinessHours($date_unix, $locationID) {
        $open = Location::find($locationID)->open;
        $weekday = date("D", $date_unix);
        $date_md = date("m-d", $date_unix);
        $open_exceptions = Location::find($locationID)->open_exceptions;
        $businessHours = array();

        if(array_key_exists($date_md, $open_exceptions)){
            $businessHours = $open_exceptions["$date_md"];
        } else {
            switch ($weekday) {
                case 'Mon':
                    $businessHours = $open["ma"];
                    break;
                case 'Tue':
                    $businessHours = $open["ti"];
                break;
                case 'Wed':
                    $businessHours = $open["ke"];
                break;
                case 'Thu':
                    $businessHours = $open["to"];
                break;
                case 'Fri':
                    $businessHours = $open["pe"];
                break;
                case 'Sat':
                    $businessHours = $open["la"];
                break;
                case 'Sun':
                    $businessHours = $open["su"];
                    break;
            }
        }

        return $businessHours;
        
    }

    public static function translateWeekday($d_string){ // Suomennetaan viikonpäivät
        switch ($d_string) {
            case 'Mon':
                return "Maanantai";
                break;
            case 'Tue':
                return "Tiistai";
              break;
            case 'Wed':
                return "Keskiviikko";
              break;
            case 'Thu':
                return "Torstai";
              break;
            case 'Fri':
                return "Perjantai";
              break;
            case 'Sat':
                return "Lauantai";
              break;
            case 'Sun':
                return "Sunnuntai";
                break;
        }
    }

    public function getTimetables(Request $request) {
        
        /*

        Selitetään hiukan muuttujia:

            $data:          käyttäjän antamat tiedot get-parametreista
            $delta:         palvelun arvioitu kesto/siihen tarvittava aika
            $businessHours: valitun toimipisteen aukioloajat valitulle viikonpäivälle

            $dateString ym: haetun datan päivämääriä pyöritellään stringeissä
                            koodin luettavuuden vuoksi, kunnes laskentavaiheissa
                            muutetaan UNIX-timestampeiksi strtotime()-funktiolla.
                            Lopussa $d_stringiin pelkkä viikonpäivä ja toiseen
                            datestring-muuttujaan pp.kk muodossa päivämäärä - näitä
                            käytetään vain tiedon passaamiseen fronttiin.

            $days:          kuinka monelta päivältä aikoja haetaan
            $offset:        aika nykyhetkestä haettavista päivistä ensimmäiseen,
                            lasketaan päivissä
            $dates (array): päivämäärät passattavaksi fronttiin otsikkoriville
            

        Valittujen päivien vapaista aikasloteista tehdään kolmiulotteinen array:

            1.  checkTimesForDate() -metodissa pusketaan jokaisen aikaslotin alkamis-
                                    ja päättymispisteet arrayna $available_timeslots-
                                    arrayhin, minkä metodi palauttaa.
            2.  $available_singleday-arrayhin tämän metodin sisällä talletetaan palau-
                                    tettu array.
            3.  $available_alldays  -arrayhin pusketaan $available_singleday-arrayt,
                                    joita tehdään jokaiselle käyttäjän pyytämälle
                                    päivälle.

            Eli siis, arrayn rakenne selitettynä:
                $array[päivä][aikaslotti][alkamis- tai loppumispiste]

        */

        $data = $request->validate([
            'location' => 'required|integer',
            'service' => 'required|integer',
            'offset' => 'required|integer',
            'reservation_id' => 'sometimes|integer'
        ]);
        $delta = $this->getDelta($data['service']);
        date_default_timezone_set('Europe/Helsinki');
        $available_singleday = array();
        $available_alldays = array();
        $offset = $data['offset'];
        $location_name = Location::find($data['location'])->name;
        $service_name = Service::find($data['service'])->name;
        $dates = array();

        // Haun ensimmäinen päivä - testataan, onko tänään vai myöhempi ajankohta.
        // $dateString sen mukaan.

        if($offset == 0){
            $dateString = "today";
        } else {
            $dateString = "+$offset days";
        }

        $date_unix = strtotime($dateString);
        $weekday = date("D", $date_unix);

        $businessHours = $this->getBusinessHours($date_unix, $data['location']);
        if (!is_null($businessHours)) {
            $openingTime = $businessHours[0];
            $closingTime = $businessHours[1];
        } else {
            $openingTime = $businessHours;
            $closingTime = $businessHours;
        }

        $available_singleday = $this->checkTimesForDate($dateString, $weekday, $openingTime, $closingTime, $delta, $data['location'], $data['service']);
        array_push($available_alldays, $available_singleday);

        // Ensimmäisen päivän viikonpäivä ja pvm talteen fronttia varten

        $date_mmdd = date("d.m", $date_unix);
        $d_string = date("D", $date_unix);
        $weekday = $this->translateWeekday($d_string);
        $finalDateString = "$weekday $date_mmdd";
        array_push($dates, $finalDateString);

        // Haun loput päivät for-loopilla:

        $days = 3;

        for($i = 1; $i < $days; $i++){
            $offset_final = $offset + $i;
            $dateString = "+$offset_final days";
            $date_unix = strtotime($dateString);
            $weekday = date("D", $date_unix);

            $businessHours = $this->getBusinessHours($date_unix, $data['location']);
            if (!is_null($businessHours)) {
                $openingTime = $businessHours[0];
                $closingTime = $businessHours[1];
            } else {
                $openingTime = $businessHours;
                $closingTime = $businessHours;
            }
            
            $available_singleday = $this->checkTimesForDate($dateString, $weekday, $openingTime, $closingTime, $delta, $data['location'], $data['service']);
            array_push($available_alldays, $available_singleday);

            // Jälleen pvm ja viikonpäivä fronttia varten talteen:

            $date_mmdd = date("d.m", $date_unix);
            $d_string = date("D", $date_unix);
            $weekday = $this->translateWeekday($d_string);
            $finalDateString = "$weekday $date_mmdd";
            array_push($dates, $finalDateString);
        }

        //  Olemassaolevan varauksen muokkaamista varten:
        
        if(isset($data['reservation_id'])){
            $reservation_id = $data['reservation_id'];
            $edit = true;
        } else {
            $reservation_id = null;
            $edit = false;
        }

        return view('timetables', [ 'results' => $available_alldays, 'offset' => $offset, 'locationName' => $location_name, 'dates' => $dates, 'serviceName' => $service_name, 'serviceID' => $data['service'], 'locationID' => $data['location'], 'reservation_id' => $reservation_id, 'edit' => $edit ]);
    }

}
