<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/livewallpaper.css') }}">

    <title>Sign Up - ConsultEase</title>

</head>
<body>
    @include('layouts.livewallpaper')

<div class="center-wrapper">
    <div class="container">
        <form action="{{ url('/signup/role') }}" method="POST">
            @csrf
            <div class="form-inner">
                <p class="header-text">Let's Get Started</p>
                <p class="sub-text">Select Your Role to Continue</p>

                <div class="form-group">
                    <label class="form-label">I am a:</label>
                </div>
                <div class="form-group role-options">
                    <label class="role-card">
                        <input type="radio" name="role" value="student" required>
                        <span class="role-label">🎓 Student</span>
                    </label>
                    <label class="role-card">
                        <input type="radio" name="role" value="faculty" required>
                        <span class="role-label">👨‍🏫 Faculty</span>
                    </label>
                </div>

                <div class="form-group">
                    <input type="submit" value="Next" class="login-btn btn-primary btn">
                </div>

                <div class="form-group" style="text-align:center;">
                    <label class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                    <a href="{{ url('/login') }}" class="hover-link1 non-style-link">Login</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>