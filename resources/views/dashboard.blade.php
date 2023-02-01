<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Asiakas</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="css/master.css">
        <link rel="stylesheet" href="css/dashboard.css">
    </head>
    <body>
        <div class="container-fluid backdrop">
            <div class="container maincontent">
                <div class="container contentwrap">
                    <div class="row dashboard-toprow">
                        <div class="dashboard-toprow-wrap">
                            <h2 class="dashboardheader">Hei {{ Auth::user()->firstname }}!</h2>
                            <a href="/logout" class="logoutbutton">Kirjaudu ulos <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                        </div>
                        <hr>                        
                    </div>
                    <div class="row">
                        <h4>Voimassaolevat ajanvarauksesi</h4>
                        <div class="container-fluid tablewrap">
                            <table>
                                <tr>
                                    <th>Päivämäärä</th>
                                    <th>Kellonaika</th>
                                    <th>Palvelu</th>
                                    <th>Paikka</th>
                                    <th></th>
                                </tr>
                                @foreach ($reservations as $reservation)
                                <?php 
                                    $t_start = strtotime($reservation['t_start']);
                                    $t_end = strtotime($reservation['t_end']);
                                    $service = DB::table('services')->where('id', $reservation['service_id'])->get()->first();
                                    $location = DB::table('locations')->where('id', $reservation['location_id'])->get()->first();
                                ?>
                                    <tr>
                                        <td>{{ date("d.m", $t_start) }}</td>
                                        <td>{{ date("H:i", $t_start) }}-{{ date("H:i", $t_end) }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $location->name }}</td>
                                        <td>
                                            <form action="/cancelreservation" method="post">
                                                @csrf
                                                <?php
                                                if($service->cancellable === 1){
                                                    if(!is_null($service->cancel_within)){
                                                        $cancel_timeframe = 3600 * $service->cancel_within;
                                                        $startUNIX = strtotime($reservation['t_start']);
                                                        $now = strtotime(now());
                                                        if($now + $cancel_timeframe < $startUNIX){
                                                            $within_timeframe = true;
                                                        } else {
                                                            $within_timeframe = false;
                                                        }
                                                    } else {
                                                        $within_timeframe = true;
                                                    }
                                                    if($within_timeframe){
                                                       echo '
                                                            <input type="hidden" name="reservation_id" value="' . $reservation['id'] . '">
                                                            <button type="submit" class="btn btn-primary cancelbutton">Peruuta</button>
                                                        '; 
                                                    }  
                                                }
                                                ?>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Varaa uusi aika</h4>
                        <div class="container formcontainer">
                            <form action="/timetables" method="get">
                                <div class="row inputrow">
                                    <select class="form-control form-control-lg" name="location" required>
                                        <option value="" disabled selected>Valitse sijainti</option>
                                        @foreach (\App\Models\Location::all() as $location) {
                                            <option value="{{ $location->id }}">{{ $location->name }}, {{ $location->address }}, {{ $location->zip }} {{ $location->city }}</option>
                                        }
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row inputrow">
                                    <select class="form-control form-control-lg" name="service" required>
                                        <option value="" disabled selected>Valitse palvelu</option>
                                        @foreach (\App\Models\Service::all() as $service)
                                            @if ($service->available == 1)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                
                                            @endif        
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" id="days" name="days" value="3">
                                <input type="hidden" id="offset" name="offset" value="0">
                                <div class="row inputrow">
                                    <button type="submit" class="btn btn-primary mb-2 formbutton"><i class="fa-regular fa-clock"></i> Näytä vapaat ajat</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://kit.fontawesome.com/ae6398c167.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    </body>
</html>