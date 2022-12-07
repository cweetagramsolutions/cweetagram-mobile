<table class="table table-hover"  id="entries">
    <thead>
    <tr>
        <th>Date</th>
        <th>Cell number</th>
        <th>Age group</th>
        <th>Region</th>
    </tr>
    </thead>
    <tbody>
    @foreach($surveys as $survey)
        <tr>
            <td>{{ $survey->created_at }}</td>
            <td>{{ $survey->msisdn }}</td>
            <td>{{ $survey->age_group }}</td>
            <td>{{ $survey->location }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

