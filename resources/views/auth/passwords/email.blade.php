@extends('layouts.auth')

@section('htmlheader_title')
    Password recovery
@endsection

@section('content')

<body class="login-page">
    <div class="login-box">
        <div class="login-logo" style="padding-left: 70px;padding-right: 70px">
            <a href="{{ url('/home') }}"><img src="../img/logofinal.png" class="img-responsive"></a>
        </div><!-- /.login-logo -->


        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="login-box-body">
            <p class="login-box-msg">¿Olvido su Contraseña?</p>
            <!-- {!! Form::open(['url' => '/password/email'])!!} -->
            <form action="{{ url('/password/email') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Dirección de correo electrónico" name="email" value="{{ old('email') }}"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-2">
                    </div><!-- /.col -->
                    <div class="col-xs-8" style="padding-bottom: 10px;">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
                    </div><!-- /.col -->
                    <div class="col-xs-2">
                    </div><!-- /.col -->
                </div>
                <!-- {!! Form::close() !!} -->
            </form>

            <a href="{{ url('/login') }}">Volver a conexión</a><br>

        </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->

    @include('layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

@endsection
