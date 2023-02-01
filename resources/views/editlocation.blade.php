<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Muokkaa toimipistettä</title>
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
                            <h2 class="dashboardheader">Muokkaa toimipistettä</h2>
                            <a href="/admin/logout" class="logoutbutton">Kirjaudu ulos <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                        </div>
                                    
                    </div>
                    <hr>
                    <div class="row formwrap">
                        <div class="container-fluid formcontainer">
                            <form action="/admin/lcthandle" method="post">
                                @csrf
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="lct_id" value="{{ $location->id }}">
                                <div class="row inputrow">
                                    <input type="text" class="form-control form-control-lg reservationinput" name="lctname" placeholder="Toimipisteen nimi" value="{{ $location->name }}" required>
                                </div>
                                <div class="row inputrow">
                                    <input type="text" class="form-control form-control-lg reservationinput" name="address" placeholder="Katuosoite" value="{{ $location->address }}" required>
                                </div>
                                <div class="row inputrow dividedrow">
                                    <div class="col-4 inputcolumn">
                                        <input type="text" class="form-control form-control-lg reservationinput" name="zip" placeholder="Postinumero" value="{{ $location->zip }}" required>
                                    </div>
                                    <div class="col inputcolumn">
                                        <input type="text" class="form-control form-control-lg reservationinput" name="city" placeholder="Postitoimipaikka" value="{{ $location->city }}" required>
                                    </div>
                                </div>
                                <hr class="formdivide">
                                <div class="row">
                                    <h4>Aukioloajat</h4>
                                    <p class="form-subtext">Jätä tyhjäksi, jos toimipiste on suljettu sinä päivänä.</p>
                                </div>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Maanantai</h5>
                                    </div>
                                    <div class="row inputrow dividedrow">
                                        <div class="col inputcolumn">
                                            <label for="ma-open" class="businesshrs-label">Aukeaa</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="ma-open"
                                            <?php 
                                            if(!is_null($location->open['ma'])){
                                                echo 'value="' . $location->open['ma'][0] . '"'; 
                                                } ?>>
                                        </div>  
                                        <div class="col inputcolumn">
                                            <label for="ma-close" class="businesshrs-label">Sulkeutuu</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="ma-close" <?php 
                                            if(!is_null($location->open['ma'])){
                                                echo 'value="' . $location->open['ma'][1] . '"'; 
                                                } ?>>
                                        </div>    
                                    </div>
                                </div>

                                <hr>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Tiistai</h5>
                                    </div>
                                    <div class="row inputrow dividedrow">
                                        <div class="col inputcolumn">
                                            <label for="ti-open" class="businesshrs-label">Aukeaa</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="ti-open" <?php 
                                            if(!is_null($location->open['ti'])){
                                                echo 'value="' . $location->open['ti'][0] . '"'; 
                                                } ?>>
                                        </div>  
                                        <div class="col inputcolumn">
                                            <label for="ti-close" class="businesshrs-label">Sulkeutuu</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="ti-close" <?php 
                                            if(!is_null($location->open['ti'])){
                                                echo 'value="' . $location->open['ti'][1] . '"'; 
                                                } ?>>
                                        </div>    
                                    </div>
                                </div>

                                <hr>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Keskiviikko</h5>
                                    </div>
                                    <div class="row inputrow dividedrow">
                                        <div class="col inputcolumn">
                                            <label for="ke-open" class="businesshrs-label">Aukeaa</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="ke-open" <?php 
                                            if(!is_null($location->open['ke'])){
                                                echo 'value="' . $location->open['ke'][0] . '"'; 
                                                } ?>>
                                        </div>  
                                        <div class="col inputcolumn">
                                            <label for="ke-close" class="businesshrs-label">Sulkeutuu</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="ke-close" <?php 
                                            if(!is_null($location->open['ke'])){
                                                echo 'value="' . $location->open['ke'][1] . '"'; 
                                                } ?>>
                                        </div>    
                                    </div>
                                </div>

                                <hr>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Torstai</h5>
                                    </div>
                                    <div class="row inputrow dividedrow">
                                        <div class="col inputcolumn">
                                            <label for="to-open" class="businesshrs-label">Aukeaa</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="to-open" <?php 
                                            if(!is_null($location->open['to'])){
                                                echo 'value="' . $location->open['to'][0] . '"'; 
                                                } ?>>
                                        </div>  
                                        <div class="col inputcolumn">
                                            <label for="to-close" class="businesshrs-label">Sulkeutuu</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="to-close" <?php 
                                            if(!is_null($location->open['to'])){
                                                echo 'value="' . $location->open['to'][1] . '"'; 
                                                } ?>>
                                        </div>    
                                    </div>
                                </div>

                                <hr>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Perjantai</h5>
                                    </div>
                                    <div class="row inputrow dividedrow">
                                        <div class="col inputcolumn">
                                            <label for="pe-open" class="businesshrs-label">Aukeaa</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="pe-open" <?php 
                                            if(!is_null($location->open['pe'])){
                                                echo 'value="' . $location->open['pe'][0] . '"'; 
                                                } ?>>
                                        </div>  
                                        <div class="col inputcolumn">
                                            <label for="pe-close" class="businesshrs-label">Sulkeutuu</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="pe-close" <?php 
                                            if(!is_null($location->open['pe'])){
                                                echo 'value="' . $location->open['pe'][1] . '"'; 
                                                } ?>>
                                        </div>    
                                    </div>
                                </div>

                                <hr>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Lauantai</h5>
                                    </div>
                                    <div class="row inputrow dividedrow">
                                        <div class="col inputcolumn">
                                            <label for="la-open" class="businesshrs-label">Aukeaa</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="la-open" <?php 
                                            if(!is_null($location->open['la'])){
                                                echo 'value="' . $location->open['la'][0] . '"'; 
                                                } ?>>
                                        </div>  
                                        <div class="col inputcolumn">
                                            <label for="la-close" class="businesshrs-label">Sulkeutuu</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="la-close" <?php 
                                            if(!is_null($location->open['la'])){
                                                echo 'value="' . $location->open['la'][1] . '"'; 
                                                } ?>>
                                        </div>    
                                    </div>
                                </div>

                                <hr>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Sunnuntai</h5>
                                    </div>
                                    <div class="row inputrow dividedrow">
                                        <div class="col inputcolumn">
                                            <label for="su-open" class="businesshrs-label">Aukeaa</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="su-open" <?php 
                                            if(!is_null($location->open['su'])){
                                                echo 'value="' . $location->open['su'][0] . '"'; 
                                                } ?>>
                                        </div>  
                                        <div class="col inputcolumn">
                                            <label for="su-close" class="businesshrs-label">Sulkeutuu</label>
                                            <input type="time" class="form-control form-control-lg reservationinput" name="su-close" <?php 
                                            if(!is_null($location->open['su'])){
                                                echo 'value="' . $location->open['su'][1] . '"'; 
                                                } ?>>
                                        </div>    
                                    </div>
                                </div>

                                <hr class="formdivide">

                                <div class="row">
                                    <h4>Poikkeuspäivien aukioloajat</h4>
                                    <p class="form-subtext">Tässä osiossa voit lisätä tai poistaa päivämääriä, jolloin aukioloajat poikkeavat normaalista, sekä määrittää niiden aukioloajat. Jätä aikakentät tyhjiksi, jos toimipiste on suljettu sinä päivänä.</p>
                                </div>

                                <div class="container-fluid" id="exceptiondatescontain">
                                    <?php
                                        if(!empty($location['open_exceptions'])){
                                            $i = 100;
                                            foreach($location['open_exceptions'] as $date => $times){
                                                $now = strtotime(now());
                                                $year = date("Y", $now);
                                                $date_formatted = $year . "-" . $date;
                                                $timeinputvalues = array();
                                                if(is_null($times)){
                                                    array_push($timeinputvalues, "");
                                                    array_push($timeinputvalues, "");
                                                } else {
                                                    $timeinputvalues = $times;
                                                }
                                                
                                                echo '
                                                <div class="container businesshrs-contain exceptiondate-wrap" id="' . $i . '">
                                                    <div class="row dateinputrow">
                                                        <input type="date" class="form-control form-control-lg reservationinput" name="open-exceptions[existing'. $i .'][0]" value="'. $date_formatted .'" required>
                                                    </div>
                                                    <div class="row inputrow dividedrow">
                                                        <div class="col inputcolumn">
                                                            <input type="time" class="form-control form-control-lg reservationinput" name="open-exceptions[existing'. $i .'][1]" value="'. $timeinputvalues[0] .'">
                                                        </div>
                                                        <div class="col inputcolumn">
                                                            <input type="time" class="form-control form-control-lg reservationinput" name="open-exceptions[existing'. $i .'][2]" value="'. $timeinputvalues[1] .'">
                                                        </div>
                                                    </div>
                                                    <div class="row inputrow">
                                                        <button type="button" class="btn btn-primary mb-2 formbutton delete" onclick="deleteExceptionDate('. $i .')">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                ';
                                                $i++;
                                            }
                                        }
                                    ?>
                                </div>

                                <button class="btn btn-primary mb-2 formbutton" onclick="addExceptionDate()" type="button"><i class="fa-solid fa-plus"></i> Lisää poikkeuspäivä</button>

                                <hr class="formdivide">

                                <div class="row">
                                    <h4>Tarjottavat palvelut</h4>
                                    <p class="form-subtext">Valitse palvelut, mitä toimipisteellä on tarjolla minäkin päivänä. Jätä tyhjäksi, jos toimipiste on suljettu sinä päivänä.</p>
                                </div>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Maanantai</h5>
                                    </div>
                                    <div class="row inputrow">
                                        @foreach ($services as $service)
                                        <div class="checkboxcontain">
                                            <input type="checkbox" name="available-ma[]" value="{{ $service['id'] }}" class="checkbox" 
                                            @if (!is_null($location->available_services['ma']))
                                                @if (in_array($service['id'], $location->available_services['ma']))
                                                    checked
                                                @endif
                                            @endif 
                                            @if ($service['available'] == 0)
                                                disabled 
                                            @endif>{{ $service['name'] }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <hr>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Tiistai</h5>
                                    </div>
                                    <div class="row inputrow">
                                        @foreach ($services as $service)
                                        <div class="checkboxcontain">
                                            <input type="checkbox" name="available-ti[]" value="{{ $service['id'] }}" class="checkbox" 
                                            @if (!is_null($location->available_services['ti']))
                                                @if (in_array($service['id'], $location->available_services['ti']))
                                                    checked
                                                @endif
                                            @endif 
                                            @if ($service['available'] == 0)
                                                disabled 
                                            @endif>{{ $service['name'] }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <hr>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Keskiviikko</h5>
                                    </div>
                                    <div class="row inputrow">
                                        @foreach ($services as $service)
                                        <div class="checkboxcontain">
                                            <input type="checkbox" name="available-ke[]" value="{{ $service['id'] }}" class="checkbox" 
                                            @if (!is_null($location->available_services['ke']))
                                                @if (in_array($service['id'], $location->available_services['ke']))
                                                    checked
                                                @endif
                                            @endif 
                                            @if ($service['available'] == 0)
                                                disabled 
                                            @endif>{{ $service['name'] }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <hr>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Torstai</h5>
                                    </div>
                                    <div class="row inputrow">
                                        @foreach ($services as $service)
                                        <div class="checkboxcontain">
                                            <input type="checkbox" name="available-to[]" value="{{ $service['id'] }}" class="checkbox" 
                                            @if (!is_null($location->available_services['to']))
                                                @if (in_array($service['id'], $location->available_services['to']))
                                                    checked
                                                @endif
                                            @endif 
                                            @if ($service['available'] == 0)
                                                disabled 
                                            @endif>{{ $service['name'] }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <hr>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Perjantai</h5>
                                    </div>
                                    <div class="row inputrow">
                                        @foreach ($services as $service)
                                        <div class="checkboxcontain">
                                            <input type="checkbox" name="available-pe[]" value="{{ $service['id'] }}" class="checkbox" 
                                            @if (!is_null($location->available_services['pe']))
                                                @if (in_array($service['id'], $location->available_services['pe']))
                                                    checked
                                                @endif
                                            @endif 
                                            @if ($service['available'] == 0)
                                                disabled 
                                            @endif>{{ $service['name'] }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <hr>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Lauantai</h5>
                                    </div>
                                    <div class="row inputrow">
                                        @foreach ($services as $service)
                                        <div class="checkboxcontain">
                                            <input type="checkbox" name="available-la[]" value="{{ $service['id'] }}" class="checkbox" 
                                            @if (!is_null($location->available_services['la']))
                                                @if (in_array($service['id'], $location->available_services['la']))
                                                    checked
                                                @endif
                                            @endif 
                                            @if ($service['available'] == 0)
                                                disabled 
                                            @endif>{{ $service['name'] }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <hr>

                                <div class="container businesshrs-contain">
                                    <div class="row">
                                        <h5 class="businesshrs-header">Sunnuntai</h5>
                                    </div>
                                    <div class="row inputrow">
                                        @foreach ($services as $service)
                                        <div class="checkboxcontain">
                                            <input type="checkbox" name="available-su[]" value="{{ $service['id'] }}" class="checkbox"
                                            @if (!is_null($location->available_services['su']))
                                                @if (in_array($service['id'], $location->available_services['su']))
                                                    checked
                                                @endif
                                            @endif 
                                            @if ($service['available'] == 0)
                                                disabled 
                                            @endif>{{ $service['name'] }}
                                        </div>
                                        @endforeach
                                    </div>
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
            var i = 0;
            function addExceptionDate(){
                let elementID = i;
                var newContainer = document.createElement("div");
                newContainer.setAttribute("class", "container businesshrs-contain exceptiondate-wrap");
                newContainer.id = elementID;
                var parent = document.getElementById("exceptiondatescontain");
                parent.appendChild(newContainer);

                var dateRow = document.createElement("div");
                dateRow.setAttribute("class", "row dateinputrow");
                newContainer.appendChild(dateRow);

                var date = document.createElement("input");
                date.type = "date";
                date.setAttribute("class", "form-control form-control-lg reservationinput");
                date.setAttribute("name", "open-exceptions[" + elementID + "][0]");
                date.required = true;
                dateRow.appendChild(date);

                var timeRow = document.createElement("div");
                timeRow.setAttribute("class", "row inputrow dividedrow");
                newContainer.appendChild(timeRow);

                var openColumn = document.createElement("div");
                openColumn.setAttribute("class", "col inputcolumn");
                timeRow.appendChild(openColumn);

                var closeColumn = document.createElement("div");
                closeColumn.setAttribute("class", "col inputcolumn");
                timeRow.appendChild(closeColumn);

                var openingTimeInput = document.createElement("input");
                openingTimeInput.type = "time";
                openingTimeInput.setAttribute("class", "form-control form-control-lg reservationinput");
                openingTimeInput.setAttribute("name", "open-exceptions[" + elementID + "][1]");
                openColumn.appendChild(openingTimeInput);

                var closingTimeInput = document.createElement("input");
                closingTimeInput.type = "time";
                closingTimeInput.setAttribute("class", "form-control form-control-lg reservationinput");
                closingTimeInput.setAttribute("name", "open-exceptions[" + elementID + "][2]");
                closeColumn.appendChild(closingTimeInput);

                var deleteRow = document.createElement("div");
                deleteRow.setAttribute("class", "row inputrow");
                newContainer.appendChild(deleteRow);

                var deleteButton = document.createElement("button");
                deleteButton.type = "button";
                deleteButton.onclick = function(){deleteExceptionDate(elementID)};
                deleteButton.innerHTML = '<i class="fa-regular fa-trash-can">';
                deleteButton.setAttribute("class", "btn btn-primary mb-2 formbutton delete");
                deleteRow.appendChild(deleteButton);


                i++;
            }
            function deleteExceptionDate(id){
                var deletedElement = document.getElementById(id);
                deletedElement.remove();
            }
        </script>
        <script src="https://kit.fontawesome.com/ae6398c167.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    </body>