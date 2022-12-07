<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3>Entries</h3>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('home.entries.export') }}" class="form-inline">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control datepicker" name="start_date" placeholder="Start date" />
                </div>
                <div class="form-group ml-3 mr-3">
                    <input type="text" class="form-control datepicker" name="end_date" placeholder="End date" />
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-download"></i> Export
                </button>
            </form>
        </div>
    </div>
</div>
