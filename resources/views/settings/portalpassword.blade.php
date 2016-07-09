@extends('layouts.app')

@section('htmlheader_title')
Cambiar Contraseña
@endsection

@section('main-content')

<div class="row">
	<div class="col-md-12">
		<!-- AREA CHART -->
		<div class="box box-primary">
			{!! Form::open (['route'=> 'updateportalpass', 'method' => 'put', 'class'=>'form-horizontal']) !!}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="box-header">
				<i class='fa fa-lock'></i><h3 class="box-title">Cambiar Contraseña del Portal</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<div class="col-xs-6">
						<label for="exampleInputPassword1">Contraseña Nueva</label>
						<div class="input-group">
							<input id="pass1" type="text" name="password" class="form-control" placeholder="Password"/>
							<span class="input-group-addon" id="span1"><i class="fa fa-exclamation-circle"></i></span>
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

	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).ready(function(){


			$(function(){
				$('#menu-config').addClass('active')
				$('#menu-wifi').addClass('active'); 
			});

			$('#cambiar').prop('disabled', true)

			$('#pass1').on('input',function(e){
				var password1 = $('#pass1').val();

				if( $.trim(password1) == '' ){
					$('#allert').text('La contraseña no pueden estar en blanco');
					$('#span1').html('<i class="fa fa-times-circle-o"></i>');
					$('#cambiar').prop('disabled', true);

				}else{
					$('#allert').text('');
					$('#span1').html('<i class="fa fa-check"></i>');
					$('#cambiar').prop('disabled', false);
					// habilitar boton cambiar

				}
			});
		});

	</script>

	@endsection