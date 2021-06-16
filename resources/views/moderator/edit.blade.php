@extends('layouts.dashboard')
@section('title')
    Редактировать модератора
@endsection
@section('dashboard-content')

    <div class="col-md-6">
        <form action="{{route('moderator.update', ['moderator' => $moderator->id])}}" method="POST">
            @method('PUT')
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

                            {!! Form::text('first_name',$moderator->first_name,[
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

                            {!! Form::text('last_name',$moderator->last_name,[
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

                            {!! Form::text('phone',substr($moderator->phone,1),[
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
        </form>

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
