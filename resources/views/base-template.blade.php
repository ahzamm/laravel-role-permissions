<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <header class="mainbox">
        <div>
            <h1>Admin Dashboard</h1>
        </div>
        <div>
            <a href="/admin/manage-users" id="manageUsersLink" onclick="attachToken()">Manage Users</a>
            <a href="/admin/manage-roles">Manage Roles</a>
            <a href="/admin/logout">Logout</a>
        </div>
    </header>
    <main>
        <div class="mainbox">@yield('content')</div>


    </main>
    <footer>
        &copy; 2024 Admin Dashboard. All Rights Reserved.
    </footer>
</body>

</html>
