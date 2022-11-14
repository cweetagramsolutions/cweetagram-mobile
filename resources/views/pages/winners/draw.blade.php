@extends('layouts.app')
@section('page-title', $draw->name)
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Numbers drawn</h3>
                    </div>
                    <div class="card-body">
                        <div class="float-left">
                            <form method="post" action="{{ route('winners.draw.update_state', $draw->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="state" value="approved" />
                                <button class="btn btn-success" type="submit">Approve</button>
                            </form>
                        </div>
                        <div class="float-right">
                            <form method="post" action="{{ route('winners.draw.update_state', $draw->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="state" value="declined" />
                                <button class="btn btn-danger">Decline</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover" id="winners">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Cell number</th>
                                    <th>Barcode digit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($winners as $winner)
                                    <tr>
                                        <td>{{ $winner->log->created_at }}</td>
                                        <td>{{ $winner->log->msisdn }}</td>
                                        <td>{{ $winner->log->barcode_input }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(function () {
            $('#winners').DataTable();
        });
    </script>
@endsection

