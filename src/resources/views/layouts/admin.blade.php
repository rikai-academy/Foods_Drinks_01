<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.admin.head')
    @livewireStyles
</head>
<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark fixed-top">
        @include('includes.admin.header')
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark mt-5" id="sidenavAccordion">
                @include('includes.admin.navbar')
            </nav>
        </div>
        <div id="layoutSidenav_content" class="mt-5">
            <main>
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                @include('includes.admin.footer')
            </footer>
        </div>
    </div>

    @include('includes.admin.lib-js')
    @livewireScripts
</body>
