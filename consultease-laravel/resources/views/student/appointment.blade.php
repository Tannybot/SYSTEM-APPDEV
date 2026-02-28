<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <title>Appointments</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .review-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            padding: 30px;
            z-index: 1001;
            max-width: 500px;
            width: 90%;
        }
        .review-modal h3 {
            margin-top: 0;
            color: #333;
        }
        .stars {
            display: flex;
            gap: 5px;
            margin: 10px 0;
        }
        .stars input {
            display: none;
        }
        .stars label {
            font-size: 30px;
            color: #ddd;
            cursor: pointer;
        }
        .stars input:checked ~ label,
        .stars label:hover,
        .stars label:hover ~ label {
            color: #ffc107;
        }
        .review-modal textarea {
            width: 100%;
            height: 80px;
            margin: 10px 0;
        }
        .review-modal .buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .notification-panel {
            position: fixed;
            top: 0;
            right: -400px;
            width: 350px;
            height: 100%;
            background: white;
            box-shadow: -2px 0 5px rgba(0,0,0,0.1);
            transition: right 0.3s;
            z-index: 1000;
            border-left: 1px solid #ddd;
        }
        .notification-panel.open {
            right: 0;
        }
        .notification-header {
            background: #228B22;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .notification-header .close-panel {
            cursor: pointer;
            font-size: 24px;
        }
        .notification-list {
            padding: 10px;
            max-height: calc(100% - 60px);
            overflow-y: auto;
        }
        .notification-item {
            background: #f8f9fa;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #228B22;
            cursor: pointer;
            transition: background 0.3s;
        }
        .notification-item.unread {
            background: #e8f5e9;
        }
        .notification-item.expanded {
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .notification-item .summary {
            font-weight: bold;
        }
        .notification-item .details {
            display: none;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        .notification-item.expanded .details {
            display: block;
        }
        .notification-item .time {
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="menu" id="menu">
        <table class="menu-container" border="0">
            <tr>
                <td style="padding:10px" colspan="2">
                    <table border="0" class="profile-container">
                        <tr>
                            <td width="30%" style="padding-left:20px" >
                                <img src="{{ asset('img/user.png') }}" alt="User Icon" style="width: 91.85px; height: 91.85px; border-radius:50%">
                            </td>
                            <td style="padding:0px;margin:0px;">
                                <p class="profile-title">{{ substr($student->sname,0,13) }}..</p>
                                <p class="profile-subtitle">{{ substr($student->semail,0,22) }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="logout-btn btn-primary-soft btn">Log out</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-home" >
                    <a href="{{ url('/student/dashboard') }}" class="non-style-link-menu "><div><p class="menu-text">Home</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-faculty">
                    <a href="{{ url('/student/faculty') }}" class="non-style-link-menu"><div><p class="menu-text">All Faculty</p></div></a>
                </td>
            </tr>

            <tr class="menu-row" >
                <td class="menu-btn menu-icon-session">
                    <a href="{{ url('/student/schedule') }}" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-appoinment  menu-active menu-icon-appoinment-active">
                    <a href="{{ url('/student/appointment') }}" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">My Bookings</p></div></a>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-settings">
                    <a href="{{ url('/student/settings') }}" class="non-style-link-menu"><div><p class="menu-text">Settings</p></div></a>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-notifications" id="notification-btn">
                    <div><p class="menu-text">Notifications</p></div>
                </td>
            </tr>

        </table>
    </div>
    <div class="dash-body" id="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr >
                <td width="13%" >
                    <a href="{{ url('/student/dashboard') }}" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                </td>
                <td>
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">My Bookings history</p>

                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Today's Date
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        {{ $today }}
                    </p>
                </td>
                <td width="10%">
                    <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="{{ asset('img/calendar.svg') }}" width="100%"></button>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="padding-top:10px;width: 100%;" >
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">My Bookings ({{ $appointments->count() }})</p>
                </td>

            </tr>
            <tr>
                <td colspan="4" style="padding-top:0px;width: 100%;" >
                    <center>
                        <table class="filter-container" border="0" >
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="5%" style="text-align: center;">
                                    Date:
                                </td>
                                <td width="30%">
                                    <form action="{{ url('/student/appointment') }}" method="post">
                                        @csrf
                                        <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                                </td>

                                <td width="12%">
                                    <input type="submit"  name="filter" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                                    </form>
                                </td>

                            </tr>
                        </table>

                    </center>
                </td>

            </tr>

            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0" style="border:none">

                                <tbody>
                                @if($appointments->count() == 0)
                                    <tr>
                                        <td colspan="7">
                                            <br><br><br><br>
                                            <center>
                                                <img src="{{ asset('img/notfound.svg') }}" width="25%">

                                                <br>
                                                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We couldnt find anything related to your keywords !</p>
                                                <a class="non-style-link" href="{{ url('/student/appointment') }}"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button></a>
                                            </center>
                                            <br><br><br><br>
                                        </td>
                                    </tr>
                                @else
                                    @php $count = 0; @endphp
                                    @foreach($appointments as $appo)
                                        @if($count % 3 == 0)
                                            <tr>
                                        @endif
                                        <td style="width: 25%;">
                                            <div  class="dashboard-items search-items"  >
                                                <div style="width:100%;">
                                                    <div class="h3-search">
                                                        Booking Date: {{ substr($appo->appodate,0,30) }}<br>
                                                        Reference Number: OC-000-{{ $appo->appoid }}
                                                    </div>
                                                    <div class="h1-search">
                                                        {{ substr($appo->title,0,21) }}<br>
                                                    </div>
                                                    <div class="h3-search">
                                                        Appointment Number:<div class="h1-search">0{{ $appo->apponum }}</div>
                                                    </div>
                                                    <div class="h3-search">
                                                        {{ substr($appo->facname,0,30) }}
                                                    </div>

                                                    <div class="h4-search">
                                                        Scheduled Date: {{ $appo->scheduledate }}<br>Starts: <b>@ {{ substr($appo->scheduletime,0,5) }}</b> (24h)
                                                    </div>
                                                    <br>
                                                    <a href="?action=drop&id={{ $appo->appoid }}&title={{ $appo->title }}&doc={{ $appo->facname }}" ><button  class="login-btn btn-primary-soft btn "  style="padding-top:11px;padding-bottom:11px;width:100%"><font class="tn-in-text">Cancel Booking</font></button></a>
                                                    @if($appo->status == 'done')
                                                    <a href="?action=review&id={{ $appo->appoid }}" ><button  class="login-btn btn-primary btn "  style="padding-top:11px;padding-bottom:11px;width:100%;margin-top:5px"><font class="tn-in-text">Review Faculty</font></button></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        @php $count++; @endphp
                                        @if($count % 3 == 0)
                                            </tr>
                                        @endif
                                    @endforeach
                                    @if($count % 3 != 0)
                                        </tr>
                                    @endif
                                @endif
                                </tbody>

                            </table>
                        </div>
                    </center>
                </td>
            </tr>

        </table>
    </div>
</div>

</body>
</html>
