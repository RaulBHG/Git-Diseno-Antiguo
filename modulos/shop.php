<div class="container">
    <div class="row">
        <script>
            function error($mensaje) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: $mensaje,
                    footer: '<a href="?p=cart">Ir a la cesta.</a>'
                })
            }

            function success() {
                Swal.fire({
                    icon: 'success',
                    title: 'Perfecto',
                    text: 'Ha añadido el producto a la cesta.',
                    footer: '<a href="?p=cart">Ir a la cesta.</a>'
                })
            }
        </script>

        <?php
        if (isset($enviarOriginal)) {
            $cant = 1;
            $id = $see;
            $añadido = false;
            if (isset($_SESSION['CARRITO'])) {
                for ($x = 0; $x < count($_SESSION['CARRITO']); $x++) {
                    if ($_SESSION['CARRITO'][$x] == $id) {
                        $añadido = true;
                    }
                }
            }
            if (!$añadido) {
                addCest($cant, $id);
                echo '<script type="text/javascript">',
                    'success();',
                    '</script>';
            } else {
                echo '<script type="text/javascript">',
                    'error("Ya has añadido ese producto.");',
                    '</script>';
            }
        }
        if (isset($enviar)) {
            $cant = clear($cant);
            $id = $see;
            addCest($cant, $id);
            echo '<script type="text/javascript">',
                    'success();',
                    '</script>';
        }

        if (isset($see)) {
            $q = mysqli_query($con, "SELECT * FROM productos WHERE id = '$see'");
            $r = mysqli_fetch_array($q);

            $stringImages = $r['imagenes'];
            $arrayImages = explode(",", $stringImages);
        ?>
            <div class="popup" id="popup-1">
                <div class="overlay"></div>
                <div class="content">
                    <div class="close-btn" onclick="togglePopup()">&times;</div>

                    <!--Slider-->


                    <div id="carouselExampleIndicators" class="carousel slide img_see vertical-center" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <?php
                            for ($i = 1; $i < count($arrayImages); $i++) {
                                $posi = strval($i);
                            ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to=<?= $posi ?>></li>
                            <?php
                            }
                            ?>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="productos/<?= $arrayImages[0] ?>" class="d-block w-100" alt="...">
                            </div>
                            <?php
                            for ($i = 1; $i < count($arrayImages); $i++) {
                            ?>
                                <div class="carousel-item">
                                    <img src="productos/<?= $arrayImages[$i] ?>" class="d-block w-100" alt="...">
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>


                    <!--Slider-->

                    <div class="info_prod vertical-center" style="max-width: 50%;">
                        <h1><?= $r['name'] ?></h1>
                        <div>
                            <p><?= $r['description'] ?></p>
                        </div>
                    </div>
                    <?php
                    if ($r['type'] == "original") {
                        # code...
                    ?>
                        <form name="formCant" method="post" action="#" enctype="multipart/form-data">

                            <div style="position:absolute; bottom:5%; right:29%; color:black; max-width: 30%;">
                                <h5 class="p-3 mb-2 bg-info text-white">Este producto es el original, solo puedes comprar 1 unidad.</h5>
                            </div>
                            <button class="btn btn-submit&&btn btn-dark" type="submit" name="enviarOriginal" style="position:absolute; bottom:10%; right:9%;"><i class="fa fa-cart-plus" style="background:transparent;"></i> Add to card</button>
                        </form>
                    <?php
                    } else {
                    ?>
                        <form class="formComprar" name="formCant" method="post" action="#" enctype="multipart/form-data">
                            <div style="position:absolute; bottom:10%; right:29%; color:black; max-width: 30%;">
                                <p class="text-success"><?= $r['cantidad'] ?> unidades disponibles.</p>
                                <input type="number" class="form-control" id="cant" name="cant" placeholder="Cant" min="1" max="<?= $r['cantidad'] ?>" required>
                            </div>
                            <button class="btn btn-submit&&btn btn-dark" name="enviar" type="submit" style="position:absolute; bottom:10%; right:9%;"><i class="fa fa-cart-plus" style="background:transparent;"></i> Add to card</button>
                        </form>
                    <?php
                    }
                    ?>

                </div>
            </div>
        <?php
            echo ("<script type='text/javascript'>" .
                "document.getElementById('popup-1').classList.toggle('active');" .
                "</script>");
        }


        $q = mysqli_query($con, "SELECT * FROM productos ORDER BY id DESC");
        while ($r = mysqli_fetch_array($q)) {
        ?>
            <div class="col-md-3">
                <div class="producto" onclick="togglePopup('<?= $r['id'] ?>')">
                    <div class="div_producto"><img class="img_producto" src="productos/<?= $r['imagen'] ?>" /></div>
                    <div class="name_producto"><?= $r['name'] ?></div>
                    <div class="name_producto_hover">
                        <h4><?= $r['name'] ?></h5>
                            <p><?= $r['price'] ?>€</p>
                    </div>
                </div>
            </div>

        <?php
        }
        ?>
        <script>
            function togglePopup(id) {
                if (id != undefined) {
                    window.location = "?p=shop&see=" + id;
                    //localStorage.clear();
                } else {
                    window.location = "?p=shop";
                }
            }
        </script>
    </div>
</div>