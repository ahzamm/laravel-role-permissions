@extends('base-template')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 5px 10px;
            color: rgb(0, 0, 0);
            border: none;
            cursor: pointer;
        }

        .green {
            background-color: green;
        }

        .blue {
            background-color: #007bff;
        }

        .red {
            background-color: red;
        }
    </style>
    <h1>Users Management</h1>
    <button style="color: white" class="green">Create New User</button>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['role'] }}</td>
                    <td>
                        <button>Show</button>
                        <button>Edit</button>
                        <button>Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
