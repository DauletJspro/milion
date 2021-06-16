@extends('layouts.dashboard')
@section('title')
    Чаты
@endsection
@section('dashboard-content')
    <div class="card">
        <div class="card-body">
            <table id="chat_data_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Вопрос</th>
                    <th>Ответ</th>
                    <th>Дата создание</th>
                    <th>Дата изменение</th>
                    @role('admin|moderator')
                    <th></th>
                    @endrole
                </tr>
                </thead>
                <tbody>
                @foreach($chats as $chat)
                    <tr>
                        <td>{{$chat->id}}</td>
                        <td>{{$chat->name}}</td>
                        <td>{{$chat->type}}</td>
                        <td>{{$chat->created_at}}</td>
                        <td>{{$chat->updated_at}}</td>
                        @role('admin|moderator')
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <form action="{{ route('chat.destroy', $chat->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item form-group">
                                            <i class="fa fa-trash"></i>
                                            &nbsp;
                                            Удалить
                                        </button>
                                    </form>
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
