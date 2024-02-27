<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css') }}">

</head>

<body>
    <header>
        <div>
            <h1>Admin Dashboard</h1>
        </div>
        <div>
            <a href="/admin/manage-users">Manage User</a>
            <a href="/admin/manage-roles">Manage Roles</a>
        </div>
    </header>
    <main>
        @yield('content')

    </main>
    <footer>
        &copy; 2024 Admin Dashboard. All Rights Reserved.
    </footer>
</body>

</html>
