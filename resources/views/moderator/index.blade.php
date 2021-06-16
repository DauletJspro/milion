@extends('layouts.dashboard')
@section('title')
    Список модераторов
@endsection
@section('dashboard-content')
    <div class="card">
        @role('admin')
        <div class="card-header">
            <a href="{{route('moderator.create')}}" class="btn btn-success">Добавить модератора</a>
        </div>
        @endrole
        <!-- /.card-header -->
        <div class="card-body">
            <table id="moderator_data_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Активный</th>
                    <th>Дата создание</th>
                    @role('admin')
                    <th></th>
                    @endrole
                </tr>
                </thead>
                <tbody>
                @foreach($moderators as $moderator)
                    <tr>
                        <td>{{$moderator->first_name}}</td>
                        <td>{{$moderator->last_name}}</td>
                        <td>{{$moderator->is_active ? 'Да' : 'Нет'}}</td>
                        <td>{{$moderator->created_at}}</td>
                        @role('admin')
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <form action="{{ route('moderator.destroy', $moderator->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa fa-trash"></i>
                                            &nbsp;
                                            Удалить
                                        </button>
                                    </form>
                                    <a class="dropdown-item"
                                       href="{{route('moderator.edit', ['moderator' => $moderator->id])}}">
                                        <i class="fa fa-edit"></i>
                                        &nbsp;
                                        Редактировать
                                    </a>
                                </div>
                            </div>
                        </td>
                        @endrole
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
@section('js')
    <script src="{{asset("dashboard/plugins/datatables/jquery.dataTables.min.js")}}"></script>
    <script src="{{asset("dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}"></script>
    <script src="{{asset("dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js")}}"></script>
    <script src="{{asset("dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}"></script>
    <script>
        $(function () {
            $("#curator_data_table").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
@endsection
