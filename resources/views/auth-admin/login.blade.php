@extends('layouts.app-admin')

@section('content')
    <section class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b>miLion App</a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Войти</p>

                    {!! Form::open(['url' => route('login'), 'method' => 'post']) !!}
                    @csrf
                    <div class="input-group mb-3">
                        {{Form::text('email', '',['type' => 'email', 'class' => 'form-control', 'placeholder' => "Email"])}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        {{Form::password('password',  ['type' => 'password', 'class' => 'form-control', 'placeholder' => 'Password'])}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Запомнить меня
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Войти</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    {!! Form::close() !!}

                    <div class="social-auth-links text-center mb-3">
                        <p>- или -</p>
                        <a href="#" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i> Войти через Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i> Войти через Google+
                        </a>
                    </div>
                    <!-- /.social-auth-links -->

                    <p class="mb-1">
                        <a href="forgot-password.html">Забыл пароль</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </section>
@endsection
