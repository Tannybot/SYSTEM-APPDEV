<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ConsultEase - Faculty Consultation & Appointment Booking System. Schedule appointments with faculty members easily.">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">  
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">  
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>ConsultEase - Faculty Consultation System</title>
</head>
<body>
    <div class="full-height">
        <nav class="top-nav">
            <div class="nav-brand">
                <span class="edoc-logo">ConsultEase</span>
                <span class="edoc-logo-sub">| The Application Dev Project</span>
            </div>
            <div class="nav-links">
                <a href="{{ route('login') }}" class="non-style-link"><span class="nav-item">LOGIN</span></a>
                <a href="{{ route('signup') }}" class="non-style-link"><span class="nav-item nav-item-register">REGISTER</span></a>
            </div>
        </nav>

        <div class="hero-content">
            <h1 class="heading-text">Avoid Hassles &amp; Delays.</h1>
            <p class="sub-text2">
                Need to consult with a faculty member? Book your appointment online with ConsultEase.<br>
                We offer you a free Faculty Consultation Booking — schedule your session now!
            </p>
            <a href="{{ route('login') }}">
                <button class="login-btn btn-primary btn hero-btn">Make Appointment</button>
            </a>
        </div>

        <p class="sub-text2 footer-hashen">A Web Solution by Tannybot.</p>
    </div>
</body>
</html>
