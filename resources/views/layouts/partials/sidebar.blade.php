<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
        <div class="user-panel">
            <div class="pull-left image">
                    @if(Session::has('portal.logo'))
                        <img src="{{asset(Session::get('portal.logo'))}}" class="img-thumbnail" alt="User Image" />
                    @else 
                        <img src="{{asset('/img/dashboard-1.jpg')}}" class="img-thumbnail" alt="User Image" />
                    @endif
                
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->username }} <br/>
                <small>{{ Auth::user()->email }}</small></p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu ">
            <li class="header">MENÚ</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="treeview"><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>Home</span></a></li>
            <li class="treeview"><a href="#" data-toggle="modal" data-target="#SelectModal"><i class='fa fa-building'></i> <span>Clientes</span></a></li>
            <li class="treeview" id="menu-grafic">
                <a href="#"><i class='fa fa-line-chart'></i> <span>Estadísticas</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('lastweekreg') }}">Registros por Período</a></li>
                    <li><a href="{{ url('newlastweekreg') }}">Registros Nuevos por Período</a></li>
                    <li><a href="{{ url('connectlastweek') }}">Conexiones al Portal</a></li>
                    <li><a href="{{ url('portalhookuserreg') }}">Registro Usuarios PH vs Visitantes</a></li>
                    <li><a href="{{ url('sexportalhookuserreg') }}">Registro Usuarios PH por Género</a></li>
                    <li><a href="{{ url('coneccfraudulentas') }}">Conexiones Fraudulentas</a></li>
                </ul>
            </li>
            <li class="treeview"><a href="{{ url('usuarios') }}"><i class='fa fa-users'></i> <span>Usuarios</span></a></li>
            <li class="treeview"><a href="{{ url('portales') }}"><i class='fa fa-desktop'></i> <span>Portales</span></a></li>
            <li class="treeview"><a href="{{ url('e-mailing') }}"><i class='fa fa-envelope'></i> <span>E-mailing</span></a></li>
            <li class="treeview" id="menu-config">
                <a href="#"><i class='fa fa-gear'></i> <span>Configuración</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="treeview" id="menu-cuenta">
                        <a href="#"><i class='fa fa-user'></i> <span>Cuenta</span><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('changepass') }}">Cambiar Password</a></li>
                        </ul>   
                    </li>
                    <li class="treeview" id="menu-wifi">
                        <a href="#"><i class='fa fa-wifi'></i> <span>Wifi</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu" >
                            <li><a href="{{ url('portalpass') }}">Cambiar password Portal</a></li>
                            <li><a href="{{ url('sesiones') }}">Usuarios conectados</a></li>
                            <li><a href="#">Bloq. de disp. por MAC</a></li>
                            <li><a href="#">Bloq. de categorías de internet</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>