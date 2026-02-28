<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <title>Faculty</title>
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
                    <td class="menu-btn menu-icon-faculty menu-active menu-icon-faculty-active">
                        <a href="{{ url('/student/faculty') }}" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">My Faculty</p></div></a>
                    </td>
                </tr>

                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="{{ url('/student/schedule') }}" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
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
                    <td width="13%">
                        <a href="{{ url('/student/dashboard') }}" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>

                        <form action="{{ url('/student/faculty') }}" method="post" class="header-search">
                            @csrf
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Faculty name or Email" list="faculty">&nbsp;&nbsp;
                            <datalist id="faculty">
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->facname }}"></option>
                                    <option value="{{ $faculty->facemail }}"></option>
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
                            {{ date('Y-m-d') }}
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="{{ asset('img/calendar.svg') }}" width="100%"></button>
                    </td>
                </tr>

               <tr>
                   <td colspan="4" style="padding-top:10px;">
                       <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">My Faculty ({{ $faculties->count() }})</p>
                   </td>
               </tr>

                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" border="0">
                        <thead>
                        <tr>
                                <th class="table-headin">Faculty Name</th>
                                <th class="table-headin">Email</th>
                                <th class="table-headin">Subject</th>
                                <th class="table-headin">Events</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($faculties->count() == 0)
                                <tr>
                                <td colspan="4">
                                <br><br><br><br>
                                <center>
                                <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                <br>
                                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                <a class="non-style-link" href="{{ url('/student/faculty') }}"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Faculty &nbsp;</font></button>
                                </a>
                                </center>
                                <br><br><br><br>
                                </td>
                                </tr>
                            @else
                                @foreach($faculties as $faculty)
                                    <tr>
                                        <td> &nbsp;{{ substr($faculty->facname,0,30) }}</td>
                                        <td>{{ substr($faculty->facemail,0,20) }}</td>
                                        <td>
                                            @if(isset($subjects[$faculty->subject]))
                                                {{ substr($subjects[$faculty->subject]->sname,0,20) }}
                                            @else
                                                Unknown
                                            @endif
                                        </td>
                                        <td>
                                        <div style="display:flex;justify-content: center;">
                                            <a href="?action=view&id={{ $faculty->facid }}" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="?action=availability&id={{ $faculty->facid }}&name={{ $faculty->facname }}"  class="non-style-link"><button  class="btn-primary-soft btn button-icon"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Availability</font></button></a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="?action=book&id={{ $faculty->facid }}&name={{ $faculty->facname }}"  class="non-style-link"><button  class="btn-primary-soft btn button-icon menu-icon-session-active"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Book Now</font></button></a>
                                        </div>
                                        </td>
                                    </tr>
                                @endforeach
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

    @if($action == 'view')
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <h2></h2>
                    <a class="close" href="{{ url('/student/faculty') }}">&times;</a>
                    <div class="content">eDoc Web App<br></div>
                    <div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    {{ $selectedFaculty->facname }}<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Email: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    {{ $selectedFaculty->facemail }}<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Telephone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    {{ $selectedFaculty->factel }}<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Subject: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    {{ $spcil_name }}<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="{{ url('/student/faculty') }}"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </center>
                <br><br>
            </div>
        </div>
    @elseif($action == 'availability')
        @php
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $has_availability = false;
        @endphp
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <h2>Availability for {{ substr($name,0,40) }}</h2>
                    <a class="close" href="{{ url('/student/faculty') }}">&times;</a>
                    <div class="content">
                        <table class="sub-table" border="0" style="width:100%; text-align:left;">
                            <thead>
                                <tr>
                                    <th class="table-headin">Day</th>
                                    <th class="table-headin">Available Time for Consultation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($d=1; $d<=7; $d++)
                                    @php
                                        $day_name = $days[$d-1];
                                        $slots = isset($availabilities[$d]) ? $availabilities[$d] : [];
                                        $times = [];
                                        foreach($slots as $slot){
                                            $times[] = substr($slot->start_time, 0, 5) . ' - ' . substr($slot->end_time, 0, 5);
                                        }
                                        $time_str = implode(', ', $times);
                                    @endphp
                                    @if(count($times) > 0)
                                        @php $has_availability = true; @endphp
                                        <tr>
                                            <td>{{ $day_name }}</td>
                                            <td>{{ $time_str }}</td>
                                        </tr>
                                    @endif
                                @endfor

                                @if(!$has_availability)
                                    <tr><td colspan="2" style="text-align:center;">No availability set.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div style="display: flex;justify-content: center;margin-top:20px;">
                        <a href="{{ url('/student/faculty') }}" class="non-style-link"><button class="btn-primary btn">OK</button></a>
                    </div>
                </center>
            </div>
        </div>
    @elseif($action == 'book')
        {{-- For booking, we normally wouldn't show the logic entirely inside the blade view in Laravel. However, to maintain similarity with the original system, we handle the booking result view based on a future controller method mapped to POST session...
             Since the controller right now only passes $action = 'book', we will just redirect or show a prompt to initiate booking via a form --}}
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <h2>Redirect to Booking?</h2>
                    <a class="close" href="{{ url('/student/faculty') }}">&times;</a>
                    <div class="content">
                        You want to book a session with <br>({{ substr($name,0,40) }}).
                    </div>
                    <form action="{{ url('/student/schedule') }}" method="post" style="display: flex">
                        @csrf
                        <input type="hidden" name="search" value="{{ $name }}">
                        <div style="display: flex;justify-content:center;margin-left:0;margin-top:6%;margin-bottom:6%;">
                            <input type="submit" value="Yes" class="btn-primary btn">
                        </div>
                    </form>
                </center>
            </div>
        </div>
    @endif
</div>
</body>
</html>