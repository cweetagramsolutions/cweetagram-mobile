@extends('layouts.app')
@section('page-title', 'Winner draws')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-right">
                            <a href="{{ url('/home') }}">Back</a>
                        </div>
                        <h3>Draw winners</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('winners.draw.post') }}">
                            @csrf
                            <div class="form-group">
                                <label>Start date</label>
                                <input type="text" class="form-control datepicker" name="start_date" value="{{ old('start_date') }}" />
                                @error('start_date')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>End date</label>
                                <input type="text" class="form-control datepicker" name="end_date" value="{{ old('end_date') }}" />
                                @error('end_date')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Number of winners</label>
                                <input type="number" class="form-control" name="number_of_winners" value="{{ old('number_of_winners') }}" />
                                @error('number_of_winners')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Draw
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Winner Draws</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Start date</th>
                                    <th>End date</th>
                                    <th>Total number of winners</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($draws as $draw)
                                    <th>{{ $draw->name }}</th>
                                    <th>{{ $draw->start_date }}</th>
                                    <th>{{ $draw->end_date }}</th>
                                    <th>{{ $draw->winners->count() }}</th>
                                    <th>
                                        <a href="{{ route('winners.draw.export', $draw->id) }}" class="btn btn-primary">
                                            Download
                                        </a>
                                    </th>
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
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $('.datepicker').datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
@endsection
