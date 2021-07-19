<?php
include "configs/config.php";
include "configs/funciones.php";

if (!isset($p)) {
    $p = "inicio";
} else {
    $p = $p;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/8ae4b535da.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>      
    <script type="text/javascript" src="js/app.js"></script>
    <title>Tienda online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="header"> <span style="font-size:20px;cursor:pointer;" id="abrirMenu" onclick="openNav()">&#9776;</span>
        <a id="headertext" href="?p=inicio">Tienda online</a></div>
    <nav id="menu">
        <li><a href="#"><i class="icon icon-tag"></i>MENU</a>
            <ul>
                <li><a href="?p=shop">Shop</a></li>
                <li><a href="?p=cart">Cart</a></li>
                <li><a href="?p=about">About</a></li>
                <li><a href="?p=contact">Contact</a></li>
            </ul>
        </li>
    </nav>
    <!--Nuevo menu-->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="?p=shop">Shop</a>
        <a href="?p=cart">Cart</a>
        <a href="?p=about">About</a>
        <a href="?p=contact">Contact</a>
    </div>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
    <!--Nuevo menu-->

    <div class="cuerpo">
        <?php
        if (file_exists("modulos/" . $p . ".php")) {
            include "modulos/" . $p . ".php";
        } else {
            echo "<i>No se ha encontrado <b>" . $p . ".</b></i>";
        }
        ?>
    </div>

    <div class="footer">
        Copyright RaulBlazquez &copy; <?= date("Y") ?>
        |
        <a id="administrador" class="pull-right" href="?p=admin">Administrador</a>
    </div>

</body>

</html>