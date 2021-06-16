@extends('layouts.dashboard')
@section('dashboard-content')
    <div class="card">
        @role('admin')
        <div class="card-header">
            <a href="{{route('group.create')}}" class="btn btn-success">Добавить группу</a>
        </div>
        @endrole
        <!-- /.card-header -->
        <div class="card-body">
            <table id="curator_data_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Предмет группы</th>
                    <th>Кол-во студентов</th>
                    <th>Преподаватель</th>
                    <th>Дата создание</th>
                    <th>Дата изменение</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td>{{$group->name}}</td>
                        <td>{{$group->subject ? $group->subject->title : 'Не указано'}}</td>
                        <td>{{count($group->groupStudents)}}</td>
                        <td>{{$group->teacher ?sprintf('%s %s', $group->teacher->first_name,  $group->teacher->last_name ) : 'Не указано'}}</td>
                        <td>{{$group->created_at}}</td>
                        <td>{{$group->updated_at}}</td>
                        @role('admin')
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <form action="{{ route('group.destroy', $group->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa fa-trash"></i>
                                            &nbsp;
                                            Удалить
                                        </button>
                                    </form>
                                    <a class="dropdown-item"
                                       href="{{route('group.edit', ['group' => $group->id])}}">
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
