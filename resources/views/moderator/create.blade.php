@extends('layouts.dashboard')
@section('title')
    Добавить модератора
@endsection
@section('dashboard-content')

    <div class="col-md-6">
        {!! Form::open(['route' => 'moderator.store',  'method' => 'post'])!!}
        {!! Form::token();  !!}
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Поля анкеты:</h3>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label>Имя</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pen"></i></span>
                        </div>

                        {!! Form::text('first_name',null,[
                                    'class' => 'form-control',
                                    ]) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label>Фамилия</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pen"></i></span>
                        </div>

                        {!! Form::text('last_name',null,[
                                    'class' => 'form-control',
                                    ]) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label>Номер телефона</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>

                        {!! Form::text('phone',null,[
                                  'class' => 'form-control',
                                  'id'=>"phone_number",
                                  'data-inputmask'=>'"mask": "+7 (999) 999-99-99"',
                                  'data-mask'
                                  ]) !!}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    Сохранить
                </button>
            </div>
        </div>
        {!! Form::close() !!}

    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#phone_number').inputmask();
            $('#social_id').inputmask();
        });
    </script>
@endsection
