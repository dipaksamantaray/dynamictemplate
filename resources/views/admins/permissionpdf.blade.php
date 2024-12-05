<!DOCTYPE html>
<html>
<head>
    <title>Permission's PDF</title>
   
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>This is Your all the Permission's</p>
  
    <table class="table table-bordered">
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
