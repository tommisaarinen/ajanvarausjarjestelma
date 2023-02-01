<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Ajanvarausdemo</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="css/master.css">
    </head>
    <body>
        <div class="container-fluid backdrop">
            <div class="container maincontent">
                <div class="container contentwrap">
                    <div class="row" id="formrow">
                        <div class="col formcontainer" id="welcomeform-left">
                            <div class="row formheader">
                                <h2>Uusi asiakas</h2>
                            </div>
                            <div class="row">
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
                                    <input type="hidden" id="offset" name="offset" value="0">
                                    <div class="row inputrow">
                                        <button type="submit" class="btn btn-primary mb-2 formbutton"><i class="fa-regular fa-clock"></i> Näytä vapaat ajat</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col formcontainer" id="welcomeform-right">
                            <div class="row formheader">
                                <h2>Palaava asiakas</h2>    
                            </div>
                            <div class="row">
                                <form action="/login" method="post">
                                    @csrf
                                    <div class="row inputrow">
                                        <input class="form-control form-control-lg" type="text" placeholder="Puhelinnumero tai sähköpostiosoite" name="tel_email">
                                    </div>
                                    <div class="row inputrow">
                                        <input class="form-control form-control-lg" type="text" placeholder="Tunnistautumiskoodi" name="authcode">
                                    </div>
                                    <div class="row inputrow">
                                        <button type="submit" class="btn btn-primary mb-2 formbutton"><i class="fa-solid fa-arrow-right-to-bracket"></i> Kirjaudu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row formfooter">
                        <div class ="container">
                            <hr>
                            <p class="smoltext">Tarvitsetko apua? Katso usein kysytyt kysymykset <a href="#">tästä</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script src="https://kit.fontawesome.com/ae6398c167.js" crossorigin="anonymous"></script>                                    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    </body>
</html>