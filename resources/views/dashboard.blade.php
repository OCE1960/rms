@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">

    <div class="col-sm-6">
        <h4 class="m-0 text-dark">Staff Dashboard</h4>
    </div>


    </div>
@stop


@section('content')

    @canany(['Super Admin', 'Result Compiler', 'Checking Officer', 'Registry','Dispatching Officer',
    'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',])
            @include('partials.dashboard-analytics')
    @endcanany

    <div class="row" id="info">

        {{-- @canany(['Super Admin', 'Result Compiler', 'Checking Officer', 'Registry','Dispatching Officer',
        'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',])
            @include('partials.admin-dashboard-content')
        @endcanany --}}
        <div class="col-md-6 my-3">
            <div class="shadow p-3 bg-white rounded">
                <h3>Bar Chart</h3>
                <canvas id="barChart" style="max-height: 500px"></canvas>
            </div>
        </div> <!-- end of col-md-6 -->

        <div class="col-md-6 my-3">
            <div class="shadow p-3 bg-white rounded">
                <h3>Bar Chart</h3>
                <canvas id="pieChart" style="max-height: 500px"></canvas>
            </div>
        </div> <!-- end of col-md-6 -->

        <div class="col-md-6 my-3">
            <div class="shadow p-3 bg-white rounded">
                <h3>Bar Chart</h3>
                <canvas id="doughnutChart" style="max-height: 500px"></canvas>
            </div>
        </div> <!-- end of col-md-6 -->

        <div class="col-md-6 my-3">
            <div class="shadow p-3 bg-white rounded">
                <h3>Bar Chart</h3>
                <canvas id="lineChart" style="max-height: 500px"></canvas>
            </div>
        </div> <!-- end of col-md-6 -->


    </div> <!-- /#info-box -->

@stop

@push('js')

    <script>
        $(document).ready(function() {
            $('#transcripts-requests').DataTable();

            new Chart(document.querySelector('#barChart'), {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May'],
                    datasets: [{
                        label: 'Bar Chart',
                        data: [65, 7, 12, 100, 23],
                    }],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                    },
                    start: 0,
                    indexAxis: 'y',
                },
            });

            new Chart(document.querySelector('#pieChart'), {
                type: 'pie',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May'],
                    datasets: [{
                        label: 'Bar Chart',
                        data: [65, 7, 12, 100, 23],

                        backgroundColor: [
                            'rgba(190, 210, 120)',
                            'rgba(190, 100, 180)',
                            'rgb(110, 80, 18)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 255, 0)',
                        ],
                    }],
                },
            });

            new Chart(document.querySelector('#lineChart'), {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May'],
                    datasets: [{
                        label: 'Bar Chart',
                        data: [65, 7, 12, 100, 23],
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                    }],
                },
            });

            new Chart(document.querySelector('#doughnutChart'), {
                type: 'doughnut',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May'],
                    datasets: [{
                        label: 'Bar Chart',
                        data: [65, 7, 12, 100, 23],

                        backgroundColor: [
                            'rgba(190, 210, 120)',
                            'rgba(190, 100, 180)',
                            'rgb(110, 80, 18)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 255, 0)',
                        ],
                    }],
                },
            });
        })
    </script>

@endpush
