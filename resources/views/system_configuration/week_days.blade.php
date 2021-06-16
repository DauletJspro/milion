@extends('layouts.dashboard')
@section('dashboard-content')
    <div class="card">
        <div class="card-header">
            @role('admin')
            <a href="" class="btn btn-success" data-toggle="modal" data-target="#common_time">
                Указать время и длительность для всех дней
            </a>
            @endrole
        </div>
        <div class="card-body">
            <div class="row">
                {!! Form::open(['route' => 'configure.store',  'method' => 'post', 'class' => 'col-12'])!!}
                {!! Form::token();  !!}
                @foreach($week_days as $day)
                    <div class="col-md-12">
                        <div class="card card-{{$day->color_type}}">
                            <div class="card-header">
                                <h3 class="card-title">{{$day->title_ru}}</h3>
                            </div>
                            <div class="card-body row">
                                <div class="form-group col-4">
                                    <label>Время начала уроков</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>

                                        {!! Form::text('lesson_begin_time:' . $day->week_day_number,$day->lesson_begin_time,[
                                                     'class' => 'form-control lesson_begin_time',
                                                     'data-inputmask'=>'"mask": "99-99"',
                                                     'data-mask'
                                                     ]) !!}
                                    </div>
                                </div>
                                <div class="form-group col-4">
                                    <label>Длительность одного занятия</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>

                                        {!! Form::text('lesson_duration:'.  $day->week_day_number,$day->lesson_duration,[
                                                     'class' => 'form-control lesson_duration',
                                                     'data-inputmask'=>'"mask": "999 минут"',
                                                     'data-mask'
                                                     ]) !!}
                                    </div>
                                </div>
                                <div class="form-group col-4">
                                    <label>Длительность перерыва</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>

                                        {!! Form::text('break_duration:' .  $day->week_day_number,$day->break_duration,[
                                                     'class' => 'form-control break_duration',
                                                     'data-inputmask'=>'"mask": "999 минут"',
                                                     'data-mask'
                                                     ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success float-right">Сохранить</button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="common_time" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Указать время и длительность для всех дней</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-body row">
                                <div class="form-group col-12">
                                    <label>Время начала уроков</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>

                                        {!! Form::text('lesson_begin_time',null,[
                                                     'class' => 'form-control lesson_begin_time',
                                                     'data-inputmask'=>'"mask": "99-99"',
                                                     'id' => 'common_begin_time',
                                                     'data-mask'
                                                     ]) !!}
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label>Длительность одного занятия</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>

                                        {!! Form::text('lesson_duration',null,[
                                                     'class' => 'form-control lesson_duration',
                                                     'data-inputmask'=>'"mask": "999 минут"',
                                                     'id'=>'common_lesson_duration',
                                                     'data-mask'
                                                     ]) !!}
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label>Длительность перерыва</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>

                                        {!! Form::text('break_duration',null,[
                                                     'class' => 'form-control break_duration',
                                                     'data-inputmask'=>'"mask": "999 минут"',
                                                     'id' => 'common_break_duration',
                                                     'data-mask'
                                                     ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" id="specify_common_time_button" class="btn btn-primary">Указать для всех
                        дней
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset("dashboard/plugins/select2/js/select2.full.min.js")}}"></script>
    <script>
        $(document).ready(function () {
            $('.lesson_begin_time').inputmask();
            $('.lesson_duration').inputmask();
            $('.break_duration').inputmask();

            $('#specify_common_time_button').bind('click', function () {
                var common_begin_time = $('#common_begin_time').val();
                var common_lesson_duration = $('#common_lesson_duration').val();
                var common_break_duration = $('#common_break_duration').val();
                $('.lesson_begin_time').val(common_begin_time);
                $('.lesson_duration').val(common_lesson_duration);
                $('.break_duration').val(common_break_duration);
                $('#common_time').modal('hide');
            });
        });
    </script>

@endsection
