<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Aikataulut</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="css/master.css">
        <link rel="stylesheet" href="css/timetable.css">
    </head>
    <body>
        <div class="container-fluid backdrop">
            <div class="container maincontent">
                <div class="row" id="timetableheader">
                    <h2>Vapaat ajat</h2>
                    <p class="header-subtext">{{ $serviceName }} - {{ $locationName }}</p>
                </div>
                <div class="row">
                    <?php $d = 0; ?>
                    @foreach ($results as $result)
                        <div class="col">
                            <div class="row daterow">
                                <h4>{{ $dates[$d] }}</h4> 
                            </div>
                            @if (empty($result))
                                <div class="container-fluid errorcontain">
                                    <p class="timetable-error">Ei vapaita aikoja</p>
                                </div>
                            @endif
                            @if (!empty($result))    
                                <div class="container-fluid timeslotlist">    
                                    @for ($ts = 0; $ts < count($result); $ts++)
                                        <div class="row timetablerow">
                                            <?php
                                            $startpoint = date("H:i", $result[$ts][0]);
                                            $endpoint = date("H:i", $result[$ts][1]);
                                            if($edit){
                                                $action = "/admin/updatereservation";
                                            } else {
                                                $action = "/newreservation";
                                            }
                                            ?>
                                            <div class="col timecol">
                                                <b>{{ $startpoint }}-{{ $endpoint }}</b>
                                            </div>
                                            <div class="col-sm buttoncol">
                                                <form method="post" action="{{ $action }}">
                                                    @csrf
                                                    @if ($edit)
                                                        <input type="hidden" name="rsrv_id" value="{{ $reservation_id }}">
                                                    @endif
                                                    <input type="hidden" name="srv" value="{{ $serviceID }}">
                                                    <input type="hidden" name="lct" value="{{ $locationID }}">
                                                    <input type="hidden" name="start" value="{{ $result[$ts][0] }}">
                                                    <input type="hidden" name="end" value="{{ $result[$ts][1] }}">
                                                    <button type="submit" class="btn btn-primary mb-2 timetablebutton">Varaa</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            @endif
                        </div>
                        <?php $d++; ?>
                    @endforeach
                </div>
                <div class="row controlsrow">
                    <div class="col">
                        @if ($offset != 0)
                            <a href="/timetables?location={{ $locationID }}&service={{ $serviceID }}&days=3&offset={{ $offset-3 }}<?php if($edit){echo '&reservation_id='. $reservation_id ;} ?>"><< Näytä edelliset 3 päivää</a>
                        @endif
                    </div>
                    <div class="col"></div>
                    <div class="col">
                        <a href="/timetables?location={{ $locationID }}&service={{ $serviceID }}&days=3&offset={{ $offset+3 }}<?php if($edit){echo '&reservation_id='. $reservation_id ;} ?>">Näytä seuraavat 3 päivää >></a>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    </body>
</html>