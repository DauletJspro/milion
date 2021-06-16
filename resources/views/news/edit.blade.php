@extends('layouts.dashboard')
@section('title')
    Редактировать новость
@endsection
@section('dashboard-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Форма для заполнение новостей</h3>
                </div>
                <form action="{{route('news.update', ['news'=>  $news->id])}}"
                      method="post"
                      enctype="multipart/form-data">
                    {{Form::token()}}
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Название новости</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pen"></i></span>
                                    </div>

                                    {!! Form::text('name',$news->name,[
                                                'class' => 'form-control',
                                                ]) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Загаловок новости</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-newspaper"></i></span>
                                    </div>
                                    {!! Form::text('title',$news->title,[
                                                'class' => 'form-control',
                                                ]) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="icheck-primary d-inline">
                                    <input name="is_important" type="checkbox"
                                           id="checkboxPrimary1" {{$news->is_important ? 'checked' : ''}}>
                                    <label for="checkboxPrimary1">
                                        Важная новость
                                    </label>
                                </div>
                                <br>
                                <br>
                                <div class="icheck-primary d-inline">
                                    <input name="is_active" type="checkbox"
                                           id="checkboxPrimary2" {{$news->is_active ? 'checked' : ''}}>
                                    <label for="checkboxPrimary2">
                                        Активная новость
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputFile">Изображение новости Текушее
                                    изображение {{$news->image}} </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input name="image" type="file"
                                               class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
              <textarea id="summernote" name="news_content">
                  {{$news->content}}
              </textarea>
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
@section('js')
    <script src="{{asset("dashboard/plugins/summernote/summernote-bs4.min.js")}}"></script>
    <!-- CodeMirror -->
    <script src="{{asset("dashboard/plugins/codemirror/codemirror.js")}}"></script>
    <script src="{{asset("dashboard/plugins/codemirror/mode/css/css.js")}}"></script>
    <script src="{{asset("dashboard/plugins/codemirror/mode/xml/xml.js")}}"></script>
    <script src="{{asset("dashboard/plugins/codemirror/mode/htmlmixed/htmlmixed.js")}}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{asset("dashboard/plugins/bs-custom-file-input/bs-custom-file-input.min.js")}}"></script>
    <script>
        $(function () {
            // Summernote
            $('#summernote').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        });
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection
