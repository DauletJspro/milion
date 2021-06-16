<?php

use Spatie\Permission\Models\Role;

$all_roles = Role::all()->pluck('name', 'id');
?>

@extends('layouts.dashboard')
@section('dashboard-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Добавить пользоателя</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Имя</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Ввидите имя ...">
                            </div>
                            <div class="form-group">
                                <label for="surname">Фамилия</label>
                                <input type="text" class="form-control" id="surname" name="surname"
                                       placeholder="Ввидите фамилию">
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Номер телефона</label>
                                <input type="textы" class="form-control" id="phone_number"
                                       placeholder="Ввидите номер телефона">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email"
                                       placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="school">Школа</label>
                                <input type="text" class="form-control" id="school"
                                       placeholder="Укажите школу">
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль</label>
                                <input type="password" class="form-control" id="password"
                                       placeholder="Пароль">
                            </div>
                            <div class="form-group">
                                <label>Select</label>
                                <select class="form-control">
                                    @foreach($all_roles as $key => $role)
                                        <option value="{{$key}}">{{$role}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection

