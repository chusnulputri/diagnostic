<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link rel="shortcut icon" href="{{ asset('assets/logo/res-navicon.ico') }}"> -->
    <title>Pakar Diagnosis</title>

    @include('_partials.styles')
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCYL023NqhhEO9p-2eiSMw0GY-nwZmlc_A" type="text/javascript">
    </script>
</head>

<body class="fixed-sidebar">
    <div id="wrapper">
        @include('_partials.sidebar')

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                @include('_partials.topnav')
            </div>

            <div class="wrapper wrapper-content" style="padding: 0px;">
                @yield('content')
            </div>

            @include('_partials.footer')
        </div>

        @include('_partials.rightSidebar')

    </div>

    @include('_partials.modal')

    <!-- Mainly scripts -->

    @include('_partials.scripts')
</body>

</html>
