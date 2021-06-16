@extends('layouts.dashboard')
@section('title')
    Редактировать учителя
@endsection
@section('dashboard-content')

    <div class="col-md-6">
        <form action="{{route('teacher.update', ['teacher' => $teacher->id])}}" method="POST">
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

                            {!! Form::text('first_name',$teacher->first_name,[
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

                            {!! Form::text('last_name',$teacher->last_name,[
                                        'class' => 'form-control',
                                        ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Отчество</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-pen"></i></span>
                            </div>

                            {!! Form::text('middle_name',$teacher->middle_name,[
                                        'class' => 'form-control',
                                        ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label>ИИН</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            {!! Form::text('social_id',$teacher->social_id,[
                                       'class' => 'form-control',
                                       'id'=>"social_id",
                                       'data-inputmask'=>'"mask": "9999-9999-9999"',
                                       'data-mask'
                                       ]) !!}

                        </div>
                    </div>


                    <!-- phone mask -->
                    <div class="form-group">
                        <label>Номер телефона</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>

                            {!! Form::text('phone',substr($teacher->phone,1),[
                                      'class' => 'form-control',
                                      'id'=>"phone_number",
                                      'data-inputmask'=>'"mask": "+7 (999) 999-99-99"',
                                      'data-mask'
                                      ]) !!}
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <button type="submit" class="btn btn-primary">
                        Сохранить
                    </button>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
