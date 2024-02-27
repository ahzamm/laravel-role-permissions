<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">

</head>

<body>


    <form action="/admin/login" method="POST">
        <h2><strong>Login</strong></h2>
        @if ($errors->any())
            <div id="errorAlert" class="alert alert-danger" style="color: hsl(211, 100%, 50%);;">
                <ul>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="/admin/login" method="POST">
            @csrf
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
        </form>
</body>


@if ($errors->any())
    <script>
        setTimeout(function() {
            document.getElementById('errorAlert').style.display = 'none';
        }, 2000);
    </script>
@endif

</html>
