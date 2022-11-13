@extends('layouts.app')
@section('page-title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('partials.dashboard.counter')
        @include('partials.dashboard.entries_table')
        @include('partials.dashboard.daily')
        @include('partials.dashboard.survey')
        @include('partials.dashboard.airtime')
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            loadDailyEntries('11');
            loadSurveyStats('region');

            $('select[name="dailyMonth"]').on('change', function () {
                loadDailyEntries($(this).val());
            });

            $('select[name="statSurvey"]').on('change', function () {
                loadSurveyStats($(this).val());
            });

            $.get('{!! url('api/dataset/entries') !!}', function (data) {
                $('#total').html(data.Total);
                $('#positive').html(data.Positive);
                $('#negative').html(data.Negative);
                $('#duplicate').html(data.Duplicate);
            });

            $('#entries').DataTable({
                serverSide: true,
                processing: true,
                order: [],
                ajax: {
                    url: '{!! url('api/dataset/list/entries') !!}'
                },
                columns: [
                    {data: 'created_at', value: 'created_at'},
                    {data: 'msisdn', value: 'msisdn'},
                    {data: 'network', value: 'network'},
                    {data: 'barcode_input', value: 'barcode_input'},
                    {data: 'state', value: 'state'},
                ]
            });

            $('#airtimeTable').DataTable({
                serverSide: true,
                processing: true,
                order: [],
                ajax: {
                    url: '{!! url('api/dataset/recharge/datatable') !!}'
                },
                columns: [
                    {data: 'created_at', value: 'created_at'},
                    {data: 'msisdn', value: 'msisdn'},
                    {data: 'amount_in_cents', value: 'amount_in_cents'},
                    {data: 'state', value: 'state'},
                    {data: 'provider_response', value: 'provider_response'},
                ]
            })
        });

        function loadSurveyStats(stat)
        {
            $.get('{!! url('api/dataset') !!}/' + stat + '/stats' , function (data) {

                let ctx = document.getElementById('surveyGraph').getContext('2d');
                let visitorsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: stat.toUpperCase() + ' survey stats',
                            data: data.data,
                            backgroundColor: data.bgColors,
                            borderColor: '#007bff',
                            pointBorderColor: '#007bff',
                            pointBackgroundColor: '#007bff',
                            fill: false,

                        }]
                    }
                });
            });
        }

        function loadDailyEntries(month)
        {
            $.get('{!! url('api/dataset/daily/') !!}/' + month, function (data) {

                let ctx = document.getElementById('dailyGraph').getContext('2d');
                let visitorsChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Daily entries',
                                data: data.data,
                                backgroundColor: 'transparent',
                                borderColor: '#007bff',
                                pointBorderColor: '#007bff',
                                pointBackgroundColor: '#007bff',
                                fill: false
                            }]
                        }
                });
            });
        }
    </script>
@endsection
