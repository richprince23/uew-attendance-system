<head>
    <link rel="stylesheet" href="/resources/sass/app.scss">
</head>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Index Number</th>
            {{-- <th>Group</th> --}}
            <th>Level</th>
            <th>Department</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
            <tr>
                <td>{{ $record->other_names.' '. $record->surname}} </td>
                <td>{{ $record->index_number }}</td>
                {{-- <td>{{ $record->group }}</td> --}}
                <td>{{ $record->level }}</td>
                <td>{{ $record->department->name }}</td>
                <td>{{ $record->phone }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
