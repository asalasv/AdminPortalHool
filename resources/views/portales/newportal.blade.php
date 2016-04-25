@extends('layouts.app')

@section('htmlheader_title')
Nuevo Portal
@endsection


@section('main-content')

<div class="row">
	<div class="col-md-12">
		<!-- AREA CHART -->
		<div class="box box-primary">
			<div class="box-body">
				<div class="box-header">
					<i class='fa fa-desktop'></i><h3 class="box-title">Nuevo Portal</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					{!! Form::open (['route'=> 'newportal', 'method' => 'post', 'class'=>'form-horizontal', 'files'=>true, 'enctype'=>'multipart/form-data', 'onsubmit' => 'return formulario(this)']) !!}
					<div class="row">
						<div class="col-xs-9">
							<label class="control-label" for="date">Descripcion o nombre del portal</label>
							<input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Nombre"></input>
						</div>
						<div class="col-xs-3">
							<label class="control-label" for="date">Predeterminado</label>
							<div class="checkbox" style="margin-top: 0px;">
								<label>
									<input type="checkbox" name="predeterminado" id="check"> Marcar si desea que este portal sea el predeterminado
								</label>
							</div>
						</div>
					</div>
					<div class="bootstrap-iso">
						<div class="row" style="padding-top: 10px;">
							<div class="form col-xs-6"> <!-- Date input -->
								<label class="control-label" for="date"><i class="fa fa-calendar-check-o"></i>&nbsp;Fecha Inicio</label>
								<input class="form-control" id="fecha_inicio" name="fecha_inicio" placeholder="MM/DD/YYY" type="text"/>
							</div>
							<div class="form col-xs-6"> <!-- Date input -->
								<label class="control-label" for="date"><i class="fa  fa-calendar-times-o"></i>&nbsp;Fecha Fin</label>
								<input class="form-control" id="fecha_fin" name="fecha_fin" placeholder="MM/DD/YYY" type="text"/>
							</div>
						</div>
					</div>	
					<div class="row">
						<div class="form col-xs-6">
							<label class="control-label" for="date"><i class="fa fa-clock-o"></i>&nbsp;Hora Inicio</label>
							<input class="form-control"  name="hora_inicio" id="hora_inicio" value="" data-default="20:48">
						</div>
						<div class="form col-xs-6">
							<label class="control-label" for="date"><i class="fa fa-clock-o"></i>&nbsp;Hora Fin</label>
							<input class="form-control" name="hora_fin" id="hora_fin" value="" data-default="20:48">
						</div>
					</div>
					<div class="row">
						<h4 style="padding-left: 15px; margin-top: 20px;"><i class="fa fa-file-image-o"></i>&nbsp;Imágenes</h4>
					</div>
					<div class="row " style="padding-top: 7px;">
						<div class="form col-xs-12">
							<label for="exampleInputFile">Imagen Publicidad &nbsp;</label><small>(Máx. 100 Kb)</small>
							<input type="file" class="input-file" id="imagen_publicidad" name="imagen_publicidad" size="100">
						</div>
					</div>
					<div class="row" style="padding-top: 7px;">
						<div class="form col-xs-12">
							<label for="exampleInputFile">Logo Local &nbsp;</label><small>(Máx. 25 Kb)</small>
							<input type="file" class="input-file" id="imagen_logo" name="imagen_logo" size="25">
						</div>
					</div>
					<div class="row" style="padding-top: 7px;">
						<div class="form col-xs-12">
							<label for="exampleInputFile">Imagen Fondo &nbsp;</label><small>(Máx. 60 Kb)</small>
							<input type="file" class="input-file" id="imagen_fondo" name="imagen_fondo" size="60">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="crear">Crear Portal</button>
			</div>
			{!! Form::close()!!}

		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</div>
</div>

<script type="text/javascript">

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var hora_inicio = $('#hora_inicio');
	hora_inicio.clockpicker({
		autoclose: true
	});
	var hora_fin = $('#hora_fin');
	hora_fin.clockpicker({
		autoclose: true
	});

    var vhasta=$('input[name="fecha_fin"]'); //our date input has the name "date"
    var vdesde=$('input[name="fecha_inicio"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
    	format: 'yyyy/mm/dd',
    	container: container,
    	todayHighlight: true,
    	autoclose: true,
    };
    vdesde.datepicker(options); //initiali110/26/2015 8:20:59 PM ze plugin
    vhasta.datepicker(options); //initiali110/26/2015 8:20:59 PM ze plugin

    $(document).ready(function(){

    	var predeterminado = false;

    	$('#check').change(function(){
    		if ($('#check').is(':checked') == true){
    			$('#fecha_inicio').prop('disabled', true);
    			$('#fecha_fin').prop('disabled', true);
    			$('#hora_inicio').prop('disabled', true);
    			$('#hora_fin').prop('disabled', true);
    			predeterminado = true;
    			console.log('checked');
    		} else {
    			$('#fecha_inicio').prop('disabled', false);
    			$('#fecha_fin').prop('disabled', false);
    			$('#hora_inicio').prop('disabled', false);
    			$('#hora_fin').prop('disabled', false);
    			console.log('unchecked');
    			predeterminado = false;
    		}
    	});

    	/* Valida el tamaño maximo y formato de un archivo adjunto */
    	$('.input-file').change(function (){
    		var file = this.files[0]; 
    		var filename = file.name;

    		var extension = filename.substr( (filename.lastIndexOf('.') +1) );

    		switch(extension) {
    			case 'jpg':
    			case 'png':
    			var sizeByte = this.files[0].size;

    			var siezekiloByte = parseInt(sizeByte / 1024);

    			if(siezekiloByte > $(this).attr('size')){
    				alert('El tamaño supera el limite permitido ('+$(this).attr('size')+' Kb)');
    				$(this).val('');
    			}
    			break;
    			default:
    			alert("El formato debe ser '.jpg' o '.png'");
    			$(this).val('');
    		}
    	});
    });

    function formulario(f) { 
    	if (f.descripcion.value   == '') { 
    		alert ('El campo descripcion/nombre esta vacío');  
    		f.descripcion.focus(); 
    		return false; 
    	}else{
    		alert('Su portal ha sido creado con éxito!');
    	}
    }

</script>

@endsection

