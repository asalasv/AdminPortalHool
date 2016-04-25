	@extends('layouts.app')

	@section('htmlheader_title')
	Usuarios Registrados
	@endsection


	@section('main-content')

	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<i class="fa fa-cog"></i><h3 class="box-title">Tipo de cliente</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body">
					<div class="col-xs-5" id="tipomensaje" style="vertical-align: middle;">
						@if($cliente->privado == 'V')
						<i class="fa fa-lock" style="font-size: 20px"></i>&nbsp;Actualmente este Portal se encuentra configurado como <b>Privado</b>
						<input type="hidden" id="tipo" value="privado"></input>
						@else
						<i class="fa fa-unlock" style="font-size: 20px"></i>&nbsp;Actualmente este Portal se encuentra configurado como <b>Publico</b>
						<input type="hidden" id="tipo" value="publico"></input>
						@endif
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<div class="col-xs-2">
						<button type="button" id="cambiar" class="btn btn-block btn-primary btn-sm">
							@if($cliente->privado == 'V')
							Cambiar a Público
							@else
							Cambiar a Privado
							@endif
						</button>
					</div>
					
				</div>
				<!-- /.box-footer-->
			</div>
			<!-- AREA CHART -->
			<div class="box box-primary" id="usertable">
				<div class="box-body">
					<div class="box-header">
						<i class='fa fa-users'></i><h3 class="box-title">Usuarios</h3>
						<div class="box-tools">
							<div class="input-group" style="width: 50px;">
								<!-- Button trigger modal -->
								<button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
									<i class="fa fa-user-plus"></i>
								</button>
							</div>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table class="table table-hover">
							<tr>
								<th>Email</th>
								<th>Estatus</th>
							</tr>
							@foreach($usuarios as $user)
							<tr data-id="{{ $user->id_usuario_ph}}" data-name ="{{$user->nombre}}">
								<td>{{$user->email}}</td>
								@if($user->status == '1' || $user->status == '2')
								<td><span class="label label-success">Activo</span></td>
								@elseif($user->status == '0')
								<td><span class="label label-danger">Bloqueado por PortalHook</span></td>
								@elseif($user->status == '3')
								<td><span class="label label-warning">Dado de baja</span></td>
								@endif
								<td><a href="#" class="btn-delete"><i class="fa fa-fw fa-user-times"></i></i>Eliminar</a></td>
								@endforeach
							</table>
							{!! $usuarios->render() !!}
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Agregar Usuario</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-xs-12">
									<label for="exampleInputEmail1">Email address</label>
									<div class="input-group">
										<input type="email" class="form-control" id="Email" placeholder="Email">
										<span class="input-group-addon" id="span2"><i class="fa fa-exclamation-circle"></i></span>
									</div>
									<p class="help-block" id="allert" style="color:red; padding-left: 8px;"></p>
									<p class="help-block" id="goodallert" style="color:green; padding-left: 8px;"></p>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" id="close" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="btn-add">Agregar</button>
						</div>
					</div>
				</div>
			</div>

			{!! Form::open(['route' => ['deleteusuario', ':USER_ID'], 'method' =>'delete', 'id' => 'form-delete']) !!}
			{!!Form::close() !!}

			{!! Form::open(['route' => ['postusuario', ':Email'], 'method' =>'post', 'id' => 'form-post']) !!}
			{!!Form::close() !!}

			{!! Form::open(['route' => ['verifyemail', ':Email'], 'method' =>'get', 'id' => 'form-get']) !!}
			{!!Form::close() !!}

			{!! Form::open(['route' => ['changestatus'], 'method' =>'post', 'id' => 'form-change']) !!}
			{!!Form::close() !!}

			<script type="text/javascript">
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$(document).ready(function(){

					if($('#tipo').val() == 'privado')
						$("#usertable").show(1000);
					else
						$("#usertable").hide();

					$(document).ajaxStart(function () {
						$("#loading").show();
					}).ajaxStop(function () {
						$("#loading").hide();
					});

					$('#btn-add').prop('disabled', true);

					$('#Email').on('input',function(e){
						var email = $('#Email').val();
						var form = $('#form-get');
						var url = form.attr('action').replace(':Email',email);;
						var data = form.serialize();
						$.ajax({
							type: 'get',
							url: url,
							data: data,
							success: function(data){
								if(data == 'true'){
									$('#allert').text('');
									$('#goodallert').text(' El email "'+email+'" si se encuentra nuestros registros');
									$('#btn-add').prop('disabled', false);
									$('#span2').html('<i class="fa fa-check"></i>');
								}else{
									$('#allert').text(' El email "'+email+'" no coincide con nuestros registros');
									$('#goodallert').text('');
									$('#btn-add').prop('disabled', true);
									$('#span2').html('<i class="fa fa-times-circle-o"></i>');
								}
							}
						});

					});

					$('#close').click(function(){
						$('#allert').text('');
						$('#goodallert').text('');
						$('#span2').html('<i class="fa fa-times-circle-o"></i>');
						$('#btn-add').prop('disabled', true);
					});

					$('#cambiar').click(function(){
						var form = $('#form-change');
						var url = form.attr('action');
						var data = form.serialize();

						$.ajax({
							type: 'post',
							url: url,
							data: data,
							success: function(data){
								alert(data);
								if($('#tipo').val() == 'privado'){
									//console.log('abrimos tabla');
									$("#usertable").hide(1000);
									$( "#tipomensaje" ).html( '<i class="fa fa-unlock" style="font-size: 20px"></i>&nbsp;Actualmente este Portal se encuentra configurado como <b>Público</b><input type="hidden" id="tipo" value="publico"></input>' );
									$('#cambiar').text('Cambiar a Privado');
								}else{
									//console.log('escondemos tabla');
									$("#usertable").show(1000);
									$( "#tipomensaje" ).html( '<i class="fa fa-lock" style="font-size: 20px"></i>&nbsp;Actualmente este Portal se encuentra configurado como <b>Privado</b><input type="hidden" id="tipo" value="privado"></input>' );
									$('#cambiar').text('Cambiar a Público');
								}
							}
						});
					});



					$('.btn-delete').click(function(){
						var row = $(this).parents('tr');
						var id = row.data('id');
						var form = $('#form-delete');
						var url = form.attr('action').replace(':USER_ID',id)
						var data = form.serialize();


						if (confirm('¿Está seguro que desea eliminar a "'+row.data('name')+'" de sus registros?')) {
							$.ajax({
								type: 'delete',
								url: url,
								data: data,
								success: function(data){
									alert(data);
								}
							});

							row.fadeOut();
						}
					});

					$('#myModal').on('hidden.bs.modal', function (e) {
						$(this)
						.find("input")
						.val('')
						.end()
					})

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

