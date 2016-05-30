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
						<i class="fa fa-unlock" style="font-size: 20px"></i>&nbsp;Actualmente este Portal se encuentra configurado como <b>Público</b>
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
						<i class='fa fa-users'></i><h3 class="box-title" style="padding-right: 25;">Usuarios</h3>
						<!-- <button type="button" id="asignargrupo" class="btn btn-default btn-xs" data-toggle="modal" data-target="#AsignGroup" style="margin-left: 100px;"><i class='fa fa-group'></i>&nbsp;Asignar a grupo</button>
						<button type="button" id="grupos" class="btn btn-default btn-xs" data-toggle="modal" data-target="#Group"><i class='fa fa-group'></i>&nbsp;Grupos</button> -->
						<button type="button" id="accionxlote" class="btn btn-default btn-xs dropdown" style="left: 50px;">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="color: #444444;">
							Accion por lote <span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<!-- <li role="presentation"><a role="menuitem" id="asignargrupo" tabindex="-1" data-toggle="modal" data-target="#AsignGroup" href="#"><i class='fa fa-group'></i></i>Asignar a grupo</a></li> -->
								<li role="presentation"><a role="menuitem" id="habilitar" tabindex="-1" href="#"><i class="fa fa-circle-o"></i></i>Habilitar</a></li>
								<li role="presentation"><a role="menuitem" id="deshabilitar" tabindex="-1" href="#"><i class="fa fa-ban"></i>Deshabilitar</a></li>
								<li role="presentation"><a role="menuitem" id="borrar" tabindex="-1" href="#"><i class='fa fa-trash'></i>Eliminar</a></li>
							</ul>
						</button>
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
								<th>
									<input type="checkbox" id="selectAll" />
								</th>
								<th>Nombre</th>
								<th>Apellido</th>
								<th>Email</th>
								<th>Estatus</th>
								<!-- <th>Grupo</th> -->
								<th>Estatus PH</th>

							</tr>
							@foreach($usuarios as $user)
							<tr data-id="{{ $user->id_usuario_ph}}" data-name ="{{$user->nombre}}">
								<td>
									<input type="checkbox" />
								</td>
								<td>{{$user->nombre}}</td>
								<td>{{$user->apellido}}</td>
								<td>{{$user->email}}</td>
								@if($user->status == '1' || $user->status == '2')
								<td><span class="label label-success">Activo</span></td>
								@elseif($user->status == '0')
								<td><span class="label label-danger">Bloqueado por PortalHook</span></td>
								@elseif($user->status == '3')
								<td><span class="label label-warning">Dado de baja</span></td>
								@endif
								@foreach($clientes_usuarios as $client_us)
								@if($client_us->id_usuario_ph == $user->id_usuario_ph)
								<!-- <td>{{$client_us->grupo}}</td> -->
								@if($client_us->status == '1')
								<td><span class="label label-success">Habilitado</span></td>
								<td><a href="#" class="btn-bloq disable"><i class="fa fa-ban"></i></i>&nbsp;Deshabilitar</a></td>
								@else
								<td><span class="label label-danger">Deshabilitado</span></td>
								<td><a href="#" class="btn-bloq enable"><i class="fa fa-circle-o"></i></i>&nbsp;Habilitar</a></td>
								@endif
								@endif
								@endforeach
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

			<!-- Modal -->
			<div class="modal fade" id="AsignGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Asignar a Grupo</h4>
						</div>
						<div class="modal-body">
						<small>Seleccione el grupo o cree un nuevo grupo</small>
							<div class="box-tools pull-right"> 
								<button data-toggle="modal" data-target="#NewGroup" type="button" class="btn btn-block btn-primary btn-sm creargrupo" style="margin-bottom: 5px;">
									<i class="fa fa-user-plus"></i>&nbsp;Crear Grupo
								</button>
							</div>
							<table class="table table-hover">
								<tr>
									<th>Nombre Grupo</th>
								</tr>
								<tr data-id="" data-name ="">
									<td>nombre_grupo</td>
								</tr>
							</table>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" id="close" data-dismiss="modal">Close</button>
								<button type="button" id="asignar" class="btn btn-primary" id="btn-add">Asignar</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="Group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Grupos</h4>
						</div>
						<div class="modal-body">
							<div class="box-tools pull-right"> 
								<button data-toggle="modal" data-target="#NewGroup" type="button" class="btn btn-block btn-primary btn-sm creargrupo" style="margin-bottom: 5px;">
									<i class="fa fa-user-plus"></i>&nbsp;Crear Grupo
								</button>
							</div>
							<table class="table table-hover">
								<tr>
									<th>Nombre Grupo</th>
									<th></th>
									<th></th>
									<th></th>
								</tr>
								<tr data-id="" data-name ="">
									<td>nombre_grupo</td>
									<td><a href="#" class="btn-delete_group"><i class="fa fa-ban"></i></i>Deshabilitar</a></td>
									<td><a id="disable" href="#" class="btn-delete_group"><i class="fa fa-circle-o"></i></i>Habilitar</a></td>
									<td><a href="#" class="btn-delete_group"><i class="fa fa-trash"></i></i>Eliminar</a></td>
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" id="close" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary" id="btn-add">Agregar</button>
							</div>
						</div>
					</div>
				</div>
			</div>

				<!-- Modal -->
				<div class="modal fade" id="NewGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Nuevo Grupo</h4>
							</div>
							<div class="modal-body">
							<div class="row">
								<div class="col-xs-9">
									<label class="control-label" for="date">Nombre del grupo</label>
									<input type="text" class="form-control" name="newgroup" id="newgroup" placeholder="Nombre">
								</div>
							</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" id="close" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary" id="btn-add">Crear</button>
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

				{!! Form::open(['route' => ['changestatusph', ':Users'], 'method' =>'post', 'id' => 'form-changeph']) !!}
				{!!Form::close() !!}

				{!! Form::open(['route' => ['habilitarph', ':Users'], 'method' =>'post', 'id' => 'form-hablitarph']) !!}
				{!!Form::close() !!}

				{!! Form::open(['route' => ['inhabilitarph', ':Users'], 'method' =>'post', 'id' => 'form-inhabilitarph']) !!}
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

						$('.enable').click(function(){
							var row = $(this).parents('tr');
							var id = row.data('id');
							var form = $('#form-changeph');
							var url = form.attr('action').replace(':Users',id)
							var data = form.serialize();

							$.ajax({
								type: 'post',
								url: url,
								data: data,
								success: function(data){
									window.location.reload();
								}
							});
						});

						$('.disable').click(function(){
							var row = $(this).parents('tr');
							var id = row.data('id');
							var form = $('#form-changeph');
							var url = form.attr('action').replace(':Users',id)
							var data = form.serialize();

							$.ajax({
								type: 'post',
								url: url,
								data: data,
								success: function(data){
									window.location.reload();
								}
							});
						});


						$('#habilitar').click(function(){
							var rowsid = getselectedrows();
							if(rowsid == null)
								alert('Debe seleccionar al menos un usuario')
							else{
								var id = rowsid;
								var form = $('#form-hablitarph');
								var url = form.attr('action').replace(':Users',id)
								var data = form.serialize();

								$.ajax({
									type: 'post',
									url: url,
									data: data,
									success: function(data){
										window.location.reload();
									}
								});
								//habilitar los usuarios que esten en rowsid
							}
						});

						$('#deshabilitar').click(function(){
							var rowsid = getselectedrows();
							if(rowsid == null)
								alert('Debe seleccionar al menos un usuario')
							else{
								var id = rowsid;
								var form = $('#form-inhabilitarph');
								var url = form.attr('action').replace(':Users',id)
								var data = form.serialize();

								$.ajax({
									type: 'post',
									url: url,
									data: data,
									success: function(data){
										window.location.reload();
									}
								});
								//dhabilitar los usuarios que esten en rowsid
							}
						});

						$('#borrar').click(function(){
							var rowsid = getselectedrows();
							if(rowsid == null)
								alert('Debe seleccionar al menos un usuario')
							else{
								var id = rowsid;
								var form = $('#form-delete');
								var url = form.attr('action').replace(':USER_ID',id)
								var data = form.serialize();

								if (confirm('¿Está seguro que desea eliminar los usuarios seleccionados de sus registros?')) {
									$.ajax({
										type: 'delete',
										url: url,
										data: data,
										success: function(data){
											alert(data);
											window.location.reload();
										}
									});

									row.fadeOut();
								}

								//eliminar los usuarios que esten en rowsid
							}
						});

						$('#asignargrupo').click(function(){
							var rowsid = getselectedrows();
							if(rowsid == null){
								alert('Debe seleccionar al menos un usuario');
								$('.creargrupo').prop('disabled', true);
								$('#asignar').prop('disabled', true);
							}else{
								$('.creargrupo').prop('disabled', false);
								$('#asignar').prop('disabled', false);
								//Asignar los usuarios que esten en rowsid al grupo seleccionado
							}
						});

						$('#grupos').click(function(){
							var rowsid = getselectedrows();
							if(rowsid == null){
								$('.creargrupo').prop('disabled', true);
							}else{
								$('.creargrupo').prop('disabled', false);
							}
						});


						$('.creargrupo').click(function(){
							var rowsid = getselectedrows();
							if(rowsid == null){
								$('.creargrupo').prop('disabled', true);
							}else{
								$('.creargrupo').prop('disabled', false);
							}
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

						$('#selectAll').click(function (e) {
							$(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
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

				    function getselectedrows() { 
				    	var selectedIds = [];

						$(":checked").each(function() {

							var row = $(this).parents('tr');
							var id = row.data('id');
							if (typeof id === "undefined") {
							    
							}else
						    	selectedIds.push(id);
						});
						if(Object.keys(selectedIds).length == 0)
							return null;
						return selectedIds;
			    	}

				</script>

				@endsection

