<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Hallintapaneeli</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/master.css">
        <link rel="stylesheet" href="../css/dashboard.css">
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="container-fluid backdrop">
            <div class="container maincontent">
                <div class="container contentwrap">
                    <div class="row dashboard-toprow">
                        <div class="dashboard-toprow-wrap">
                            <h2 class="dashboardheader">Valvojan työkalut</h2>
                            <a href="/admin/logout" class="logoutbutton">Kirjaudu ulos <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                        </div>
                                    
                    </div>
                    <div class="row">
                        <div class="container">
                            <div id="app">
                                <?php 
                                    $token = csrf_token(); 
                                ?>
                                <admin-tools
                                    :reservations='@json($reservations)'
                                    :customers='@json($customers)'
                                    :locations='@json($locations)'
                                    :admins='@json($admins)'
                                    :services='@json($services)'
                                    :directTo='@json($directTo)'
                                    :token='@json($token)'
                                    ></admin-tools>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                    </div>
                </div>
            </div>
        </div>
        <script src="https://kit.fontawesome.com/ae6398c167.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    </body>
</html>