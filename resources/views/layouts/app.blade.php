<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', "Sir Shahbaz's Atlas Academy")
    </title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">

</head>


<body>

<div class="app-layout">


    {{-- =========================================
         SIDEBAR
    ========================================== --}}

    <aside class="sidebar">

        <div class="sidebar-brand">

        <div class="receipt-image">
        
         <img src="{{ asset('Academylogo.png')}}" alt="Logo" class="academy-logo-navbar">
        </div>


            <!-- <h2>
                Atlas Academy
            </h2>

            <span>
                Student Management
            </span> -->

        </div>


        <nav class="sidebar-nav">


            {{-- Dashboard --}}

            @if(
                auth()->check() &&
                in_array(auth()->user()->role, ['developer', 'director'])
            )

                <a
                    href="{{ route('dashboard') }}"
                    class="nav-item"
                >

                    <span class="nav-icon">
                        ⌂
                    </span>

                    Dashboard

                </a>

            @endif


            {{-- Inquiry Students --}}

            <a
                href="{{ route('inquiry-students.index') }}"
                class="nav-item"
            >

                <span class="nav-icon">
                    ◉
                </span>

                Inquiry Students

            </a>


            {{-- Enrolled Students --}}

            <a
                href="{{ route('enrolled-students.index') }}"
                class="nav-item"
            >

                <span class="nav-icon">
                    ◆
                </span>

                Enrolled Students

            </a>


            {{-- Teachers --}}

            <a
                href="{{ route('teachers.index') }}"
                class="nav-item"
            >

                <span class="nav-icon">
                    ♟
                </span>

                Teachers

            </a>


            {{-- Classes --}}

            <a
                href="#"
                class="nav-item"
            >

                <span class="nav-icon">
                    ▣
                </span>

                Classes & Subjects

            </a>


            {{-- Fees --}}

            <a
                href="{{ route('fee-structures.index') }}"
                class="nav-item"
            >

                <span class="nav-icon">
                    ₨
                </span>

                Fee Management

            </a>


            {{-- Reports --}}

            <a
                href="{{ route('reports.fees-history') }}"
                class="nav-item"
            >

                <span class="nav-icon">
                    ▤
                </span>

                Reports

            </a>


            {{-- Settings --}}

            <a
                href="#"
                class="nav-item"
            >

                <span class="nav-icon">
                    ⚙
                </span>

                Settings

            </a>

            <a
    href="#"
    class="nav-item"
    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
>
    <span class="nav-icon">⇥</span>
    Sign Out
</a>

<form
    id="logout-form"
    method="POST"
    action="{{ route('logout') }}"
    style="display: none;"
>
    @csrf
</form>

        </nav>


        {{-- Sidebar Footer --}}
<div class="sidebar-footer">

    <span>
        © {{ date('Y') }}
    </span>

    <strong>
        Atlas Academy
    </strong>

</div>
    </aside>


    {{-- =========================================
         MAIN AREA
    ========================================== --}}

    <div class="main-area">


        {{-- =========================================
             HEADER
        ========================================== --}}

        <!-- Academy Header -->

<header class="top-header academy-top-header">

    <div class="academy-heading">

        <div class="academy-sir">
            Sir Shahbaz's
        </div>

        <div class="academy-title">
            ATLAS ACADEMY
        </div>

        <div class="academy-tagline">
            Access Towards Leading &amp; Acme Success
        </div>

    </div>

</header>


        {{-- =========================================
             PAGE CONTENT
        ========================================== --}}

        <main class="page-content">


            {{-- Success Message --}}

            @if(session('success'))

                <div class="alert-success">

                    {{ session('success') }}

                </div>

            @endif


            {{-- Error Message --}}

            @if(session('error'))

                <div class="alert-error">

                    {{ session('error') }}

                </div>

            @endif


            @yield('content')


        </main>

    </div>

</div>

</body>

</html>