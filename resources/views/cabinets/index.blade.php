@extends('layouts.dashboard')
@section('dashboard-content')
    <div class="card">
        <div class="card-header">
            <a href="{{route('cabinet.create')}}" class="btn btn-success">Добавить кабинет</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="curator_data_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Номер кабинета</th>
                    <th>Этаж</th>
                    <th>Дата создание</th>
                    <th>Дата изменение</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cabinets as $cabinet)
                    <tr>
                        <td>{{$cabinet->title}}</td>
                        <td>{{$cabinet->floor}}</td>
                        <td>{{$cabinet->created_at}}</td>
                        <td>{{$cabinet->updated_at}}</td>
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
