<?php
$advisors = \App\Models\Advisor::where(['is_active' => true])->get();
$advisors = collect($advisors)->pluck('first_name', 'id');

$subjects = \App\Models\Subjects::all();
$subjects = collect($subjects)->pluck('title', 'id');

$groups = \App\Models\Group::all();
$groups = collect($groups)->pluck('name', 'id');
?>
@extends('layouts.dashboard')
@section('dashboard-content')
    <form action="{{route('student.update', ['student' => $student->id])}}" method="POST">
        @method('PUT')
        {!! Form::token();  !!}
        <div class="row">
            <div class="col-md-6">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Анкета для студента</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Имя</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                                </div>

                                {!! Form::text('name',$student->name,[
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

                                {!! Form::text('last_name',$student->last_name,[
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

                                {!! Form::text('middle_name',$student->middle_name,[
                                            'class' => 'form-control',
                                            ]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Адрес проживания</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                </div>
                                {!! Form::text('address',$student->address,[
                                         'class' => 'form-control',
                                         'id'=>"address",
                                         ]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Школа</label>
                            {{Form::textarea('school', $student->school, ['rows' => 3,'class' => 'form-control', 'style'=>"width: 100%;"])}}
                        </div>

                        <div class="form-group">
                            <label>Номер телефона</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>

                                {!! Form::text('phone',substr($student->phone,1),[
                                          'class' => 'form-control',
                                          'id'=>"phone_number",
                                          'data-inputmask'=>'"mask": "+7 (999) 999-99-99"',
                                          'data-mask'
                                          ]) !!}
                            </div>
                            <!-- /.input group -->
                        </div>

                        <div class="form-group">
                            <label>Стоимость курса ( &#8376;)</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                                </div>
                                {!! Form::text('course_price',$student->course_price,[
                                         'class' => 'form-control',
                                         'id'=>"course_price",
                                         ]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Куратор</label>
                            {{Form::select('advisor_id', $advisors, $student->advisor_id,
                              ['class' => 'form-control select2',
                               'style' => 'width: 100%;'])}}
                        </div>
                        <div class="form-group">
                            <label>Группы</label>
                            {{Form::select('groups[]', $groups, $student->groups->pluck('id')->toArray(),
                             ['class' => 'select2bs4',
                              'multiple' => 'multiple',
                              'data-placeholder' => 'Выберите группу',
                              'style' => 'width: 100%;'])}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Анкета для родителя</h3>
                    </div>
                    <div class="card-body">
                        <!-- Date dd/mm/yyyy -->
                        <div class="form-group">
                            <label>ФИО родителя</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-user"></i></span>
                                </div>
                                {{Form::text('parent_full_name', $student->parent_full_name, ['class' => 'form-control', 'placeholder' => 'Amin Diyas Serikuly'])}}
                            </div>

                            <div class="form-group">
                                <label>Номер телефона</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>

                                    {!! Form::text('parent_phone',$student->parent_phone,[
                                              'class' => 'form-control',
                                              'id'=>"parent_phone",
                                              'data-inputmask'=>'"mask": "+7 (999) 999-99-99"',
                                              'data-mask'
                                              ]) !!}
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Сохранить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script src="{{asset("dashboard/plugins/select2/js/select2.full.min.js")}}"></script>
    <script>
        $(document).ready(function () {
            $('#student_phone').inputmask();
            $('#parent_phone').inputmask();
            $('#phone_number').inputmask();
            $('#social_id').inputmask();

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
