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
