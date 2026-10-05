<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login | Sir Shahbaz's Atlas Academy</title>

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100%;
        }

        body {
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background: #f4f6f9;
            color: #172033;
        }


        /* =========================================
           LOGIN PAGE
        ========================================= */

        .login-page {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px;

            background:
                radial-gradient(
                    circle at top left,
                    rgba(30, 64, 175, 0.08),
                    transparent 35%
                ),
                radial-gradient(
                    circle at bottom right,
                    rgba(15, 23, 42, 0.06),
                    transparent 35%
                ),
                #f5f7fa;
        }


        /* =========================================
           LOGIN CONTAINER
        ========================================= */

        .login-wrapper {

            width: 100%;

            max-width: 1050px;

            min-height: 620px;

            display: grid;

            grid-template-columns: 1fr 1fr;

            background: #ffffff;

            border-radius: 24px;

            overflow: hidden;

            box-shadow:
                0 30px 70px rgba(15, 23, 42, 0.12),
                0 10px 25px rgba(15, 23, 42, 0.05);
        }


        /* =========================================
           BRAND PANEL
        ========================================= */

        .brand-panel {

            position: relative;

            display: flex;

            flex-direction: column;

            justify-content: center;

            padding: 65px;

            color: #ffffff;

            background:
                linear-gradient(
                    145deg,
                    #111827 0%,
                    #1e293b 55%,
                    #334155 100%
                );

            overflow: hidden;
        }


        .brand-panel::before {

            content: "";

            position: absolute;

            width: 350px;

            height: 350px;

            border-radius: 50%;

            top: -160px;

            right: -130px;

            background: rgba(255,255,255,0.04);
        }


        .brand-panel::after {

            content: "";

            position: absolute;

            width: 250px;

            height: 250px;

            border-radius: 50%;

            bottom: -120px;

            left: -100px;

            background: rgba(255,255,255,0.035);
        }


        .brand-content {

            position: relative;

            z-index: 2;
        }


        .brand-small {

            font-size: 15px;

            font-weight: 600;

            letter-spacing: 1px;

            text-transform: uppercase;

            opacity: 0.75;

            margin-bottom: 8px;
        }


        .brand-name {

            margin: 0;

            font-size: 42px;

            line-height: 1.05;

            font-weight: 800;

            letter-spacing: -1.5px;
        }


        .brand-academy {

            margin-top: 3px;

            font-size: 48px;

            line-height: 1;

            font-weight: 900;

            letter-spacing: -2px;
        }


        .brand-line {

            width: 70px;

            height: 4px;

            margin: 28px 0;

            border-radius: 10px;

            background: #ffffff;
        }


        .brand-tagline {

            max-width: 330px;

            margin: 0;

            font-size: 16px;

            line-height: 1.7;

            color: rgba(255,255,255,0.75);
        }


        .brand-footer {

            position: absolute;

            left: 65px;

            bottom: 35px;

            z-index: 2;

            font-size: 12px;

            color: rgba(255,255,255,0.45);
        }


        /* =========================================
           LOGIN FORM PANEL
        ========================================= */

        .login-panel {

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 60px;
        }


        .login-content {

            width: 100%;

            max-width: 390px;
        }


        .login-heading {

            margin-bottom: 35px;
        }


        .login-heading h1 {

            margin: 0 0 8px;

            font-size: 31px;

            font-weight: 800;

            color: #172033;

            letter-spacing: -0.8px;
        }


        .login-heading p {

            margin: 0;

            font-size: 14px;

            color: #7b8495;

            line-height: 1.6;
        }


        /* =========================================
           FORM
        ========================================= */

        .form-group {

            margin-bottom: 22px;
        }


        .form-label {

            display: block;

            margin-bottom: 8px;

            font-size: 13px;

            font-weight: 700;

            color: #374151;
        }


        .form-input {

            width: 100%;

            height: 52px;

            padding: 0 16px;

            border: 1px solid #dfe4ea;

            border-radius: 11px;

            outline: none;

            font-size: 14px;

            color: #172033;

            background: #fafbfc;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }


        .form-input:focus {

            background: #ffffff;

            border-color: #334155;

            box-shadow:
                0 0 0 4px rgba(51, 65, 85, 0.08);
        }


        .form-input::placeholder {

            color: #a4acb9;
        }


        /* =========================================
           REMEMBER ME
        ========================================= */

        .remember-row {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin: 5px 0 27px;
        }


        .remember-label {

            display: flex;

            align-items: center;

            gap: 8px;

            cursor: pointer;

            font-size: 13px;

            color: #6b7280;
        }


        .remember-label input {

            width: 16px;

            height: 16px;

            accent-color: #1e293b;

            cursor: pointer;
        }


        /* =========================================
           LOGIN BUTTON
        ========================================= */

        .login-button {

            width: 100%;

            height: 53px;

            border: 0;

            border-radius: 11px;

            background:
                linear-gradient(
                    135deg,
                    #111827,
                    #334155
                );

            color: #ffffff;

            font-size: 14px;

            font-weight: 700;

            letter-spacing: 0.3px;

            cursor: pointer;

            box-shadow:
                0 10px 20px rgba(15, 23, 42, 0.15);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }


        .login-button:hover {

            transform: translateY(-1px);

            box-shadow:
                0 14px 25px rgba(15, 23, 42, 0.20);
        }


        .login-button:active {

            transform: translateY(0);
        }


        /* =========================================
           ERROR
        ========================================= */

        .error-message {

            margin-top: 7px;

            font-size: 12px;

            color: #dc2626;
        }


        /* =========================================
           SECURITY NOTE
        ========================================= */

        .security-note {

            margin-top: 28px;

            padding-top: 20px;

            border-top: 1px solid #edf0f3;

            text-align: center;

            font-size: 11px;

            color: #9aa2af;
        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 850px) {

            .login-wrapper {

                grid-template-columns: 1fr;

                max-width: 500px;

                min-height: auto;
            }


            .brand-panel {

                padding: 45px;

                min-height: 300px;
            }


            .brand-name {

                font-size: 34px;
            }


            .brand-academy {

                font-size: 39px;
            }


            .brand-footer {

                left: 45px;

                bottom: 25px;
            }


            .login-panel {

                padding: 45px;
            }
        }


        @media (max-width: 500px) {

            .login-page {

                padding: 15px;
            }


            .brand-panel {

                padding: 35px;

                min-height: 270px;
            }


            .brand-name {

                font-size: 29px;
            }


            .brand-academy {

                font-size: 34px;
            }


            .login-panel {

                padding: 35px 25px;
            }
        }

    </style>

</head>


<body>

<div class="login-page">

    <div class="login-wrapper">


        {{-- =========================================
             BRANDING
        ========================================== --}}

        <section class="brand-panel">

            <div class="brand-content">

                <div class="brand-small">
                    Welcome to
                </div>

                <h2 class="brand-name">
                    Sir Shahbaz's
                </h2>

                <div class="brand-academy">
                    ATLAS ACADEMY
                </div>

                <div class="brand-line"></div>

                <p class="brand-tagline">
                    Access Towards Leading &amp; Acme Success
                </p>

            </div>


            <div class="brand-footer">

                Student Management System
                &nbsp;•&nbsp;
                Secure Access

            </div>

        </section>


        {{-- =========================================
             LOGIN
        ========================================== --}}

        <section class="login-panel">

            <div class="login-content">


                <div class="login-heading">

                    <h1>
                        Welcome Back
                    </h1>

                    <p>
                        Sign in to access the Academy Management System.
                    </p>

                </div>


                {{-- Session Status --}}

                @if (session('status'))

                    <div class="error-message">
                        {{ session('status') }}
                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('login') }}"
                >

                    @csrf


                    {{-- Email --}}

                    <div class="form-group">

                        <label
                            for="email"
                            class="form-label"
                        >
                            Email Address
                        </label>

                        <input
                            id="email"
                            class="form-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                            required
                            autofocus
                            autocomplete="username"
                        >

                        @error('email')

                            <div class="error-message">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Password --}}

                    <div class="form-group">

                        <label
                            for="password"
                            class="form-label"
                        >
                            Password
                        </label>

                        <input
                            id="password"
                            class="form-input"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                        >

                        @error('password')

                            <div class="error-message">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Remember --}}

                    <div class="remember-row">

                        <label
                            for="remember"
                            class="remember-label"
                        >

                            <input
                                id="remember"
                                type="checkbox"
                                name="remember"
                            >

                            <span>
                                Remember me
                            </span>

                        </label>

                    </div>


                    {{-- Login --}}

                    <button
                        type="submit"
                        class="login-button"
                    >
                        Sign In to Academy
                    </button>

                </form>


                <div class="security-note">

                    Authorized personnel only.
                    <br>
                    Secure Academy Management System

                </div>


            </div>

        </section>

    </div>

</div>

</body>

</html>