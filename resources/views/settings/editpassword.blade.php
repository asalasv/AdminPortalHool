@extends('layouts.app')

@section('htmlheader_title')
Cambiar Contraseña
@endsection


@section('main-content')

<div class="row">
	<div class="col-md-12">
		<!-- AREA CHART -->
		<div class="box box-primary">
			{!! Form::open (['route'=> 'changepass', 'method' => 'put', 'class'=>'form-horizontal']) !!}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="box-header">
				<i class='fa fa-lock'></i><h3 class="box-title">Cambiar Contraseña</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<div class="col-xs-6">
						<label for="exampleInputPassword1">Contraseña Nueva</label>
						<div class="input-group">
							<input id="pass1" type="password" name="password" class="form-control" placeholder="Password"/>
							<span class="input-group-addon" id="span1"><i class="fa fa-exclamation-circle"></i></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<label for="exampleInputPassword1">Verificar la contraseña nueva</label>
						<div class="input-group">
							<input id="pass2" type="password" class="form-control" placeholder="Password"/>
							<span class="input-group-addon" id="span2"><i class="fa fa-exclamation-circle"></i></span>
						</div>
						<p class="help-block" id="allert" style="color:red; padding-left: 8px;"></p>
					</div>	
				</div>
				<div class="col-xs-2" style="padding-left: 0px;">
					<button type="submit" class="btn btn-block btn-primary" id="cambiar">Cambiar Contraseña</button>
				</div>
			</div>
			{!! Form::close()!!}
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>

	{!! Form::open(['route' => ['deleteusuario', ':USER_ID'], 'method' =>'delete', 'id' => 'form-delete']) !!}
	{!!Form::close() !!}

	{!! Form::open(['route' => ['postusuario', ':Email'], 'method' =>'post', 'id' => 'form-post']) !!}
	{!!Form::close() !!}

	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).ready(function(){

			$('#cambiar').prop('disabled', true)

			$('#pass1').on('input',function(e){
				var password1 = $('#pass1').val();
				var password2 = $('#pass2').val();

				if(password1 == password2){
					$('#allert').text('');
					$('#span1').html('<i class="fa fa-check"></i>');
					$('#span2').html('<i class="fa fa-check"></i>');
					$('#cambiar').prop('disabled', false);
					// habilitar boton cambiar
					
				}else{
					$('#allert').text('Las contraseñas no coinciden');
					$('#span1').html('<i class="fa fa-times-circle-o"></i>');
					$('#span2').html('<i class="fa fa-times-circle-o"></i>');
					$('#cambiar').prop('disabled', true);
					// disable boton cambiar
				}
			});


			$('#pass2').on('input',function(e){
				var password1 = $('#pass1').val();
				var password2 = $('#pass2').val();

				if(password1 == password2){
					$('#allert').text('');
					$('#span1').html('<i class="fa fa-check"></i>');
					$('#span2').html('<i class="fa fa-check"></i>');
					$('#cambiar').prop('disabled', false);
					// habilitar boton cambiar
					
				}else{
					$('#allert').text('las contraseñas no coinciden');
					$('#span1').html('<i class="fa fa-times-circle-o"></i>');
					$('#span2').html('<i class="fa fa-times-circle-o"></i>');
					$('#cambiar').prop('disabled', true);
					// disable boton cambiar
				}
			});


			$('#btn-add').click(function(){
				var form = $('#form-post');
				var email= $("#Email").val();
				var url = form.attr('action').replace(':Email',email);
				var data = form.serialize();

				if(email==""){
					alert("Ingrese un email por favor")
				}else{
					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){

							if(data==""){
								alert(email+' no se encuentra en nuestros registros');
							}
							if (data == "refresh"){
							    	window.location.reload(); // This is not jQuery but simple plain ol' JS
							    }
							    console.log(data);
							}
						});
				}
			});

		});

	</script>

	@endsection

