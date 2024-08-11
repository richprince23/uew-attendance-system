<head>
    <link rel="stylesheet" href="/resources/sass/app.scss">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div class="container mx-auto p-4">
    <h3>{{$records[0]->department->name}}</h3>
    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                <th class="text-left py-2 px-4 border-b border-gray-200 uppercase">Name</th>
                <th class="text-left py-2 px-4 border-b border-gray-200">Index Number</th>
                {{-- <th class="text-left py-2 px-4 border-b border-gray-200">Group</th> --}}
                <th class="text-left py-2 px-4 border-b border-gray-200">Level</th>
                {{-- <th class="text-left py-2 px-4 border-b border-gray-200">Department</th> --}}
                <th class="text-left py-2 px-4 border-b border-gray-200">Phone</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b border-gray-200">{{ $record->name }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $record->index_number }}</td>
                    {{-- <td class="py-2 px-4 border-b border-gray-200">{{ $record->group }}</td> --}}
                    <td class="py-2 px-4 border-b border-gray-200">{{ $record->level }}</td>
                    {{-- <td class="py-2 px-4 border-b border-gray-200">{{ $record->department->name }}</td> --}}
                    <td class="py-2 px-4 border-b border-gray-200">{{ $record->phone }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    /* Container styling */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff;
    border: 1px solid #dddddd;
    border-radius: 8px;
    overflow: hidden;
}

/* Table header styling */
thead {
    background-color: #f5f5f5;
}

th {
    text-align: left;
    padding: 12px;
    border-bottom: 1px solid #dddddd;
    font-weight: bold;
    text-transform: uppercase;
}

/* Table body styling */
td {
    padding: 12px;
    border-bottom: 1px solid #dddddd;
}

/* Row hover effect */
tbody tr:hover {
    background-color: #f9f9f9;
}

/* Optional: Specific styling for mobile view */
@media (max-width: 768px) {
    th, td {
        padding: 10px;
    }
}
</style>
