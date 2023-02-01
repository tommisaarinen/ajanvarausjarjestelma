<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Varaa aika</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="css/master.css">
        <link rel="stylesheet" href="css/varaus.css">
    </head>
    <body>
        <div class="container-fluid backdrop">
            <div class="container maincontent">
                <div class="container contentwrap">
                    <div class="row formheader">
                        <h2>Varaa aika</h2>
                        <?php
                            $date = date("d.m", $ts_start);
                            $ts_string = date("H:i", $ts_start)."-".date("H:i", $ts_end);
                        ?>
                        <p class="header-subtext">{{ $serviceName }} - {{ $locationName }} ({{ $date }} {{ $ts_string }})</p>
                    </div>
                    <div class="row">
                        <div class="container-fluid formcontainer">
                            <form action="/makereservation" method="post">
                                @csrf
                                <div class="row inputrow">
                                    <input type="text" class="form-control form-control-lg reservationinput" name="fname" placeholder="Etunimi" required <?php if($login){ echo 'readonly value="'.Auth::user()->firstname.'"'; } ?>>
                                </div>
                                <div class="row inputrow">
                                    <input type="text" class="form-control form-control-lg reservationinput" name="lname" placeholder="Sukunimi" required <?php if($login){ echo 'readonly value="'.Auth::user()->lastname.'"'; } ?>>
                                </div>
                                <div class="row inputrow">
                                    <input type="tel" class="form-control form-control-lg reservationinput" name="phone" placeholder="Puhelinnumero" required <?php if($login){ echo 'readonly value="'.Auth::user()->phone.'"'; } ?>>
                                </div>
                                <div class="row inputrow">
                                    <input type="email" class="form-control form-control-lg reservationinput" name="email" placeholder="Sähköposti" required <?php if($login){ echo 'readonly value="'.Auth::user()->email.'"'; } ?>>
                                </div>

                                <input type="hidden" name="ts_start" value="{{ $ts_start }}">
                                <input type="hidden" name="ts_end" value="{{ $ts_end }}">
                                <input type="hidden" name="service" value="{{ $service }}">
                                <input type="hidden" name="location" value="{{ $location }}">
                                
                                <div class="row inputrow">
                                    <button type="submit" class="btn btn-primary mb-2 formbutton">Lähetä ajanvaraus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    </body>
</html>