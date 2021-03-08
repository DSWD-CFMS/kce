@extends('layouts.app')

@section('content')
    <!-- redirects to homepage -->
    @guest
    <script type="text/javascript">
        window.location.href="/";
    </script>
    @else
    <script type="text/javascript">
        window.location.href="/";
    </script>
    @endguest
@endsection
