<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css') }}">
    <script>
        function attachToken() {
            var token = document.cookie.replace(/(?:(?:^|.*;\s*)token\s*=\s*([^;]*).*$)|^.*$/, "$1");
            if (token) {
                console.log("=====TOKEN===", token);
                fetch('/admin/manage-users', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token 
                    }
                })
            }
        }
    </script>

</head>

<body>
    <header class="mainbox">
        <div>
            <h1>Admin Dashboard</h1>
        </div>
        <div>
            <a href="/admin/manage-users" id="manageUsersLink" onclick="attachToken()">Manage Users</a>
            <a href="/admin/manage-roles">Manage Roles</a>
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
