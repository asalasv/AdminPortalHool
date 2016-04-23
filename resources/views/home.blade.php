@extends('layouts.app')

@section('htmlheader_title')
Home
@endsection


@section('main-content')

<div class="row">

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading text-center">Bienvenido</div>

				<div class="panel-body">
						<div class="col-md-12">
							<img src="img/admin.jpg" alt="..." class="img-rounded center-block">
						</div>
				</div>
				<div class="box-footer">
					<div class="col-md-3">
							<div class="info-box">
					            <span class="info-box-icon bg-green"><i class="fa fa-file-excel-o"></i></span>
					            <div class="info-box-content">
					              	<a href="{{ url('excel') }}"><span class="info-box-number">Descargar Base de Datos</span></a>
					            </div>
					            <!-- /.info-box-content -->
					    	</div>
					</div>
				</div>
			</div>
		</div>



</div>
@endsection
