<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Kirjaudu sisään</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/master.css">
    </head>
    <body>
        <div class="container-fluid backdrop">
            <div class="container maincontent">
                <div class="container contentwrap">
                    <div class="row formheader">
                        <h2>Kirjaudu sisään</h2>
                    </div>
                    <div class="row adminloginrow">
                        <div class="adminloginwrap">
                            <form action="/admin/auth" method="post">
                                @csrf
                                <div class="row inputrow">
                                <input class="form-control form-control-lg" type="text" placeholder="Käyttäjätunnus" name="username">
                                </div>
                                <div class="row inputrow">
                                    <input class="form-control form-control-lg" type="password" placeholder="Salasana" name="password">
                                </div>
                                <div class="row inputrow">
                                    <button type="submit" class="btn btn-primary mb-2 formbutton"><i class="fa-solid fa-arrow-right-to-bracket"></i> Kirjaudu</button>
                                </div>
                            </form>
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