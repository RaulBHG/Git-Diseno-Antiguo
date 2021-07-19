<?php 
$q = mysqli_query($con, "SELECT * FROM productos");
check_admin();
//FULL DELETE
if (isset($_GET['fullDel'])) {
	$id = $_GET['fullDel'];
	mysqli_query($con, "DELETE FROM productos WHERE id=$id");
	redir("./?p=editar_productos");
}

//EDIT
if (isset($_GET['edit'])) {
	$id = $_GET['edit'];
	$qEdit = mysqli_query($con, "SELECT * FROM productos WHERE id = '$id'");
	$r = mysqli_fetch_array($qEdit);

	//EDITAR BUTTON

	if (isset($editar)) {
		$name = clear($name);
		$description = clear($description);
		$price = clear($price);
		$cant = clear($cant);
		$type = clear($type);

		$imagen = "";
		$imagenes = "";

		// File upload configuration 
		$arrayImagenes = [];
		foreach ($_FILES['imagenes']['tmp_name'] as $key => $image) {
			$imageTmpName = $_FILES['imagenes']['tmp_name'][$key];
			$imageName = $name . $_FILES['imagenes']['name'][$key];
			$result = move_uploaded_file($imageTmpName, "productos/" . $imageName);
			array_push($arrayImagenes, $imageName);
		}
		$stringImagenes = implode(",", $arrayImagenes);
		if ($imageTmpName == "") {
			$stringEditImg = $r["imagenes"];
		} else {
			$stringEditImg = $r["imagenes"] . "," . $stringImagenes;
		}
		//Fin test

		if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
			$imagen = $name . rand(0, 1000) . ".png";
			move_uploaded_file($_FILES['imagen']['tmp_name'], "productos/" . $imagen);
			mysqli_query($con, "UPDATE productos SET name='$name', description='$description', price='$price', imagen='$imagen', imagenes='$stringEditImg', cantidad='$cant', type='$type' WHERE id=$id");
		} else {
			mysqli_query($con, "UPDATE productos SET name='$name', description='$description', price='$price', imagenes='$stringEditImg', cantidad='$cant', type='$type' WHERE id=$id");
		}

?>
		<script>
			Swal.fire({
				position: 'top-end',
				icon: 'success',
				title: 'Your work has been saved',
				showConfirmButton: false,
				timer: 1500
			}).then(function() {
				window.location.replace("./?p=editar_productos");
			});
		</script>
	<?php
	}

	//FIN EDITAR BUTTON
	?>
	<form method="post" action="" enctype="multipart/form-data">
		<div class="centrarlog" id="transEdit">
			<div class="form-group">
				<input type="text" class="form-control" name="name" placeholder="Name of the product" value="<?= $r['name'] ?>" required>
			</div>

			<div class="form-group">
				<textarea type="text" class="form-control" rows="3" name="description" placeholder="Description of the product" required><?= $r['description'] ?></textarea>
			</div>

			<div class="form-group">
				<input type="number" class="form-control" name="price" placeholder="Price" maxlength="5" value="<?= $r['price'] ?>" required>
			</div>

			<label>Cambiar portada</label>
			<div class="form-group">
				<input type="file" class="form-control-file" style="max-width: 50%;" name="imagen" title="Portada del producto" placeholder="Image">
			</div>

			<div class="form-group">
				<input type="file" class="form-control-file" style="max-width: 50%;" name="imagenes[]" title="Imagenes de muestra" placeholder="Images" multiple>
			</div>

			<label>Cantidad:</label>
			<div class="form-group">
				<input type="number" class="form-control" name="cant" placeholder="Cant" maxlength="5" value="<?= $r['cantidad'] ?>" required>
			</div>

			<label>Tipo de producto:</label>
			<div class="form-group">
				<select name="type" id="type" class="btn btn-secondary dropdown-toggle form-control" required>
					<option value="copy">Copia</option>
					<option value="original">Original</option>
				</select>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-success" name="editar">Update product</button>
			</div>
		</div>
	</form>
	<script>
		var edit = document.getElementById("transEdit");
		edit.style.visibility = "visible";
		edit.style.height = "590px";
		if ("<?= $r['type'] ?>" == "original") {
			var selectElement = document.getElementById("type");
			selectElement.selectedIndex = 1;
		}
	</script>
<?php

}


//DELETE
if (isset($_GET['del'])) {
	$id = $_GET['del'];
?>
	<script>
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				
				Swal.fire(
					'Deleted!',
					'Your product has been deleted.',
					'success'
				).then(function() {
					window.location.replace("./?p=editar_productos&fullDel=<?php echo $id; ?>");
				});
			} else {
				window.location.replace("./?p=editar_productos");
			}
		})
	</script>
<?php
}
?>

<table>
	<thead>
		<tr class="mainTR">
			<th>Image</th>
			<th>Name</th>
			<th>Cant</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>

	<?php while ($r = mysqli_fetch_array($q)) { ?>
		<tr>
			<td><img class="img_edit" src="productos/<?= $r['imagen'] ?>" /></td>
			<td><?php echo $r['name']; ?></td>
			<td><?php echo $r['cantidad']; ?></td>
			<td>
				<a href="?p=editar_productos&edit=<?php echo $r['id']; ?>" class="btn btn-success">Edit</a>
			</td>
			<td>
				<a href="?p=editar_productos&del=<?php echo $r['id']; ?>" onclick="deleteProd()" class="btn btn-danger">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>