@extends('layouts.dashboard')
@section('title')
    Группы
@endsection
@section('dashboard-content')
    <div class="card">
        <div class="card-body">
            <table id="chat_data_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Группа</th>
                    <th>Предмет</th>
                    <th>Кол-во студентов</th>
                    @role('admin|teacher|advisor')
                    <th></th>
                    @endrole
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td>{{$group->id}}</td>
                        <td>{{$group->name}}</td>
                        <td>{{$group->subject->title}}</td>
                        <td>{{isset($group->students) ?count($group->students) : 0}}</td>
                        @role('admin|teacher|advisor')
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <a href="{{route('attendance.table', ['group_id' => $group->id])}}" type="submit"
                                       class="dropdown-item">
                                        <i class="fa fa-check-circle"></i>
                                        &nbsp;
                                        Проверить
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
            $("#chat_data_table").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
@endsection
