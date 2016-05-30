<!-- Content Header (Page header) -->
<section class="content-header">

    <h1>
    @if(Session::has('client'))
	     @yield('contentheader_title',  Session::get('client.name') )
	@else 
		@yield('contentheader_title', 'PortalHook Admin')
	@endif
       
        <small>@yield('contentheader_description')</small>
    </h1>
<!--     <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>