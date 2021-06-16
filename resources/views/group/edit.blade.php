@php($subjects = \App\Models\Subjects::all()->pluck('title', 'id'))
@php($teachers = \App\Models\Teacher::all()->pluck('first_name', 'id')->toArray())
{{--@php($teachers = array_map(function ($item){--}}
{{--    return sprintf('%s %s', $item['first_name'], $item['last_name']);--}}
{{--}, $teachers))--}}
@extends('layouts.dashboard')
@section('dashboard-content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Форма для изменение группы</h3>
                </div>
                <form action="{{route('group.update', ['group' => $group->id ])}}" method="POST">
                    @method('PUT')
                    {{Form::token()}}
                    <div class="card-body">
                        <div class="form-group">
                            <label>Название группы</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                                </div>

                                {!! Form::text('name',$group->name,[
                                            'class' => 'form-control',
                                            ]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Выберите предмет</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                </div>

                                {{Form::select('subject_id', $subjects, $group->subject_id,
                                    ['class' => 'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Выберите преподавателя</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>
                                </div>

                                {{Form::select('teacher_id',  $teachers, $group->teacher_id,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => 'Выберите преподавателя!',
                                    ])}}
                            </div>
                        </div>

                        <button class="btn btn-primary">
                            Сохранить
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
