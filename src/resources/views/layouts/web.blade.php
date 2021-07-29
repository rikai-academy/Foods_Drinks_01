<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.web.head')
</head>
<body>
    <header id="header">
        @include('includes.web.header')
    </header>

    @yield('content')

    <footer id="footer">
        @include('includes.web.footer')
    </footer>

    @include('includes.web.lib-js')
</body>
