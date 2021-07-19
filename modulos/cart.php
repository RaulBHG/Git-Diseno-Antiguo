<table class=" table table - striped tablaCart">
    <tr id="principal">
        <th>Imagen producto</th>
        <th>Nombre del producto</th>
        <th>Cantidad</th>
        <th>Precio por unidad</th>
        <th>Precio total</th>
    </tr>



    <?php

    $divisa = "€";
    $monto_total = 0;
    if (isset($_SESSION['CARRITO'])) {
        //$id_cliente = clear($_SESSION['id_cliente']);
        /*$id_cliente = 1;*/
        //session_destroy();
        $listaProd = $_SESSION['CARRITO'];
        for ($x = 0; $x < count($listaProd); $x++) {
            $id = $listaProd[$x]['ID'];
            $q = mysqli_query($con, " SELECT * FROM productos where id = '$id'");
            $r = mysqli_fetch_array($q);
            $nombre_producto = $r['name'];
            $cantidad = $listaProd[$x]['CANT'];;
            $precio_unidad = $r['price'];
            $precio_total = $cantidad * $precio_unidad;
            $imagen_producto = $r['imagen'];

            $monto_total = $monto_total + $precio_total;




    ?>
            <tr>
                <td><img class="imagen_carro" src="productos/<?= $imagen_producto ?>" /></td>
                <td><?= $nombre_producto ?></td>
                <td><?= $cantidad ?></td>
                <td><?= $precio_unidad ?> <?= $divisa ?></td>
                <td><?= $precio_total ?> <?= $divisa ?></td>
            </tr>
    <?php
        }
    }
    ?>
</table>

<br>
<h2>Monto total: <b class="texto_monto"><?= $monto_total ?> <?= $divisa ?> </b></h2><br>