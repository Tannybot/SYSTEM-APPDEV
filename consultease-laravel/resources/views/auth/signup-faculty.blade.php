<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
    
    <title>Faculty Sign Up - ConsultEase</title>
    <style>
        .container{
            animation: transitionIn-X 0.5s;
        }
    </style>
</head>
<body>
    <center>
    <div class="container">
        <table border="0" style="width: 69%;">
            <tr>
                <td colspan="2">
                    <p class="header-text">Faculty Sign Up</p>
                    <p class="sub-text">Create Your Faculty Account.</p>
                </td>
            </tr>
            <tr>
                <form action="{{ route('signup.faculty') }}" method="POST">
                @csrf
                <td class="label-td" colspan="2">
                    <label for="name" class="form-label">Name: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <input type="text" name="fname" class="input-text" placeholder="First Name" value="{{ old('fname') }}" required>
                </td>
                <td class="label-td">
                    <input type="text" name="lname" class="input-text" placeholder="Last Name" value="{{ old('lname') }}" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="newemail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="email" name="newemail" class="input-text" placeholder="Email Address" value="{{ old('newemail') }}" required>
                </td>

            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="tele" class="form-label">Mobile Number: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                <input type="tel" name="tele" class="input-text" pattern="^\d{11}$" placeholder="ex. 07123456789" value="{{ old('tele') }}" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="subject" class="form-label">Subject: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="subject" class="input-text" placeholder="Enter Subject" value="{{ old('subject') }}" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="newpassword" class="form-label">Create New Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="newpassword" class="input-text" placeholder="New Password" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="cpassword" class="form-label">Confirm Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    @if(session('error'))
                        <label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">{{ session('error') }}</label>
                    @endif
                    @if ($errors->any())
                        <div style="color:rgb(255, 62, 62);text-align:center;font-size: 13px;">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </div>
                    @endif
                </td>
            </tr>

            <tr>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >
                </td>
                <td>
                    <input type="submit" value="Sign Up" class="login-btn btn-primary btn">
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                    <a href="{{ route('login') }}" class="hover-link1 non-style-link">Login</a>
                    <br><br><br>
                </td>
            </tr>

            </form>
            </tr>
        </table>

    </div>
</center>
</body>
</html>
