	<!-- Modal -->
	<div class="modal fade" id="SelectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><i class="fa fa-building"></i>&nbsp;Seleccionar Cliente</h4>
				</div>
				<div class="modal-body">
					<div class="box-body table-responsive">
						<table class="table table-hover" id="table">
							<tr>
								<th></th>
								<th>Nombre</th>
								<th>Alias</th>
								<th>Direccion</th>
								<th>Email</th>
								<th>Representante</th>
							</tr>
							@foreach($clientes as $cliente)
							<tr data-id="{{ $cliente->id_cliente}}" data-name ="{{$cliente->nombre}}">
								<td><i class="fa fa-building"></i></td>
								<td>{{$cliente->nombre}}</td>
								<td>{{$cliente->alias}}</td>
								<td>{{$cliente->direccion}}</td>
								<td>{{$cliente->email}}</td>
								<td>{{$cliente->representante}}</td>
							</tr>
							@endforeach

						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="btn-select">Continuar</button>
				</div>
			</div>
		</div>
	</div>


	{!! Form::open(['route' => ['selectclient', ':client_id'], 'method' =>'post', 'id' => 'form-select']) !!}
	{!!Form::close() !!}

	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).ready(function(){

			$("#table tr").click(function(){
			   $(this).addClass('active').siblings().removeClass('active');    
			   var value=$(this).find('td:first').html();
			});

			$('#btn-select').on('click', function(e){
				
					if(typeof $('#table .active').html() === "undefined"){
						alert('Debe seleccionar un cliente de la tabla para continuar');
					}else{
						
						var row = $('#table .active');
						var form = $('#form-select');
						var id = row.data('id');
						var url = form.attr('action').replace(':client_id',id);
						var data = form.serialize();
							$.ajax({
								type: 'post',
								url: url,
								data: data,
								success: function(data){

								    alert('Cliente "'+row.data('name')+'" Seleccionado');
								    $('#SelectModal').modal('hide');
								    window.location.reload(); // This is not jQuery but simple plain ol' JS
								}
							});
					}

			});

		});

	</script>