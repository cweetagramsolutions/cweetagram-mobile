<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3>Airtime stats</h3>
            <h4>Total airtime rewarded: <strong> R {{ $total_airtime }}</strong></h4>
        </div>
        <div class="card-header">
            <form method="post" action="{{ route('home.recharges.export') }}">
                @csrf
                <button class="btn btn-primary" type="submit">
                    Download excel
                </button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="airtimeTable">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Cell number</th>
                        <th>Amount</th>
                        <th>Status</th>
                        @if(auth()->user()->email === 'chancel@cweetagram.co.za')
                            <th>Provider response</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
