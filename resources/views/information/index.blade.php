@extends('layouts.dashboard')
@section('title')
    Информация
@endsection
@section('dashboard-content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                @role('admin')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$results['user_count']}}</h3>
                            <p>Кол-во пользователей</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Подробнее<i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                @endrole
                @role('admin|advisor')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$results['student_count']}}</h3>

                            <p>Кол-во студентов</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Подробнее<i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                @endrole
                @role('admin')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$results['advisor_count']}}</h3>

                            <p>Кол-во кураторов</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Подробнее<i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                @endrole
                @role('admin')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$results['teacher_count']}}</h3>
                            <p>Кол-во учителей</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Подробнее<i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                @endrole
                @role('admin|teacher|advisor|moderator|student')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$results['group_count']}}</h3>
                            <p>Кол-во групп</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Подробнее<i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                @endrole
                @role('admin|teacher|advisor|moderator|student')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$results['subject_count']}}</h3>
                            <p>Кол-во предметов</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-address-book"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Подробнее<i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                @endrole
                @role('admin|teacher|advisor|moderator')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$results['news_count']}}</h3>
                            <p>Кол-во новостей</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Подробнее<i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                @endrole
            </div>
        </div>
        @role('admin|moderator')
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">График активности пользователей</h3>
                                <a href="javascript:void(0);">Посмотреть таблицу</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg"></span>
                                    <span>Общее кол-во активных пользователей</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="chart">
                                <canvas id="barChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <button id="left_button_registered_count"
                                        onclick="ajax(this)"
                                        data-type="registered_count"
                                        data-week_number="1"
                                        class="mr-2 btn btn-success text-white">
                                    <i class="fas fa-arrow-left"></i> &nbsp; Предыдущая неделя
                                </button>

                                <button id="right_button_registered_count"
                                        onclick="ajax(this)"
                                        data-type="registered_count"
                                        data-week_number="-1"
                                        class=" btn btn-success text-white">
                                    Следующая неделя &nbsp;<i class="fas fa-arrow-right "></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endrole
    </div>
@endsection
@section('js')
    <script>
        ajax(null, 'registered_count');

        function ajax(item, init_type = null) {
            if (item) {
                var type = $(item).data('type');
                var week_number = $(item).data('week_number');
            } else {
                var type = init_type;
                var week_number = 0;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'POST',
                url: '/admin/information/ajax',
                data: {type: type, week_number: week_number},
                success: function (data) {
                    implement_chart(data)
                }
            });
        }

        function implement_chart(data) {

            if (data.type == 'registered_count') {
                var barChartCanvas = $('#barChart').get(0).getContext('2d')
                label = 'Динамика регистраций пользователей';
            }

            var areaChartData = {
                labels: data.weekDays,
                datasets: [
                    {
                        label: label,
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: data.registered_count
                    },
                ]
            }

            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            barChartData.datasets[0] = temp0

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            stepSize: 1
                        }
                    }]
                },
            }

            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

            $('#left_button_registered_count').data('week_number', data.week_number - 1);
            $('#right_button_registered_count').data('week_number', data.week_number + 1);

        }
    </script>
@endsection
