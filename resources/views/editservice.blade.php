<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Muokkaa palvelua</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/master.css">
        <link rel="stylesheet" href="../css/varaus.css">
        <link rel="stylesheet" href="../css/admin.css">
        <link rel="stylesheet" href="../css/dashboard.css">
    </head>
    <body>
        <div class="container-fluid backdrop">
            <div class="container maincontent">
                <div class="container contentwrap">
                    <div class="row dashboard-toprow">
                        <div class="dashboard-toprow-wrap">
                            <h2 class="dashboardheader">Muokkaa palvelua</h2>
                            <a href="/admin/logout" class="logoutbutton">Kirjaudu ulos <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                        </div>        
                    </div>
                    <hr>
                    <div class="row formwrap">
                        <div class="container-fluid formcontainer">
                            <form action="/admin/srvchandle" method="post">
                                @csrf
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="srvc_id" value="{{ $service->id }}">
                               <div class="row inputrow">
                                    <input type="text" class="form-control form-control-lg" name="srvcname" placeholder="Palvelun nimi" value="{{ $service->name }}" required>
                                </div>
                                <div class="row inputrow dividedrow">
                                    <div class="col inputcolumn">
                                        <label for="t_est">Palveluun varattava aika (h)</label>
                                        <input type="number" name="t_est" class="form-control form-control-lg" min="0.5" max="8" step="0.5" value="{{ $service->t_est }}" required>
                                    </div>
                                    <div class="col inputcolumn" id="checkboxcol">
                                        <div class="checkboxcontain checkboxcontain-service" id="availablecheckboxcontain">
                                            <input type="checkbox" class="checkbox" name="available" @if ($service->available == 1) checked @endif>
                                            <label for="available">Saatavilla</label>
                                        </div>
                                        <div class="checkboxcontain checkboxcontain-service" id="cancellablecheckboxcontain">
                                            <input type="checkbox" class="checkbox" name="cancellable" id="cancellable" @if ($service->cancellable == 1) checked @endif>
                                            <label for="cancellable">Peruutettavissa</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row inputrow" id="timeframecontain" @if ($service->cancellable == 1) style="display:flex;" @endif>
                                    <h4>Peruutuksen sallittu aikaraja</h4>
                                    <p class="form-subtext">M????rit?? aika, mink?? verran ennen varauksen alkua asiakas saa viimeist????n perua varauksen itse verkossa soittamatta asiakaspalveluun. J??t?? tyhj??ksi, jos varauksen saa peruuttaa milloin tahansa.</p>
                                    <label for="cancellable_timeframe">Aikaraja (h)</label>
                                    <input type="number" name="cancellable_timeframe" class="form-control form-control-lg" min="0.5" max="48" step="0.5" id="cancellable-timeframe-input" value="{{ $service->cancel_within }}" @if ($service->cancellable == 0) disabled @endif>
                                </div>
                                <div class="row inputrow" id="submitrow">
                                    <button type="submit" class="btn btn-primary mb-2 formbutton"><i class="fa-regular fa-floppy-disk"></i> Tallenna muutokset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            const checkbox = document.getElementById("cancellable");
            const timeframecontain = document.getElementById("timeframecontain");
            const timeframeinput = document.getElementById("cancellable-timeframe-input");

            checkbox.addEventListener('click', function (){
                if (checkbox.checked) {
                    timeframecontain.style.display = 'flex';
                    timeframeinput.removeAttribute('disabled');
                } else {
                    timeframecontain.style.display = 'none';
                    timeframeinput.setAttribute('disabled', '');
                }
            });
        </script>
        <script src="https://kit.fontawesome.com/ae6398c167.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    </body>
</html>