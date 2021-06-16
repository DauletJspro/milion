@extends('layouts.dashboard')
@section('dashboard-content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Форма для добавление кабинета</h3>
                </div>
                {{Form::open(['route' => 'cabinet.store', 'method' => 'POST'])}}
                {{Form::token()}}
                <div class="card-body">
                    <div class="form-group">
                        <label>Укажите название кабинета</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                            </div>
                            {!! Form::text('title',null,[
                                        'class' => 'form-control',
                                        ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Укажите этаж кабинета</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sort"></i></span>
                            </div>
                            {!! Form::number('floor',null,[
                                        'class' => 'form-control',
                                        ]) !!}
                        </div>
                    </div>
                    @role('admin')
                    <button class="btn btn-primary">
                        Добавить
                    </button>
                    @endrole
                </div>

                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
