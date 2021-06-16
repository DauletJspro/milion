@extends('layouts.dashboard')
@section('dashboard-content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Форма для заполнение предмета</h3>
                </div>
                {{Form::open(['route' => 'subject.store', 'method' => 'POST'])}}
                {{Form::token()}}
                <div class="card-body">
                    <div class="form-group">
                        <label>Название предмета</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-pen"></i></span>
                            </div>

                            {!! Form::text('title',null,[
                                        'class' => 'form-control',
                                        ]) !!}
                        </div>
                    </div>


                    <button class="btn btn-primary">
                        Сохранить
                    </button>
                </div>

                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
