<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Dashboard')</title>

    <!-- Adminkit CSS -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        
        {{-- Sidebar --}}
        @include('student.components.sidebar')

        <div class="main">
            
            {{-- Header --}}
            @include('student.components.header')

            <main class="content">
                <div class="container-fluid p-0">
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
            @include('student.components.footer')

        </div>
    </div>

    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
