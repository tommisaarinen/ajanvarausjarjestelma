<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Muokkaa asiakastiliä</title>
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
                            <h2 class="dashboardheader">Muokkaa asiakastiliä</h2>
                            <a href="/admin/logout" class="logoutbutton">Kirjaudu ulos <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                        </div>        
                    </div>
                    <hr>
                    <div class="row formwrap">
                        <div class="container-fluid formcontainer">
                            <form action="/admin/updatecustomer" method="post">
                                @csrf
                                <input type="hidden" name="cstmr_id" value="{{ $customer->id }}">
                                <div class="row inputrow">
                                    <input type="text" class="form-control form-control-lg" name="fname" placeholder="Etunimi" value="{{ $customer->firstname }}" required>
                                </div>
                                <div class="row inputrow">
                                    <input type="text" class="form-control form-control-lg" name="lname" placeholder="Sukunimi" value="{{ $customer->lastname }}" required>
                                </div>
                                <div class="row inputrow">
                                    <input type="email" class="form-control form-control-lg" name="email" placeholder="Sähköposti" value="{{ $customer->email }}" required>
                                </div>
                                <div class="row inputrow dividedrow">
                                    <div class="col-7 inputcol divide-left">
                                        <input type="tel" class="form-control form-control-lg" name="phone" placeholder="Puhelinnumero" value="{{ $customer->phone }}" required>
                                    </div>
                                    <div class="col inputcol nopad">
                                        <input type="text" class="form-control form-control-lg" name="authcode" placeholder="Tunnist. koodi" value="{{ $customer->authcode }}" required>
                                    </div>
                                </div>
                                <div class="row inputrow">
                                <button type="submit" class="btn btn-primary mb-2 formbutton"><i class="fa-regular fa-floppy-disk"></i> Tallenna muutokset</button>
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