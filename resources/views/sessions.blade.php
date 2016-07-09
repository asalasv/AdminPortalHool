@extends('layouts.app')

@section('htmlheader_title')
Home
@endsection


@section('main-content')

<div class="row">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-md-12">
		<!-- AREA CHART -->
		<div class="box box-primary">
			<div class="box-body">
				<div class="box-header">
					<i class='fa fa-desktop'></i><h3 class="box-title">Sesiones</h3>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table class="table table-hover">
						<tr>
							<th>Ip</th>
							<th>Usuario</th>
							<th>Mac</th>
							<th></th>
						</tr>
						@foreach($sesiones as $sesion)
						<tr data-sesion ="{{ $sesion->sesion}}">
							<td>{{$sesion->ip}}</td>
							<td>{{$sesion->usuario}}</td>
							<td>{{$sesion->mac}}</td>
							<td><a href="#" class="btn-delete btn-desconectar"><i class="fa fa-fw fa-close"></i></i>Desconectar</a></td>
						</tr>
						@endforeach
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
	</div>
</div>

				{!! Form::open(['route' => ['desconectar', ':sesion'], 'method' =>'post', 'id' => 'form-desconectar']) !!}
				{!!Form::close() !!}

	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).ready(function(){


			$('.btn-desconectar').click(function(){

				var row = $(this).parents('tr');
				var sesion = row.data('sesion');

				var form = $('#form-desconectar');
				var url = form.attr('action').replace(':sesion',sesion);
				var data = form.serialize();

				if(confirm('¿Está seguro que desea desconectar esta sesion?')){
					$.ajax({
						type: 'post',
						url: url,
						data: data,
						success: function(data){
							window.location.reload();
						}
					});	
				}
				
			});

			
		});

	</script>

	@endsection
