<table class="table table-hover"  id="entries">
    <thead>
    <tr>
        <th>Date</th>
        <th>Cell number</th>
        <th>Network</th>
        <th>Barcode</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
            <tr>
                <td>{{ $log->created_at }}</td>
                <td>{{ $log->msisdn }}</td>
                <td>{{ $log->network }}</td>
                <td>{{ $log->barcode_input }}</td>
                <td>{{ ucfirst($log->state) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
