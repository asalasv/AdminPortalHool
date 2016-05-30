@extends('layouts.app')

@section('htmlheader_title')
Registros Ultima Semama
@endsection


@section('main-content')

<div class="row">
	<div class="col-md-12">
		<!-- AREA CHART -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<i class="fa fa-line-chart"></i><h3 class="box-title">Conexiones Fraudulentas</h3>
			</div>
			<div class="box-body">
				<div class="bootstrap-iso">
					<div class="row" style="margin-bottom: 20px;">
						<form class="form-inline col-md-12">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="form-group"> <!-- Date input -->
								<label class="control-label" for="date">Desde</label>
								<input class="form-control" id="vdesde" name="vdesde" placeholder="MM/DD/YYY" type="text"/>
							</div>
							<div class="form-group"> <!-- Date input -->
								<label class="control-label" for="date">Hasta</label>
								<input class="form-control" id="vhasta" name="vhasta" placeholder="MM/DD/YYY" type="text"/>
							</div>
							<button type="button" id="dates" class="btn btn-primary">Generar Grafica</button>
						</form>
					</div>
				</div>	
				<div class="row">
					<div id="graphic1" class="col-md-12 center-block"></div>
				</div>

			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</div>

<script>
    var vhasta=$('input[name="vhasta"]'); //our date input has the name "date"
    var vdesde=$('input[name="vdesde"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
    	format: 'mm/dd/yyyy',
    	container: container,
    	todayHighlight: true,
    	autoclose: true,
    };
    vdesde.datepicker(options); //initiali110/26/2015 8:20:59 PM ze plugin
    vhasta.datepicker(options); //initiali110/26/2015 8:20:59 PM ze plugin
</script>


<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function(){

		$(function(){
			$('#menu-grafic').addClass('active');  
		});

		$(function () {

			var vdesde= $("#vdesde").val();
			var vhasta= $("#vhasta").val();

			var dataString = "desde="+vdesde+"&hasta="+vhasta;


		$.ajax({
			type: "get",
			url: "/coneccfraudulentas/get",
			data: dataString,
			success: function(data){
				console.log(data);

			    var chart ={
			        chart: {
			        	renderTo: 'graphic1',
			            type: 'area',
			            spacingBottom: 30
			        },
			        title: {
			            text: 'Conexiones Fraudulentas'
			        },
			        subtitle: {
			            text: 'Direcciones Mac',
			            floating: true,
			            align: 'right',
			            verticalAlign: 'bottom',
			            y: 15
			        },
			        legend: {
			            layout: 'vertical',
			            align: 'left',
			            verticalAlign: 'top',
			            x: 150,
			            y: 100,
			            floating: true,
			            borderWidth: 1,
			            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
			        },
			        xAxis: {
			            categories: []
			        },
			        yAxis: {
			            title: {
			                text: 'Cantidad de Registros (Ult. 7 dias)'
			            },
			            labels: {
			                formatter: function () {
			                    return this.value;
			                }
			            }
			        },
			        tooltip: {
			            formatter: function () {
			                return '<b>' + this.series.name + '</b><br/>' +
			                    this.x + ': ' + this.y;
			            }
			        },
			        plotOptions: {
			            area: {
			                fillOpacity: 0.5
			            }
			        },
			        credits: {
			            enabled: false
			        },
					series: [{
						name: 'Cantidad de Registros',
						data: []
					}]
			    };

				var series = [];
				var categories = [];

				var array = $.map(data, function(value, index) {
				[value];
				});
				var a = data.length;
				for(var i=0; i<a; i++){
				console.log('f')
					categories.push(data[i]["mac"]);
					series.push(parseInt(data[i]["count(`mac`)"]));
				};
				console.log('categorias');
				console.log(categories);
				console.log('series: ');
				console.log(series);

				chart.series[0].data = series;
				chart.xAxis.categories = categories;

				// console.log(chart);

				new Highcharts.Chart(chart);
			}
		});
		
		// $(function(){
		// 	$('#menu-grafic').addClass('active');  
		// });

		// var vdesde= $("#vdesde").val();
		// var vhasta= $("#vhasta").val();

		// var dataString = "desde="+vdesde+"&hasta="+vhasta;

		// $.ajax({
		// 	type: "get",
		// 	url: "/coneccfraudulentas/get",
		// 	data: dataString,
		// 	success: function(data){
		// 		console.log(data);
		// 		var chart = {
		// 			chart: {
		// 				renderTo: 'graphic1',
		// 				type: 'line'
		// 			},
		// 			title: {
		// 				text: 'Conexiones Fraudulentas'
		// 			},
		// 			xAxis: {
		// 				categories: [],
		// 				labels: {
		// 					style: {
		// 						color: 'black',
		// 						fontSize:'16px'
		// 					}
		// 				}
		// 			},
		// 			yAxis: {
		// 				title: {
		// 					text: 'N° de Registros'
		// 				}
		// 			},
		// 			tooltip: {
		// 	            formatter: function () {
		// 	                return '<b>' + this.series.name + '</b><br/>' +
		// 	                    this.x + ': ' + this.y;
		// 	            }
		// 	        },
		// 			plotOptions: {
		// 				line: {
		// 					dataLabels: {
		// 						enabled: true
		// 					},
		// 					enableMouseTracking: false
		// 				}
		// 			},
		// 			series: [{
		// 				name: 'Cantidad de Registros',
		// 				data: []
		// 			}]
		// 		};

		// 		var series = [];
		// 		var categories = [];

		// 		var array = $.map(data, function(value, index) {
		// 			[value];
		// 		});
		// 		var a = data.length;
		// 		for(var i=0; i<a; i++){
		// 			console.log('f')
		// 			categories.push(data[i]["mac"]);
		// 			series.push(parseInt(data[i]["count(`mac`)"]));
		// 		};
		// 		console.log('categorias');
		// 		console.log(categories);
		// 		console.log('series: ');
		// 		console.log(series);

		// 		chart.series[0].data = series;
		// 		chart.xAxis.categories = categories;

		// 		// console.log(chart);

		// 		new Highcharts.Chart(chart);
		// 	}
		// });

		$("#dates").click(function(){

			var vdesde= $("#vdesde").val();
			var vhasta= $("#vhasta").val();

			var dataString = "desde="+vdesde+"&hasta="+vhasta;

			$.ajax({
				type: "get",
				url: "/coneccfraudulentas/get",
				data: dataString,
				success: function(data){
					console.log(data);
					var chart = {
						chart: {
							renderTo: 'graphic1',
							type: 'line'
						},
						title: {
							text: 'Conexiones Fraudulentas'
						},
						xAxis: {
							categories: [],
							labels: {
								style: {
									color: 'black',
									fontSize:'16px'
								}
							}
						},
						yAxis: {
							title: {
								text: 'N° de Registros'
							}
						},
						tooltip: {
				            formatter: function () {
				                return '<b>' + this.series.name + '</b><br/>' +
				                    this.x + ': ' + this.y;
				            }
				        },
						plotOptions: {
							line: {
								dataLabels: {
									enabled: true
								},
								enableMouseTracking: false
							}
						},
						series: [{
							name: 'Cantidad de Registros',
							data: []
						}]
					};

					var series = [];
					var categories = [];

					var array = $.map(data, function(value, index) {
						[value];
					});
					var a = data.length;
					for(var i=0; i<a; i++){
						console.log('f')
						categories.push(data[i]["mac"]);
						series.push(parseInt(data[i]["count(`mac`)"]));
					};
					console.log('categorias');
					console.log(categories);
					console.log('series: ');
					console.log(series);

					chart.series[0].data = series;
					chart.xAxis.categories = categories;

				// console.log(chart);

				new Highcharts.Chart(chart);
			}
		});
		});
		
	});


	});
</script> <!-- your script -->
@endsection
