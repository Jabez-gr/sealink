<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargo Page</title>
</head>
<body>
    <h1>Create Cargo</h1>

    <form action="{{ route('cargo.store') }}" method="POST">
        @csrf
        
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="weight">Weight:</label>
            <input type="number" id="weight" name="weight" value="{{ old('weight') }}" required>
        </div>

        <div>
            <label for="destination">Destination:</label>
            <input type="text" id="destination" name="destination" value="{{ old('destination') }}" required>
        </div>

        <div>
            <label for="shipment_date">Shipment Date:</label>
            <input type="date" id="shipment_date" name="shipment_date" value="{{ old('shipment_date') }}" required>
        </div>

        <div>
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="pending">Pending</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
            </select>
        </div>

        <button type="submit">Create Cargo</button>
        <a href="{{ route('cargo.index') }}">Cancel</a>
    </form>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <a href="{{ route('cargo.index') }}">Back to Cargo List</a>
    
</body>
</html>