<!DOCTYPE html>
<html>
    <head>
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
    </head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>
  
    <table>
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
