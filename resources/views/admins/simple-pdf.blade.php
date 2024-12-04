<!-- resources/views/admins/simple-pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admins Export</title>
</head>
<body>
    <h1>Admins List</h1>
    <ul>
        @foreach ($admins as $admin)
            <li>{{ $admin->name }} - {{ $admin->email }}</li>
        @endforeach
    </ul>
</body>
</html>
