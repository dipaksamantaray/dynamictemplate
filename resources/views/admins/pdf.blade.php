<!DOCTYPE html>
<html>
<head>
    <title>Admin's PDF</title>
   
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
    <p>This is Your all the Admin's</p>
  
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @foreach ($user->roles as $role)
                    <span class="badge badge-primary">{{ $role->name }}</span>
                    {{-- {{dd($role->name)}} --}}
                @endforeach
            </td>
        </tr>
        @endforeach
    </table>
  
</body>
</html>
