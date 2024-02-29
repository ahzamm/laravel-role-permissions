@extends('base-template')

@section('content')
    @if ($errors->any())
        <div id="errorAlert" class="alert alert-danger" style="color: hsl(211, 100%, 50%);;">
            <ul>
                @foreach ($errors->all() as $error)
                    <h1 style="text-align: center">{{ $error }}</h1>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($errors->any())
        <script>
            setTimeout(function() {
                document.getElementById('errorAlert').style.display = 'none';
            }, 2000);
        </script>
    @endif
@endsection
