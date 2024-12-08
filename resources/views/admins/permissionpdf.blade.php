<!DOCTYPE html>
<html>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>This is Your all the Permission's</p>
  
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            
        </tr>
        @foreach($permissions as $permission)
        <tr>
            <td>{{ $permission->id }}</td>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->guard_name }}</td>
            <td>{{ $permission->group_name }}</td>
            <td> </td>
               
           
        </tr>
        @endforeach
    </table>
  
</body>
</html>
