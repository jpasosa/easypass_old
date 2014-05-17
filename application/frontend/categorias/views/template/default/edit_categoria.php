<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="bs-docs-container">
	<a class="lead" id="desplegar-form">Edición de Categoria</a>

	<!-- ERRORES -->
	<br />
	<?php if (count($errores_validacion) > 0): ?>
		<div class="alert alert-danger">
			<?php foreach ($errores_validacion AS $err): ?>
				<?php echo $err; ?><br />
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<form method="post" action="<?php echo $url_action; ?>" enctype="multipart/form-data" role="form" autocomplete="off" id="my-form" class="bs-docs-container" >
		<div id="home">
			<div class="form-group">
				<label for="nombre"> Precio Limite (200km) </label>
				<input type="text" class="form-control custom-input-lg" name="precio_limite" id="precio" placeholder="Ingrese el precio limite" value="<?php echo $categoria['precio_limite']?>">
			</div>

			<div class="form-group">
				<label for="nombre"> Precio Ilimitado</label>
				<input type="text" class="form-control custom-input-lg" name="precio_ilimitado" id="precio" placeholder="Ingrese el precio ilimitado" value="<?php echo $categoria['precio_ilimitado']?>">
			</div>


			<div class="form-group">
				<label for="nombre">Nombre Ingles</label>
				<input type="text" class="form-control custom-input-lg" name="nombre_en" id="marca" placeholder="Ingrese el nombre en Ingles" value="<?php echo $categoria['nombre_en']?>">
			</div>
			<div class="form-group">
				<label for="nombre">Nombre Español</label>
				<input type="text" class="form-control custom-input-lg" name="nombre_es" id="marca" placeholder="Ingrese el nombre en Español" value="<?php echo $categoria['nombre_es']?>">
			</div>

			<div class="form-group">
				<label for="nombre">Estado</label>
				<select class="form-control custom-input-lg" name="estado" id="estado" placeholder="estado de la categoria" >
					<option value="0" <?php if ($categoria['estado'] == 0): echo 'selected="selected"';endif; ?> >Inactivo</option>
					<option value="1" <?php if ($categoria['estado'] == 1): echo 'selected="selected"';endif; ?> >Activo</option>
				</select>
			</div>

			<?php if(isset($categoria['id_categoria'])):?>
				<input type="hidden"  name="id_categoria" value="<?php echo $categoria['id_categoria']?>">
			<?php endif;?>

			<button type="submit" class="btn btn-default">Guardar datos</button>
		</div>
	</form>





<script type="text/javascript">
	$(function(){
		$('.delete').bind('click',function(e){
			var id = $(this).data('id');
			console.log(id);
		});
	});
</script>



<script src="<?php echo PUBLIC_FOLDER;?>assets/chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo PUBLIC_FOLDER;?>assets/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	var config = {
		'.chosen-select'           : {},
		'.chosen-select-deselect'  : {allow_single_deselect:true},
		'.chosen-select-no-single' : {disable_search_threshold:10},
		'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		'.chosen-select-width'     : {width:"95%"}
	}
	for (var selector in config) {
		$(selector).chosen(config[selector]);
	}
</script>

</div>