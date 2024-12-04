<!DOCTYPE html>
<html>
<head>
    <title>Laravel 11 Generate PDF Example - ItSolutionStuff.com</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua.</p>
  
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        @foreach($users as $index => $user)
        <tr>
            <td>{{ $index + 1 }}</td>  <!-- Display index as ID -->
            <td>{{ $user }}</td>       <!-- Display the string itself -->
        </tr>
        @endforeach
    </table>

</body>
</html>
