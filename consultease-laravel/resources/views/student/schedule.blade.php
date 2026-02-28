<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <title>Sessions</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="menu">
        <table class="menu-container" border="0">
            <tr>
                <td style="padding:10px" colspan="2">
                    <table border="0" class="profile-container">
                        <tr>
                            <td width="30%" style="padding-left:20px" >
                                <img src="{{ asset('img/user.png') }}" alt="" style="width: 91.85px; height: 91.85px; border-radius:50%">
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
                <td class="menu-btn menu-icon-home " >
                    <a href="{{ url('/student/dashboard') }}" class="non-style-link-menu "><div><p class="menu-text">Home</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-faculty">
                    <a href="{{ url('/student/faculty') }}" class="non-style-link-menu"><div><p class="menu-text">All Faculty</p></div></a>
                </td>
            </tr>

            <tr class="menu-row" >
                <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                    <a href="{{ url('/student/schedule') }}" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-appoinment">
                    <a href="{{ url('/student/appointment') }}" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></div></a>
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

    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr >
                <td width="13%" >
                    <a href="{{ url('/student/dashboard') }}" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                </td>
                <td >
                    <form action="{{ url('/student/schedule') }}" method="post" class="header-search">
                        @csrf
                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Faculty name or title or Date" list="faculty" value="{{ $searchQuery }}">&nbsp;&nbsp;
                        <datalist id="faculty">
                            @foreach($allFaculties as $fac)
                                <option value="{{ $fac->facname }}"></option>
                            @endforeach
                            @foreach($allTitles as $t)
                                <option value="{{ $t->title }}"></option>
                            @endforeach
                        </datalist>

                        <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                    </form>
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
                <td colspan="4" >
                    <div style="display: flex;margin-top: 40px;">
                    <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Schedule a New Session</div>
                    <a href="?action=add-session&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="margin-left:25px;background-image: url('{{ asset('img/icons/add.svg') }}');">Schedule Session</font></button></a>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="padding-top:10px;width: 100%;" >
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">{{ $searchType }} Sessions ({{ $schedules->count() }}) </p>
                    @if($searchQuery != '')
                        <p class="heading-main12" style="margin-left: 45px;font-size:22px;color:rgb(49, 49, 49)">"{{ $searchQuery }}" </p>
                    @endif
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <center>
                    <div class="abc scroll">
                    <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;border:none">
                        <tbody>
                        @if($schedules->count() == 0)
                            <tr>
                                <td colspan="4">
                                <br><br><br><br>
                                <center>
                                <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                <br>
                                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We couldnt find anything related to your keywords!</p>
                                <a class="non-style-link" href="{{ url('/student/schedule') }}"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Sessions &nbsp;</font></button></a>
                                </center>
                                <br><br><br><br>
                                </td>
                            </tr>
                        @else
                            @php $count = 0; @endphp
                            @foreach($schedules as $sched)
                                @if($count % 3 == 0)
                                    <tr>
                                @endif
                                <td style="width: 25%;">
                                    <div class="dashboard-items search-items">
                                        <div style="width:100%">
                                            <div class="h1-search">{{ substr($sched->title,0,21) }}</div><br>
                                            <div class="h3-search">{{ substr($sched->facname,0,30) }}</div>
                                            <div class="h4-search">{{ $sched->scheduledate }}<br>Starts: <b>@ {{ substr($sched->scheduletime,0,5) }}</b> (24h)</div>
                                            <br>
                                            <a href="{{ url('/student/appointment?action=add&id='.$sched->scheduleid) }}" ><button  class="login-btn btn-primary-soft btn "  style="padding-top:11px;padding-bottom:11px;width:100%"><font class="tn-in-text">Book Now</font></button></a>
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

@if($action == 'add-session')
    <div id="popup1" class="overlay">
        <div class="popup">
            <center>
                <a class="close" href="{{ url('/student/schedule') }}">&times;</a>
                <div style="display: flex;justify-content: center;">
                <div class="abc">
                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                    <tr>
                        <td class="label-td" colspan="2">
                            @if($error == 'availability')
                                <label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">The faculty is not available at the requested time. No available slots on this day.</label>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Book an Appointment</p><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                        <form action="{{ url('/student/schedule/add') }}" method="POST" class="add-new-form">
                            @csrf
                            <label for="title" class="form-label">Concern : </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="text" name="title" class="input-text" placeholder="Name of this Session" required><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="purpose" class="form-label">Purpose : </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="text" name="purpose" class="input-text" placeholder="Purpose of this Session" required><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="docid" class="form-label">Select Faculty: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <select name="docid" id="" class="box" required >
                                <option value="" disabled selected hidden>Choose Faculty Name from the list</option><br/>
                                @foreach($allFaculties as $fac)
                                    <option value="{{ $fac->facid }}">{{ $fac->facname }}</option>
                                @endforeach
                            </select><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="nop" class="form-label">Number of Concerned Students : </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="number" name="nop" class="input-text" min="1"  placeholder="The final appointment number for this session depends on this number" required><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="date" class="form-label">Session Date: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="date" name="date" class="input-text" min="{{ date('Y-m-d') }}" required><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="time" class="form-label">Schedule Time: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="time" name="time" class="input-text" placeholder="Time" required><br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="submit" value="Schedule this Session" class="login-btn btn-primary btn" name="shedulesubmit">
                        </td>
                    </tr>
                </form>
                </tr>
            </table>
            </div>
            </div>
        </center>
        <br><br>
    </div>
</div>
@elseif($action == 'session-added')
<div id="popup1" class="overlay">
    <div class="popup">
        <center>
        <br><br>
            <h2>Session Scheduled.</h2>
            <a class="close" href="{{ url('/student/schedule') }}">&times;</a>
            <div class="content">
            {{ substr($titleParam,0,40) }} was scheduled.<br><br>

            </div>
            <div style="display: flex;justify-content: center;">
            <a href="{{ url('/student/schedule') }}" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
            <br><br><br><br>
            </div>
        </center>
    </div>
</div>
@endif

</div>
</body>
</html>
