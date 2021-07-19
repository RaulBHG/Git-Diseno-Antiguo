<?php
check_admin();

if (isset($enviar)) {
    $name = clear($name);
    $description = clear($description);
    $price = clear($price);
    $cant = clear($cant);
    $type = clear($type);

    $imagen = "";
    $imagenes = "";

    if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
        $imagen = $name . rand(0, 1000) . ".png";
        move_uploaded_file($_FILES['imagen']['tmp_name'], "productos/" . $imagen);
    }


    //Test multiples imagenes

    // File upload configuration 
    $arrayImagenes = [];
    foreach ($_FILES['imagenes']['tmp_name'] as $key => $image) {
        $imageTmpName = $_FILES['imagenes']['tmp_name'][$key];
        $imageName = $name . $_FILES['imagenes']['name'][$key];
        $result = move_uploaded_file($imageTmpName, "productos/" . $imageName);
        array_push($arrayImagenes, $imageName);
    }
    $stringImagenes = implode(",", $arrayImagenes);
    //Fin test


    mysqli_query($con, "INSERT INTO productos (name, description, price, imagen, imagenes, cantidad, type) VALUES ('$name', '$description', '$price', '$imagen', '$stringImagenes', '$cant', '$type')");
?>
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Your work has been saved',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            window.location.replace("./?p=agregar_productos");
        });
    </script>
<?php
}

?>
<form method="post" action="" enctype="multipart/form-data">
    <div class="centrarlog">
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Name of the product" required>
        </div>

        <div class="form-group">
            <textarea type="text" class="form-control" rows="3" name="description" placeholder="Description of the product" required></textarea>
        </div>

        <div class="form-group">
            <input type="number" class="form-control" name="price" placeholder="Price" maxlength="5" required>
        </div>

        <label>Inserta foto</label>
        <div class="form-group">
            <input type="file" class="form-control-file" style="max-width: 50%;" name="imagen" title="Portada del producto" placeholder="Image" required>
        </div>

        <div class="form-group">
            <input type="file" class="form-control-file" style="max-width: 50%;" name="imagenes[]" title="Imagenes de muestra" placeholder="Images" multiple required>
        </div>

        <label>Cantidad de productos que estarán disponibles:</label>
        <div class="form-group">
            <input type="number" class="form-control" name="cant" placeholder="Cant" maxlength="5" required>
        </div>

        <label>Tipo de producto:</label>
        <div class="form-group">
            <select name="type" class="btn btn-secondary dropdown-toggle form-control" required>
                <option value="copy">Copia</option>
                <option value="original">Original</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success" name="enviar">Add product</button>
        </div>
    </div>
</form>