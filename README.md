# README #

- Uuden varausjärjestelmän koodit


Tämänhetkinen versio: 0.1b

Oletusarvoinen admin-käyttäjä (factoryllä luotuna):
    Käyttäjänimi: admin
    Salasana: changeMe

To do:
    - Admin-työkalut:
        *   Uudelleenohjaus takaisin admin-paneeliin oikealle tabille
    - Frontti:
        *   Käyttöliittymä päivittymään poistaessa myös haun ollessa aktiivinen
        *   HTML/CSS-refactorointia:
            -   Väritys helpommin teemoitettavaksi
            -   Turhien luokkien putsailua yms
        *   Mobiilikäyttöliittymä (puuttuu kokonaan, desktop skaalautuu kapeaan
            viewporttiin saatanan rumasti)
        *   Kalenterinäkymä?
    - Sekalaista:
        *   Palvelujen hinnoittelu
        *   Yksikkötestausta
        *   Error handlingia
        *   Tapahtumien logaamista
        *   Perusteellisempaa syötteen tarkistusta
        *   Koodin kommentointia
        *   UKK

Bugeja:
    -   Admin-paneelissa poistaessa jotain listan seuraavan elementin poistonapin
        muotoilu muuttuu - värit vaihtuvat, hover-classi toimii normaalisti


## v0.01a

    +   Jonkinnäköinen dummy-käyttöliittymä
    +   Vapaiden aikojen hakeminen
        *   Testaa paikkakohtaisesti, löytyykö sopivan mittaisia aikavälejä annetulle
            päivälle aukioloaikojen puitteissa, alkaen joko tasatunnilta tai puolelta
        *   Lisää selostusta toteutuksesta Timetable-controllerissa
    +   Asiakkaan kirjautumisjärjestelmä
    +   Asiakkaan dashboard
        *   Asiakas voi tarkastella voimassa olevia varauksiaan
        *   Jos dashboardiin yrittää päästä pelkällä URLilla ilman sisäänkirjautumista,
            redirectaa takaisin varausjärjestelmän etusivulle
        *   Admin-tilillä kirjautunut redirectataan takaisin varausjärjestelmän
            etusivulle
    +   Varauksen luominen
        *   Jos asiakas on kirjautunut sisään, täytetään varausta luodessa kentät
            automaattisesti ja laitetaan saman asiakastilin alle
        *   Jos järjestelmästä löytyy asiakas samoilla tiedoilla kuin varaukseen
            syötetyt tiedot, laitetaan saman asiakastilin alle
    +   Adminin kirjautumisjärjestelmä ja erillinen auth guard
    +   Admin-paneeli
        *   Tabit: Koti, Varaukset, Toimipisteet, Palvelut, Asiakkaat, Valvojat
        *   Tabien ensimmäiset sivut ja tarpeelliset kontrollipainikkeet, ikonit ym.
        *   Ensimmäisillä sivuilla tarpeellinen datan hakeminen ja tulostaminen, muu
            toiminnallisuus puuttuu
        *   Asiakastilillä kirjautunut tai kokonaan kirjautumaton käyttäjä
            redirectataan admin-kirjautumissivulle


## v0.02a

    +   Toimipisteillä viikonpäiväkohtaiset aukioloajat JSON-objektina taulussa
    -   Vanhat opening_time, closing_time, otime_wknd, ctime_wknd -sarakkeet poistettu
        taulusta ja migraatiosta
    +   Toimipisteillä tarjottavat palvelut viikonpäiväkohtaisesti
    +   Timetable-controllerin koodia refactoroitu em. muutosten mukaisesti:
        *   Lisätty getBusinessHours() ja checkIfServiceAvailable() -metodit
        *   Vanhaan taulurakenteeseen perustuvat matikat poistettu
        *   checkIfServiceAvailable()-metodia kutsutaan checkTimesForDate()-metodista,
            jos palauttaa falsen niin skipataan kaikki laskenta ja palautetaan suoraan tyhjä array
    -   Admin-paneelin frontista poistettu toimipisteet-tabilta aukioloaikasarakkeet
        taulusta, eivät päiväkohtaisina mahdu layouttiin sellaisenaan
        *   Mitä niille tehdään?
            a.  Tauluun dropdowneihin piiloon
            b.  Tauluun linkit/painikkeet, jotka vievät toimipisteen
                lisätietosivulle, missä näkyisivät aukioloajat, tarjotut palvelut
                päiväkohtaisesti, tilastoja, voimassaolevia varauksia yms. dataa
            c.  Annetaan edittisivun hoitaa tuo ylempi ja jätetään aukioloajat
                sinne
            d.  Joku muu ratkaisu?


## v0.03a

    +   Lisätty toiminnallisuus admin-paneelin poistamispainikkeisiin
    +   Vanhentuneiden varauksien ja asiakastilien automaattinen poistaminen
        *   Varaus-modeli määritetty prunableksi ja prune-komennon ehdot määritetty
        *   Asiakas-modelille komento kirjoitettu, ei kuitenkaan vielä toimiva
        *   Schedule tehty (App\Console\Kernel.php)
        ?   Schedule ja prune vielä testaamatta, toiminnallisuudesta ei tietoa
    +   Toimipisteen lisäämislomake tehty
        *   Toiminnallisuus lisätty, mutta kaipaa kiillottelua, ehkä lisätarkistuksia
            syötettyyn dataan
    !!  Koodia kommentoitu toistaiseksi vielä huonosti


## v0.04a

    +   Lisätty toimipisteiden muokkaaminen
    +   Lisätty palvelujen muokkaaminen
    +   Lisätty asiakastilien muokkaaminen
    +   Lisätty vanhentuneiden varauksien ja asiakastilien poistaminen
        *   Poistaessa controlleri kirjaa poistetut ylös muuttujiin, millä ei vielä
            toistaiseksi tehdä mitään
    +   Lisätty palvelujen poistaminen
        *   Palvelun poistaessa järjestelmä myös poistaa kyseiselle palvelulle varatut
            ajat, ja ottaa palvelun pois jokaisen toimipisteen tarjottavien palvelujen listalta
        *   Poistaessa controlleri kirjaa nuo samalla muutetut tai poistetut varaukset
            ja toimipisteet muuttujiin, niillä voi tarvittaessa tehdä jotain
    *   Toimipiste- ja palvelu-formien handlerikoodia refactoroitu

## v0.05b

    +   Varauksien lisääminen adminin puolelta
    +   Valvojatilien luominen
    +   Valvojatilien poistaminen
    +   Valvojatilin salasanan vaihtaminen
    +   Varauksien muokkaaminen
    +   Varauksien hallintametodit siirretty AdminControlleriin
    *   Admin-työkalujen reititys korjattu siirtämällä kaikki auth-guardin middleware
        groupin sisään
    *   Admin-controllerin uudelleenjärjestely
        -   Koodin jäsentelyä: metodit ympätty kategorioihin ja jaettu kommenteilla
        -   Yleistä koodin kommentiointia

## v0.052b

    +   Factoryt lisätty asiakastileille, toimipisteille, varauksille ja palveluille,
        ja myös testattu
    *   Bugeja korjattu
        -   Tietyillä komboilla vapaita aikoja ei muka lainkaan koskaan vaikka pitäisi
            olla: paikannettu ja osittain korjattu, johtui viallisesta datasta tietokannassa
            >>  To-do: lisälenkit vapaiden aikojen haun koodiin vastaavan-
                luontoisten poikkeustilanteiden käsittelemiseen
        -   Palvelun poisto tyhjentää kaikkien toimipisteiden available_services-
            sarakkeiden objektit: paikannettu ja korjattu

## v0.06b

    *   Modelien luontia testattu HTTP-testeillä
    *   Modelien liitokset testattu
    *   Customer- ja Reservation-modelien migraatiot korjattu
    +   Admin-factory luotu
    *   Admin-reitit testattu HTTP-testeillä
    *   Vanhentuneet varaukset ja asiakastilit poistaessa käyttöliittymä ei
        päivity -bugi korjattu

## v0.062b

    *   MAJOR BUG FIX:

        "Vapaita aikoja ei muka ollenkaan vaikka pitäisi olla" -bugi vasta nyt todellisesti paikannettu ja korjattu. Bugi ilmeni aina kun varauksia toimipisteellä oli voimassa enemmän kuin 1, ja ilmeni vasta viimeisen varauksen jälkeisillä päivillä.

        Johtui virheestä vapaiden aikaslottien hakemisen logiikassa: verrattiin jatkuvasti jo menneenä päivänä olleeseen varaukseen, ja toteutuksen ehdoista johtuen aikaiteraattori pyöri tyhjää päivän loppuun saakka, minkä jälkeen loput joka varauksen läpi käyvän for-loopin kierroista pyörivät myös tyhjinä tekemättä mitään, sillä toteutuksen sisältävän while-loopin ehto ei enää toteutunut (aikaiteraattori <= (sulkemisaika - varauksen kesto)).

        For-looppi vaihdettu while-loopiksi, jotta kesken loopin kierron voi varauksen indeksiä osoittavan muuttujan arvoa vaihtaa. Tämä olennaista, jotta aikaslotit eivät joko näy tuplana, tai järjestelmä ei tarjoa aikoja jotka menevät olemassaolevien varausten kanssa päällekäin.

    *   MINOR BUG FIX:

        Tarkastellessa kuluvan päivän vapaita aikoja, aikaosoitin pyöristyi nykyhetkestä edelliseen puoleen tuntiin. Pyöristyy nyt seuraavaan, niin kuin pitäisikin.

    +   Vapaiden aikojen haun koodia kommentoitu kattavammin

## v0.07b

    +   Toimipisteille lisätty poikkeuspäivät aukioloajoille
    +   Poikkeuspäivien määritys lisätty admin-paneeliin
    *   Migraatiot ja modelit päivitetty muutoksien mukaisiksi
    !!  Ominaisuutta ei vielä testattu automaatiotestauksella

## v0.08b

    +   Palvelun voi määrittää sellaiseksi, että asiakas voi palvelulle varaamansa
        ajan peruuttaa itse järjestelmän kautta
    +   Asiakas voi kirjautuneena peruuttaa sellaisen varauksen, minkä palvelu
        on määritetty sallittavaksi peruuttaa asiakkaan puolelta
    +   Peruutuksille voi myös määrittää sallitun aikarajan ennen varauksen alkua
    +   Migraatioita päivitetty, uudet ominaisuudet testattu manuaalisesti ja
        automaatiotestauksella
    +   Admin-paneeliin palvelut-välilehdelle näkyviin onko palvelulla sallittu
        peruutus vai ei

## v0.09b

    +   Sähköposti lisätty
        *   Käyttäjä saa vahvistusviestin tehdystä varauksesta ja varauksen
            peruutuksesta
        *   Vahvistusviesteissä yleistä ohjeistusta ja varauksen ID, tehdyn
            varauksen vahvistusviestissä myös tunnistautumiskoodi
        *   Viestien muotoilu ja ulkoasu käytännössä dummyvaiheessa
    *   Controllereissa yleistä koodin siistimistä
    *   Framework päivitetty

## v0.1b

    *   Muutama aivopieru siivottu
    *   Migraatiot testattu toisella järjestelmällä ja päivitetty
