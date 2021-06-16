<?php
/** @var \App\Models\User $currentUser */

use Illuminate\Support\Facades\Auth;

$roleName = (count(Auth::user()->getRoleNames()) ? Auth::user()->getRoleNames()[0] : '');
$social_id = $currentUser && $currentUser->social_id ? $currentUser->social_id : 'Не указано';
$disabled = Auth::user()->hasRole(['admin']) ? '' : 'disabled';
$profileImage = Auth::user()->image ? asset('files/images/' . DIRECTORY_SEPARATOR . Auth::user()->image) : asset('files/images/default/default_image.png');

?>
@extends('layouts.dashboard')
@section('dashboard-content')
    <div class="container">
        <div class="row flex-lg-nowrap">
            <div class="col">
                <div class="row">
                    <div class="col mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="e-profile">
                                    <div class="row">
                                        <div class="col-12 col-sm-auto mb-3">
                                            <div class="mx-auto" style="width: 140px;">
                                                <div id="image_block"
                                                     class="d-flex justify-content-center align-items-center rounded"
                                                     style="
                                                         height: 140px;
                                                         width: 140px;
                                                         background-image: url({{$profileImage}});
                                                         background-repeat:no-repeat;
                                                         background-position: center;
                                                         background-size: contain;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                            <div class="text-c  enter text-sm-left mb-2 mb-sm-0">
                                                <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{sprintf('%s %s',$currentUser->name, $currentUser->last_name)}}</h4>
                                                <p class="mb-0">ИИН: {{$social_id}}</p>
                                                <div class="text-muted"><small>Был в сети часа назад</small></div>
                                                <div class="mt-2">
                                                    <button id="change_image" class="btn btn-primary" type="button">
                                                        <i class="fa fa-fw fa-camera"></i>
                                                        <span>Изменить фото</span>
                                                    </button>
                                                    <input onchange="saveTemp(this)" id="file_input" type="file"
                                                           class="d-none">
                                                </div>
                                            </div>
                                            <div class="text-center text-sm-right">
                                                <span class="badge badge-secondary">{{$roleName}}</span>
                                                <div class="text-muted"><small>Дата
                                                        регистраций: {{date('Y-m-d',strtotime(Auth::user()->created_at))}}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a href="" class="active nav-link">Настройки</a></li>
                                    </ul>
                                    <div class="tab-content pt-3">
                                        <div class="tab-pane active">
                                            <form id="form" class="form" novalidate="">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Имя</label>
                                                                    <input class="form-control"
                                                                           type="text"
                                                                           name="first_name"
                                                                           value="{{$currentUser->first_name ?: $currentUser->name}}">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Фамилия</label>
                                                                    <input class="form-control" type="text"
                                                                           name="last_name"
                                                                           value="{{$currentUser->last_name}}">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Отчество</label>
                                                                    <input class="form-control" type="text"
                                                                           name="middle_name"
                                                                           value="{{$currentUser->middle_name}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(Auth::user()->hasRole(['student']))
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Имя родителя</label>
                                                                        <input {{$disabled}} class="form-control"
                                                                               type="text"
                                                                               name="first_name"
                                                                               value="{{$currentUser->parent_full_name}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Телефон родителя</label>
                                                                        <input {{$disabled}} class="form-control"
                                                                               type="text"
                                                                               name="first_name"
                                                                               value="{{$currentUser->parent_phone}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="row">
                                                            @if(Auth::user()->hasRole(['student']))
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Школа</label>
                                                                        <textarea {{$disabled}} class="form-control"
                                                                                  type="text"
                                                                                  name="first_name">{{$currentUser->school ?: $currentUser->school}}
                                                                    </textarea>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if(Auth::user()->hasRole(['teacher', 'moderator']))
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Телефон</label>
                                                                        <input {{$disabled}} class="form-control"
                                                                               name="phone"
                                                                               type="number"
                                                                               value="{{$currentUser->phone}}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if(Auth::user()->hasRole(['teacher', 'moderator', 'advisor']))
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>ИИН</label>
                                                                        <input {{$disabled}} class="form-control"
                                                                               name="social_id"
                                                                               type="number"
                                                                               value="{{$currentUser->social_id}}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="row">
                                                            @if(Auth::user()->hasRole(['student']))
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Адрес</label>
                                                                        <textarea class="form-control" name="address"
                                                                                  rows="5"
                                                                                  placeholder="Адрес...">{{$currentUser->address}}</textarea>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <div class="mb-2"><b>Изменить пароль</b></div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Новый пароль</label>
                                                                    <input class="form-control" type="password"
                                                                           name="password" placeholder="••••••">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Подтвердите пароль</label>
                                                                    <input class="form-control" type="password"
                                                                           name="password_confirmation"
                                                                           placeholder="••••••"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-5 offset-sm-1 mb-3">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label>Активность</label>
                                                                <div class="custom-controls-stacked px-2">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input {{$disabled}} type="checkbox"
                                                                               class="custom-control-input"
                                                                               id="notifications-blog" checked="">
                                                                        <label class="custom-control-label"
                                                                               for="notifications-blog">Активный</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col d-flex justify-content-end">
                                                        <button type="button" onclick="updateProfile()"
                                                                class="btn btn-primary">
                                                            Сохранить
                                                            изменение
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .notifyjs-happyblue-superblue {
        color: white;
        background-color: blue;
    }
</style>
@section('js')
    <script>
        $.notify.addStyle('warning', {
            html: "<div><span data-notify-text/></i></div>",
            classes: {
                base: {
                    "white-space": "nowrap",
                    "background-color": "lightgreen",
                    "padding": "5px"
                },
            }
        });

        $.notify.addStyle('danger', {
            html: "<div><span data-notify-text/></div>",
            classes: {
                base: {
                    "white-space": "nowrap",
                    "background-color": "red",
                    "color": "white",
                    "padding": "5px"
                },
            }
        });

        $("#change_image").bind('click', function () {
            $("#file_input").focus().trigger('click');
        });

        function saveTemp(object) {
            var file = $('#file_input').prop('files')[0];
            var formData = new FormData();
            formData.append('profile_image', file);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{route('file.temp_save')}}',
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function (response) {
                    if (response.success) {
                        $('#image_block').css('background-image', 'url(' + response.path + ')');
                        $.notify(' Чтобы сохранить изображение' +
                            ' необходимо нажать "Сохранить изменение" ', {
                            style: 'warning',
                        });
                    }
                }
            });
        }

        function updateProfile() {
            var form = $("#form")[0];
            var formData = new FormData(form);
            formData.append('action', 'update_student');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{route('profile.is_ajax')}}',
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function (response) {
                    if (response.success) {
                        $.notify(response.message, {
                            style: 'warning',
                        });
                    } else {
                        $.notify(response.message, {
                            style: 'danger',
                        });
                    }
                }
            });
        }
    </script>
@endsection
