<?php

if (isset($enviar)) {
    $user = clear($user);
    $password = clear($password);

    $q = mysqli_query($con, "SELECT * FROM admins WHERE user = '$user' AND password = '$password'");

    if (mysqli_num_rows($q) > 0) {
        $r = mysqli_fetch_array($q);
        $_SESSION['id'] = $r['id'];
        redir("?p=admin");
    } else {
        alert("Los datos introducidos no son válidos.");
        redir("?p=admin");
    }
}

if (isset($logout)) {
    session_destroy();
    redir("?p=admin");
}

if (isset($_SESSION['id'])) { //con sesión iniciada
?>
    <div class="centrarlog">
            <a href="?p=agregar_productos">
                <button class="btn btn-submit&&btn btn-dark margin"><i class="fa fa-plus-circle" style="background:transparent;"></i> Add product</button>
            </a>
            <a href="?p=editar_productos">
                <button class="btn btn-submit&&btn btn-dark margin"><i class="fa fa-edit" style="background:transparent;"></i> Edit product</button>
            </a>
            <form method="post" action="">
                <button class="btn btn-danger margin" name="logout" type="submit">Logout</button>
            </form>
    </div>
<?php

} else { //sin sesión iniciada 
?>
    <form method="post" action="">
        <div class="centrarlog">
            <label>
                <h5><i class="fa fa-key"></i> Inicio de administradores</h5>
            </label>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="User name" name="user" />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" />
            </div>
            <div class="form-group">
                <button class="btn btn-submit&&btn btn-dark" name="enviar" type="submit"><i class="fas fa-sign-in-alt" style="background:transparent;"> </i> Loggin</button>
            </div>
        </div>
    </form>
<?php
}
?>