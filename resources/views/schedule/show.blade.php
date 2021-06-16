<?php
/** @var \App\Models\Cabinet $cabinet */
/** @var \App\Models\Schedule $time */
/** @var \App\Models\WeekDays $day */

use App\Models\Cabinet;
use App\Models\Group;
use App\Models\WeekDays;
use \App\Models\Schedule;
$weekdays = WeekDays::all();
$weekdays = $weekdays->pluck('title_ru', 'week_day_number')->toArray();

$cabinets = Cabinet::all();
$cabinets = $cabinets->pluck('title', 'id')->toArray();


$groups = Group::where(['is_active' => true])->get();
$groups = $groups->pluck('name', 'id')->toArray();
?>
@extends('layouts.dashboard')
@section('title')
    Расписание
@endsection
@section('dashboard-content')
    <div class="card">
        @role('admin')
        <div class="card-header">
            <button class="btn btn-success" data-toggle="modal" data-target="#add_lesson_modal">
                Добавить урок
            </button>
        </div>
        @endrole
        @foreach($week_days as $day)
            <div class="card-body" style="overflow-x: auto;">
                <div style="font-size: 2rem;"
                     class="text-center card-header card-{{$day->color_type}}">{{$day->title_ru}}</div>
                <table class="table table-bordered table-sm" style="white-space: nowrap;">
                    <thead>
                    <tr>
                        <th scope="col">Время</th>
                        @foreach($table_cabinets as $cabinet)
                            <th scope="col">Кабинет {{$cabinet->title}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(Schedule::getLessonTimes($day->week_day_number) as $time)
                        <tr>
                            <td>{{$time}}</td>
                            @foreach($table_cabinets as $cabinet)
                                <?php
                                isset($schedules_array[$day->week_day_number][$time][$cabinet->id]) ? ($schedule = $schedules_array[$day->week_day_number][$time][$cabinet->id]) : $schedule = null
                                ?>
                                <td>
                                    @if(isset($schedule))
                                        <div class="card"
                                             style="background-color: #f6fdff; border: 1px solid lightgrey;">
                                            <div class="card-header"><i class="fa fa-users"></i> {{$schedule['group']}}
                                            </div>
                                            <div class="card-body">

                                                <i class="fa fa-book"></i> Предмет: {{$schedule['subject_title']}}
                                                <br>
                                                <i class="fa fa-user"></i> Учитель: Д.Амин
                                                @role('admin')
                                                {!! Form::open(['method' => 'POST', 'route' => 'schedule.delete','onsubmit' => 'return confirmDelete()']); !!}
                                                @csrf
                                                <input type="hidden" name="schedule_id"
                                                       value="{{$schedule['schedule_id']}}">
                                                <button class="float-right"
                                                        style="padding-right:0; border: none; background-color: white;"
                                                        type="submit">
                                                    <i style="font-size:90%;color: red"
                                                       class="float-right fa fa-trash"></i>
                                                </button>
                                                {!! Form::close(); !!}
                                                @endrole
                                                @role('admin')
                                                <button value="{{$schedule['schedule_id']}}"
                                                        class="float-right get_lesson_data"
                                                        style="padding-right:0;border: none; background-color: white;">
                                                    <i style="font-size:90%;color: blue"
                                                       class="float-right fa fa-edit"></i>
                                                </button>
                                                @endrole
                                            </div>
                                        </div>
                                    @else
                                        {{'Не указано'}}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="add_lesson_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Расписание уроков</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{Form::open(['route' => 'schedule.add', 'method' => 'POST', 'id' => 'schedule_add_form'])}}
                {{Form::token()}}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Выберите день недели</label>
                        {!! Form::select('week_day_id', [null => 'Выберите день'] +
                           $weekdays,
                            null,
                            [
                                'class' => 'form-control',
                                'id' => 'week_day_id',
                                ])
                         !!}
                    </div>
                    <div class="form-group">
                        <label>Укажите номер кабинета</label>
                        {!! Form::select('cabinet_id', [null => 'Укажите номер кабинета'] +
                           $cabinets,
                            null,
                            [
                                'class' => 'form-control',
                                'id' => 'cabinet_id',
                            ])
                         !!}
                    </div>
                    <div class="form-group d-none" id="lesson_begin_select">
                        <label>Укажите время</label>
                        {!! Form::select('lesson_time', [null => 'Укажите время'] +
                             [],
                              null,
                              ['class' => 'form-control', 'id' => 'lesson_time'])
                           !!}
                    </div>
                    <div class="form-group">
                        <label>Выбирает группу</label>
                        {!! Form::select('group_id', [null => 'Укажите группу'] +
                           $groups,
                            null,
                            [
                                'class' => 'form-control',
                                'id' => 'group_id'
                            ])
                         !!}
                        <input type="hidden" id="schedule_id" name="schedule_id">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button id="lesson_add_submit_button" type="submit" class="btn btn-primary">Добавить</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>

        function confirmDelete() {
            return confirm('Вы уверены что хотите удалить?');
        }


        $('.get_lesson_data').bind('click', function () {
            ajax('{{route('schedule.ajax')}}', 'get_lesson_data', null, $(this).val());
        });

        $('#week_day_id').on('change', function () {
            ajax('{{route('schedule.ajax')}}', 'get_lesson_begin_time', $(this).val());
        });

        function append_to_lesson_begin_select(data) {
            $('#lesson_time').empty();
            $.each(data, function (key, value) {
                $('#lesson_time')
                    .append($("<option></option>")
                        .attr("value", value)
                        .text(value));
            });
            $('#lesson_begin_select').removeClass('d-none');
        }

        function append_to_lesson_update_form(data) {
            var time_duration = data['time_duration'];
            $('#week_day_id').val(data['day_of_week']).prop('disabled', true);
            $('#cabinet_id').val(data['cabinet_id']).prop('disabled', true);
            $('#lesson_time').append($("<option></option>")
                .attr("value", time_duration)
                .text(time_duration)).prop('disabled', true);
            $('#lesson_time option[value="' + time_duration + '"]').prop('selected', true);
            $('#lesson_begin_select').removeClass('d-none');
            $('#group_id').val(data['group_id']);
            $('#schedule_id').val(data['schedule_id']);
            $('#lesson_add_submit_button').text('Изменить');
            $('#schedule_add_form').prop('action', '{{route('schedule.update')}}');
            $('#add_lesson_modal').modal('show');
        }

        function ajax(route, action, week_day = null, schedule_id = null) {
            var result;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: route,
                method: 'POST',
                data: {action: action, week_day: week_day, schedule_id: schedule_id},
                success: function (data) {
                    if (action == 'get_lesson_begin_time') {
                        append_to_lesson_begin_select(data);
                    } else if (action == 'get_lesson_data') {
                        append_to_lesson_update_form(data);
                    }

                }
            });
        }
    </script>
@endsection
