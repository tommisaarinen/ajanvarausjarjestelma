<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Ajanvarauksesi</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
        <style>
            body {
                padding: 0px;
                margin: 0px;
                font-family: Arial, Helvetica, sans-serif;
            }

            .headerrow h1 {
                color: white;
            }
            
            .headerrow {
                background-color: #424242;
            }

            .section {
                padding: 20px;
            }

            .authcodebox {
                box-shadow: 0px 0px 12px -5px rgba(0,0,0,0.5);
                padding: 30px;
                border-radius: 15px;
                margin-top: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .authcodebox p {
                margin: 5px;
            }

            #authcode {
                font-weight: bold;
                font-size: 24px;
            }

            #greeting {
                font-size: 20px;
                margin-bottom: 30px;
            }
        </style>
    </head>
    <?php
/*
use App\Models\Customer;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\Service;

        $reservation = Reservation::where('id', 29)->get()->first();
        $customer = Customer::where('id', $reservation->customer_id)->get()->first();
        $service = Service::where('id', $reservation->service_id)->get()->first();
        $location = Location::where('id', $reservation->location_id)->get()->first();
*/
        if($service->cancellable == 1){
            if(!is_null($service->cancel_within)){
                $minutes = $service->cancel_within * 60;
                $cancelstring = "Palvelu, jolle ajan varasit, on määritetty asiakkaan peruutettavaksi. Voit tarvittaessa perua varauksesi viimeistään " . $minutes . " minuuttia ennen varauksen alkua kirjautumalla sisään.";
            } else {
                $cancelstring = "Palvelu, jolle ajan varasit, on määritetty asiakkaan peruutettavaksi. Voit tarvittaessa perua varauksesi kirjautumalla sisään.";
            }
        } else {
            $cancelstring = "Palvelua, jolle ajan varasit, ei ole määritetty asiakkaan peruutettavaksi. Jos siis tarvittaessa haluat kuitenkin perua varauksesi, ota yhteyttä asiakaspalveluumme. Kirjautumalla sisään voit kuitenkin tarkastella varauksiasi.";
        }

        $startUNIX = strtotime($reservation->t_start);
        $weekdayEN = date("D", $startUNIX);
        $weekdayFI = app('App\Http\Controllers\Timetable')->translateWeekday($weekdayEN);
        $date_formatted = date("j.n.Y", $startUNIX);
        $startTime = date("G:i", $startUNIX);
        $endUNIX = strtotime($reservation->t_end);
        $endTime = date("G:i", $endUNIX);
    ?>
    <body>
        <div class="section headerrow">
            <h1>Ajanvaraus onnistui!</h1>
        </div>
        <div class="section">
            <p id="greeting">Hei {{ $customer->firstname }},</p>
            <p>Varauksesi paikkaan {{ $location->name }} on nyt tehty. {{ $cancelstring }}</p>
            <p>Sisäänkirjautumiseen voit käyttää joko sähköpostiosoitettasi tai puhelinnumeroasi, sekä sinulle automaattisesti luotua viisinumeroista tunnistautumiskoodiasi. Mikäli joku muu on tehnyt varauksen joko samalla sähköpostilla tai puhelinnumerolla, käytä sitä, mikä sinun varauksessasi eroaa. Jos siis esimerkiksi käytät samaa puhelinnumeroa kuin toinen asiakas, käytä sisäänkirjautumisessa sähköpostiasi.</p>

            <div class="authcodebox">
                <p>Tunnistautumiskoodisi:</p>
                <p id="authcode">{{ $customer->authcode }}</p>
            </div>
        </div>
        <div class="section">
           <h3>Varauksen tiedot:</h3>
            <p>{{ $service->name }}</p>
            <p>{{ $weekdayFI }}na {{ $date_formatted }} klo {{ $startTime }}-{{ $endTime }}</p>
            <p>{{ $location->name }}</p>
            <p>{{ $location->address }}</p>
            <p>{{ $location->zip }} {{ $location->city }}</p> 
            <p>Varausnumero: {{ $reservation->id }}</p>
        </div>
        <div class="section footer">

        </div>
    </body>
</html>