@extends('layouts.dashboard')
@section('dashboard-content')
    <div class="card">
        <div class="card-header">
            Системные настройки
        </div>
        <div class="card-body">
            <div class="row">
                <div class="card col-2">
                    <div class="text-center card-header">Кабинеты</div>
                    <div class="card-body">
                        <div class="col-12 text-center" style="font-size: 3rem;"><i class="fa fa-door-open"></i></div>
                        <div class="row text-center">
                            @role('admin')
                            <a href="{{route('cabinet.create')}}" class=" col-12">Добавить кабинеты</a>
                            @endrole
                            <a href="{{route('cabinet.index')}}" class="col-12">Список кабинетов</a>
                        </div>
                    </div>
                </div>
                <div class="card col-2">
                    <div class="text-center card-header">Дни недели</div>
                    <div class="card-body">
                        <div class="col-12 text-center" style="font-size: 3rem;"><i class="fa fa-calendar-day"></i>
                        </div>
                        <div class="row text-center">
                            <a href="{{route('week_days.show')}}" class=" col-12">Настроить дни</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
