<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargo Page</title>
</head>
<body>
    <h1>All Cargos</h1>

    <a href="{{ route{'cargo.create'} }}">Create New Cargo</a>

    @foreach ($cargos as $cargo)
        <div>
            <h2>{{ $cargo->name }}</h2>
            <p>description: {{ $cargo->description }}</p>
            <p>Weight: {{ $cargo->weight }}</p>
            <p>volume: {{ $cargo->volume }}</p>
            <p>Destination: {{ $cargo->destination }}</p>
            <p>client_id: {{ $cargo->client_id }}</p>
            <p>Cargo_type: {{ $cargo->cargo_type }}</p>
            <p>is_active: {{ $cargo->is_active ? 'Yes' : 'No' }}</p>
            <a href="{{ route('cargo.edit', $cargo->id) }}">Edit</a>
        </div>
    @endforeach
    @if ($cargos->isEmpty())
        <p>No cargos available.</p>
    @endif
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <a href="{{ route('home') }}">Back to Home</a>

</body>
</html>