<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Varaus peruutettu</title>
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
            <h1>Varaus peruutettu</h1>
        </div>
        <div class="section">
            <p id="greeting">Hei {{ $customer->firstname }},</p>
            <p>Varauksesi palvelulle {{ $service->name }} paikassa {{ $location->name }} on peruutettu.</p>
            <p>Mikäli et itse peruuttanut varaustasi ja/tai peruutus tulee yllätyksenä, ole yhteydessä asiakaspalveluumme.</p>
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