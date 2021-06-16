@extends('layouts.dashboard')
@section('dashboard-content')
    <div class="card">
        <div class="card-header">
            <a href="{{route('student.create')}}" class="btn btn-success">Добавить студента</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="curator_data_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Отчество</th>
                    <th>Email</th>
                    <th>Адрес</th>
                    <th>Школа</th>
                    <th>Телефон</th>
                    <th>Стоимость курса</th>
                    <th>Куратор</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{$student->name}}</td>
                        <td>{{$student->last_name}}</td>
                        <td>{{$student->middle_name}}</td>
                        <td>{{$student->user? $student->user->email : 'Не указано'}}</td>
                        <td>{{$student->address}}</td>
                        <td>{{$student->school}}</td>
                        <td>{{$student->phone}}</td>
                        <td>{{$student->course_price}}</td>
                        <td>{{$student->advisor_id}}</td>
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <form action="{{ route('student.destroy', $student->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa fa-trash"></i>
                                            &nbsp;
                                            Удалить
                                        </button>
                                    </form>
                                    <a class="dropdown-item"
                                       href="{{route('student.edit', ['student' => $student->id])}}">
                                        <i class="fa fa-edit"></i>
                                        &nbsp;
                                        Редактировать
                                    </a>
                                    <button onclick="debt_modal(this)"
                                            type="button"
                                            class="dropdown-item"
                                            data-user_id="{{$student->user ? $student->user->id : null}}"
                                            data-debt="{{$student->user && $student->user->debt ? $student->user->debt : 0 }}"
                                    >
                                        <i class="fa fa-money-bill-alt"></i>
                                        &nbsp;
                                        Задолжность
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="student_debt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('student.debt')}}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Указать задолжность</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="debt">
                            Задолжность *
                        </label>
                        <input type="text" name="debt" id="debt" class=" form-control">
                        <input type="hidden" id="user_id" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button
                            type="submit" class="btn btn-primary">Сохранить
                        </button>
                    </div>
                </div>
            </form>
        </div>
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

        function debt_modal(object) {
            var id = $(object).data('user_id');
            var debt = $(object).data('debt');

            $('#debt').val(debt);
            $('#user_id').val(id);

            $('#student_debt').modal();
        }
    </script>
@endsection
