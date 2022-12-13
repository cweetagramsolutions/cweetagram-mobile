<table class="table table-hover" id="airtimeTable">
    <thead>
    <tr>
        <th>Date</th>
        <th>Cell number</th>
        <th>Amount</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
        @foreach($recharges as $recharge)
            <tr>
                <td>{{ $recharge->created_at }}</td>
                <td>{{ $recharge->msisdn }}</td>
                <td>{{ $recharge->amount_in_cents / 100 }}</td>
                <td>{{ ucfirst($recharge->state) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
