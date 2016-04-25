@extends('layouts.app')

@section('htmlheader_title')
Portales
@endsection


@section('main-content')

<div class="row">
	<div class="col-md-12">
		<!-- AREA CHART -->
		<div class="box box-primary">
			<div class="box-body">
				<div class="box-header">
					<i class='fa fa-desktop'></i><h3 class="box-title">Portales</h3>
					<div class="box-tools">
						<div class="input-group" style="width: 50px;">
							<!-- Button trigger modal -->
                            <a href="{{ url('/newportal') }}" >
                                <button class="btn btn-block btn-primary btn-sm">Agregar Portal</button>
                            </a>
						</div>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table class="table table-hover">
						<tr>
							<th>Descripción</th>
							<th>Fecha inicio</th>
							<th>Fecha fin</th>
							<th>Hora Inicio</th>
							<th>Hora fin</th>
							<th>Predeterminado</th>
						</tr>
						@foreach($portales as $portal)
						<tr data-id="{{ $portal->id_portal_cliente}}" data-name ="{{$portal->descripcion}}">
							<td>{{$portal->descripcion}}</td>
							@if($portal->fecha_inicio != '')
								<td>{{$portal->fecha_inicio}}</td>
							@else
								<td>-</td>
							@endif
							@if($portal->fecha_fin != '')
								<td>{{$portal->fecha_fin}}</td>
							@else
							<td>-</td>
							@endif
							@if($portal->hora_inicio != '00:00:00')
								<td>{{$portal->hora_inicio}}</td>
							@else
							<td>-</td>
							@endif
							@if($portal->hora_inicio != '00:00:00')
								<td>{{$portal->hora_fin}}</td>
							@else
								<td>-</td>
							@endif
							@if($portal->predeterminado == 'V')
								<td><span class="label label-success">Predeterminado</span></td>
							@else
								<td>-</td>
							@endif
							<td><a href="{{ url('editportal', $portal) }}"><i class="fa fa-fw fa-edit"></i>Editar</a></td>
							<td><a href="#" class="btn-delete"><i class="fa fa-fw fa-times"></i>Eliminar</a></td>
						</tr>
						@endforeach
					</table>
					{!! $portales->render() !!}
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>

		{!! Form::open(['route' => ['deleteportal', ':PORTAL_ID'], 'method' =>'delete', 'id' => 'form-delete']) !!}
		{!!Form::close() !!}

	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).ready(function(){
			$('.btn-delete').click(function(){
				var row = $(this).parents('tr');
				var id = row.data('id');
				var form = $('#form-delete');
				var url = form.attr('action').replace(':PORTAL_ID',id)
				var data = form.serialize();


				if (confirm('¿Está seguro que desea eliminar el portal "'+row.data('name')+'" de sus registros?')) {
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
		});

	</script>

	@endsection

