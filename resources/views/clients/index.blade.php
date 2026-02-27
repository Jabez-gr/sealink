<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients List</title>
</head>
<body>
    <h1>All Clients</h1>

    {{-- Show success or error messages --}}
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    @if($clients->count())
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Address Details</th>
                    <th>Active?</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td>{{ $client->first_name }}</td>
                        <td>{{ $client->last_name }}</td>
                        <td>{{ $client->email_address }}</td>
                        <td>{{ $client->phone_number }}</td>
                        <td>{{ $client->address }}</td>
                        <td>{{ $client->address_details }}</td>
                        <td>{{ $client->is_active ? 'Active' : 'Inactive' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="pagination">
            {{ $clients->links() }}
        </div>
    @else
        <p>No clients found.</p>
    @endif

    <a href="{{ route('clients.create') }}">Create New Client</a> |
    <a href="{{ url('/') }}">Back to Home</a>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Clients page loaded');
        });
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination svg {
            width: 20px;
        }
    </style>
</body>
</html>
