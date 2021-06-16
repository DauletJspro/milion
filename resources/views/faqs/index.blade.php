@extends('layouts.dashboard')
@section('title')

    Часто задаваемые вопросы  (FAQ)

@endsection
@section('dashboard-content')
    <div class="card">
        @role('admin|moderator')
        <div class="card-header">
            <a href="{{route('faq.create')}}" class="btn btn-success">Добавить часто задаваемые вопросы</a>
        </div>
        @endrole
        <!-- /.card-header -->
        <div class="card-body">
            <table id="faq_fata_table" class="table table-bordered table-striped">
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
                @foreach($faqs as $faq)
                    <tr>
                        <td>{{$faq->question}}</td>
                        <td>{{$faq->answer}}</td>
                        <td>{{$faq->created_at}}</td>
                        <td>{{$faq->updated_at}}</td>
                        @role('admin|moderator')
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <a class="dropdown-item" href="{{route('faq.edit', $faq->id)}}">
                                        <i class="fa fa-edit"></i>
                                        &nbsp;
                                        Редактировать
                                    </a>
                                    <form action="{{ route('faq.destroy', $faq->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
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
            $("#faq_fata_table").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
@endsection
