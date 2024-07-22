<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.header')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('components.sidebar')

            <div class="layout-page">
                @include('components.navigation')
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
    @yield('js_custom')
</body>

</html>
