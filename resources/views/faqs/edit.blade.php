@extends('layouts.dashboard')
@section('title')
    Добавить часто задаваемые вопросы  (FAQ)
@endsection
@section('dashboard-content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Форма для заполнение FAQ</h3>
                </div>

                <form action="{{route('faq.update', ['faq' => $faq])}}" method="POST" >
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Вопрос</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-question-circle"></i></span>
                                </div>

                                {!! Form::textarea('question',$faq->question,[
                                            'class' => 'form-control',
                                            'rows' => 5,
                                            ]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ответ</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                </div>

                                {!! Form::textarea('answer',$faq->answer,[
                                            'class' => 'form-control',
                                            'rows' => 5
                                            ]) !!}
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">
                            Сохранить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
