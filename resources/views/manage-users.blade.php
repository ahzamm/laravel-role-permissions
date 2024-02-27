@extends('base-template')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 5px 10px;
            color: white;
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
@endsection

@section('content')
    <h1>Users Management</h1>
    <button class="green">Create New User</button>
    <table>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Action</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Sandeep</td>
            <td>sandeep@gmail.com</td>
            <td>Admin</td>
            <td>
                <button class="blue">Show</button>
                <button class="blue">Edit</button>
                <button class="red">Delete</button>
            </td>
        </tr>
    </table>

    @foreach ($users as $user)
        <p>Name: {{ $user['name'] }}</p>
        <p>Email: {{ $user['email'] }}</p>
        <p>Role: {{ $user['role'] }}</p>
    @endforeach
@endsection
