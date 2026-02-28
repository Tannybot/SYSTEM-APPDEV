<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">  
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">  
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
        
    <title>Settings</title>
    <style>
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-X  0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .history-popup .popup { max-width:1100px !important; width:92% !important; padding:40px 48px 36px !important; border-radius:16px !important; box-shadow:0 20px 60px rgba(0,0,0,0.25) !important; } .history-title { font-size:28px; font-weight:700; color:#1a1a1a; margin:0 0 28px 0; display:flex; align-items:center; gap:12px; } .history-filters { background:#f8faf8; border:1px solid #e0e8e0; border-radius:12px; padding:24px 28px; margin-bottom:24px; } .history-filters form { display:flex; flex-wrap:wrap; align-items:flex-end; gap:20px; } .filter-group { display:flex; flex-direction:column; gap:6px; } .filter-group label { font-size:12px; font-weight:600; color:#555; text-transform:uppercase; letter-spacing:0.5px; } .filter-group input[type="date"], .filter-group select { padding:10px 14px; border:1px solid #ccc; border-radius:8px; font-size:14px; background:white; min-width:160px; } .filter-group input[type="date"]:focus, .filter-group select:focus { border-color:#228B22; box-shadow:0 0 0 3px rgba(34,139,34,0.12); outline:none; } .filter-actions { display:flex; gap:10px; align-items:flex-end; } .btn-filter-history { padding:10px 24px; background:#228B22; color:white; border:none; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; } .btn-filter-history:hover { background:#1a6e1a; } .btn-download { padding:10px 20px; background:white; color:#228B22; border:2px solid #228B22; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; } .btn-download:hover { background:#228B22; color:white; } .history-table { border-collapse:separate; border-spacing:0; width:100%; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.06); } .history-table thead th { background:linear-gradient(135deg,#228B22,#2da52d); color:white; padding:16px 20px; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.6px; border:none; cursor:pointer; white-space:nowrap; } .history-table thead th:hover { background:linear-gradient(135deg,#1a6e1a,#228B22); } .history-table thead th span { opacity:0.7; margin-left:4px; font-size:11px; } .history-table tbody td { padding:16px 20px; font-size:14px; color:#333; border-bottom:1px solid #f0f0f0; vertical-align:middle; } .history-table tbody tr { transition:background 0.15s; } .history-table tbody tr:nth-child(even) { background-color:#fafcfa; } .history-table tbody tr:hover { background-color:#eef5ee; } .history-table tbody tr:last-child td { border-bottom:none; } .status-badge { display:inline-block; padding:5px 14px; border-radius:20px; font-size:12px; font-weight:600; text-transform:capitalize; } .status-badge.done { background:#e8f5e9; color:#2e7d32; } .status-badge.canceled { background:#fce4ec; color:#c62828; } .status-badge.pending { background:#fff3e0; color:#ef6c00; } .history-empty { text-align:center; padding:60px 20px; color:#999; } .history-empty p { font-size:16px; margin:0; }

        /* Availability Section */
        .avail-popup .popup {
            max-width: 900px !important;
            width: 88% !important;
            padding: 36px 44px 32px !important;
            border-radius: 16px !important;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25) !important;
        }
        .avail-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 8px 0;
        }
        .avail-subtitle {
            font-size: 14px;
            color: #777;
            margin: 0 0 24px 0;
        }
        .avail-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 28px;
        }
        .day-card {
            background: #f8faf8;
            border: 1px solid #e0e8e0;
            border-radius: 10px;
            padding: 16px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .day-card:hover {
            border-color: #228B22;
            box-shadow: 0 2px 8px rgba(34,139,34,0.1);
        }
        .day-card .day-name {
            font-size: 13px;
            font-weight: 700;
            color: #228B22;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e0e8e0;
        }
        .day-card .time-row {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .day-card .time-field label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 4px;
        }
        .day-card .time-field input[type="time"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #d0d0d0;
            border-radius: 6px;
            font-size: 13px;
            background: white;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        .day-card .time-field input[type="time"]:focus {
            border-color: #228B22;
            outline: none;
            box-shadow: 0 0 0 2px rgba(34,139,34,0.1);
        }
        .avail-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 8px;
            border-top: 1px solid #eee;
        }
        .btn-avail-reset {
            padding: 10px 28px;
            background: white;
            color: #555;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-avail-reset:hover {
            background: #f5f5f5;
            border-color: #999;
        }
        .btn-avail-save {
            padding: 10px 28px;
            background: #228B22;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-avail-save:hover {
            background: #1a6e1a;
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
                                    <p class="profile-title">{{ substr($faculty->facname,0,13) }}..</p>
                                    <p class="profile-subtitle">{{ substr($faculty->facemail,0,22) }}</p>
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
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="{{ url('/faculty/dashboard') }}" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="{{ url('/faculty/appointment') }}" class="non-style-link-menu"><div><p class="menu-text">My Appointments</p></div></a>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="{{ url('/faculty/schedule') }}" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-student">
                        <a href="{{ url('/faculty/student') }}" class="non-style-link-menu"><div><p class="menu-text">My Students</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings  menu-active menu-icon-settings-active">
                        <a href="{{ url('/faculty/settings') }}" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Settings</p></div></a>
                    </td>
                </tr>
                
            </table>
        </div>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
                        
                        <tr >
                            
                        <td width="13%" >
                    <a href="{{ url('/faculty/dashboard') }}" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Settings</p>
                                           
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
                    <td colspan="4">
                        
                        <center>
                        <table class="filter-container" style="border: none;" border="0">
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 20px">&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%;">
                                    <a href="?action=edit&id={{ $faculty->facid }}&error=0" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex">
                                        <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('{{ asset('img/icons/faculty-hover.svg') }}');"></div>
                                        <div>
                                                <div class="h1-dashboard">
                                                    Account Settings  &nbsp;

                                                </div><br>
                                                <div class="h3-dashboard" style="font-size: 15px;">
                                                    Edit your Account Details & Change Password
                                                </div>
                                        </div>
                                                
                                    </div>
                                    </a>
                                </td>
                                
                                
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 5px">&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                            <td style="width: 25%;">
                                    <a href="?action=view&id={{ $faculty->facid }}" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div class="btn-icon-back dashboard-icons-setting " style="background-image: url('{{ asset('img/icons/view-iceblue.svg') }}');"></div>
                                        <div>
                                                <div class="h1-dashboard" >
                                                    View Account Details
                                                    
                                                </div><br>
                                                <div class="h3-dashboard"  style="font-size: 15px;">
                                                    View Personal information About Your Account
                                                </div>
                                        </div>
                                                
                                    </div>
                                    </a>
                                </td>
                                
                            </tr>
                            <tr>
                            <td style="width: 25%;">
                                    <a href="?action=availability&id={{ $faculty->facid }}" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('{{ asset('img/icons/schedule-hover.svg') }}');"></div>
                                        <div>
                                                <div class="h1-dashboard">
                                                    Availability Settings

                                                </div><br>
                                                <div class="h3-dashboard"  style="font-size: 15px;">
                                                    Set your available days and time slots
                                                </div>
                                        </div>

                                    </div>
                                    </a>
                                </td>

                            </tr>
                            <tr>
                            <td style="width: 25%;">
                                    <a href="?action=history&id={{ $faculty->facid }}" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex">
                                        <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('{{ asset('img/icons/view-iceblue.svg') }}');"></div>
                                        <div>
                                                <div class="h1-dashboard">
                                                    Booking History  &nbsp;

                                                </div><br>
                                                <div class="h3-dashboard" style="font-size: 15px;">
                                                    View completed appointments
                                                </div>
                                        </div>
                                            

                                    </div>
                                    </a>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 5px">&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                            <td style="width: 25%;">
                                    <a href="?action=drop&id={{ $faculty->facid }}&name={{ urlencode($faculty->facname) }}" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('{{ asset('img/icons/students-hover.svg') }}');"></div>
                                        <div>
                                                <div class="h1-dashboard" style="color: #ff5050;">
                                                    Delete Account

                                                </div><br>
                                                <div class="h3-dashboard"  style="font-size: 15px;">
                                                    Will Permanently Remove your Account
                                                </div>
                                        </div>

                                    </div>
                                    </a>
                                </td>

                            </tr>
                        </table>
                    </center>
                    </td>
                </tr>
            
            </table>
        </div>
    </div>
    
    @if($action=='drop')
        <div id="popup1" class="overlay">
                <div class="popup">
                <center>
                    <h2>Are you sure?</h2>
                    <a class="close" href="{{ url('/faculty/settings') }}">&times;</a>
                    <div class="content">
                        You want to delete this record<br>({{ substr(urldecode($nameget),0,40) }}).
                        
                    </div>
                    <div style="display: flex;justify-content: center;">
                    <form action="{{ route('faculty.settings.delete') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button type="submit" class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;Yes&nbsp;</font></button>
                    </form>&nbsp;&nbsp;&nbsp;
                    <a href="{{ url('/faculty/settings') }}" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                    </div>
                </center>
        </div>
        </div>
    @elseif($action=='view')
        <div id="popup1" class="overlay">
                <div class="popup">
                <center>
                    <h2></h2>
                    <a class="close" href="{{ url('/faculty/settings') }}">&times;</a>
                    <div class="content">
                        ConsultEase<br>
                        
                    </div>
                    <div style="display: flex;justify-content: center;">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                    
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details</p><br><br>
                            </td>
                        </tr>
                        
                        <tr>
                            
                            <td class="label-td" colspan="2">
                                <label for="name" class="form-label">Name: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                {{ $faculty->facname }}<br><br>
                            </td>
                            
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Email" class="form-label">Email: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                            {{ $faculty->facemail }}<br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Tele" class="form-label">Telephone: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                            {{ $faculty->factel }}<br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="spec" class="form-label">Subject: </label>
                                
                            </td>
                        </tr>
                        <tr>
                        <td class="label-td" colspan="2">
                        {{ $faculty->subject }}<br><br>
                        </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="{{ url('/faculty/settings') }}"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                            
                                
                            </td>
            
                        </tr>
                        

                    </table>
                    </div>
                </center>
                <br><br>
        </div>
        </div>
    @elseif($action=='availability')
        @php
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        @endphp
        <div id="popup1" class="overlay avail-popup">
                <div class="popup">
                    <a class="close" href="{{ url('/faculty/settings') }}">&times;</a>
                    <p class="avail-title">Set Your Availability</p>
                    <p class="avail-subtitle">Configure your available time slots for each day of the week</p>
                    <form action="{{ route('faculty.settings.edit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="update_availability">
                        <input type="hidden" value="{{ $faculty->facid }}" name="facid">
                        <div class="avail-grid">
                            @for($d=1; $d<=7; $d++)
                                @php
                                    $day_name = $days[$d-1];
                                    $slots = isset($availabilities[$d]) ? $availabilities[$d] : [];
                                    $startVal = isset($slots[0]) ? $slots[0]['start_time'] : '';
                                    $endVal = isset($slots[0]) ? $slots[0]['end_time'] : '';
                                @endphp
                                <div class="day-card">
                                    <div class="day-name">{{ $day_name }}</div>
                                    <div class="time-row">
                                        <div class="time-field">
                                            <label>Start</label>
                                            <input type="time" name="start_time[{{ $d }}][]" value="{{ $startVal }}">
                                        </div>
                                        <div class="time-field">
                                            <label>End</label>
                                            <input type="time" name="end_time[{{ $d }}][]" value="{{ $endVal }}">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <div class="avail-actions">
                            <input type="reset" value="Reset" class="btn-avail-reset">
                            <input type="submit" value="Save Availability" class="btn-avail-save">
                        </div>
                    </form>
            </div>
        </div>
    @elseif($action=='history')
        <div id="popup1" class="overlay history-popup">
                <div class="popup">
                    <a class="close" href="{{ url('/faculty/settings') }}">&times;</a>
                    <p class="history-title">Booking History</p>
                    <div class="history-filters">
                        <form method="POST" action="{{ url('/faculty/settings') }}">
                            @csrf
                            <input type="hidden" name="action" value="history">
                            <input type="hidden" name="id" value="{{ $faculty->facid }}">
                            <div class="filter-group">
                                <label>From Date</label>
                                <input type="date" name="from_date" value="{{ $request->input('from_date', '') }}">
                            </div>
                            <div class="filter-group">
                                <label>To Date</label>
                                <input type="date" name="to_date" value="{{ $request->input('to_date', '') }}">
                            </div>
                            <div class="filter-group">
                                <label>Booking Type</label>
                                <select name="subject">
                                    <option value="">All Types</option>
                                    @foreach($subjects as $sub)
                                        <option value="{{ $sub->id }}" {{ $request->input('subject') == $sub->id ? 'selected' : '' }}>{{ $sub->sname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="filter-actions">
                                <button type="submit" class="btn-filter-history">Apply Filter</button>
                                <button type="button" class="btn-download" onclick="downloadCSV()">Export CSV</button>
                            </div>
                        </form>
                    </div>
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">Booking ID <span id="sort-icon-0">&#8597;</span></th>
                                <th onclick="sortTable(1)">Date <span id="sort-icon-1">&#8597;</span></th>
                                <th onclick="sortTable(2)">Time <span id="sort-icon-2">&#8597;</span></th>
                                <th onclick="sortTable(3)">Session <span id="sort-icon-3">&#8597;</span></th>
                                <th onclick="sortTable(4)">Subject <span id="sort-icon-4">&#8597;</span></th>
                                <th onclick="sortTable(5)">Status <span id="sort-icon-5">&#8597;</span></th>
                            </tr>
                        </thead>
                        <tbody id="booking-table">
                            @if(count($bookings) === 0)
                                <tr><td colspan="6"><div class="history-empty"><p>No booking records found</p></div></td></tr>
                            @else
                                @foreach($bookings as $booking)
                                    @php $sc = strtolower($booking->status); @endphp
                                    <tr>
                                        <td><strong>#{{ $booking->appoid }}</strong></td>
                                        <td>{{ $booking->appodate }}</td>
                                        <td>{{ $booking->scheduletime }}</td>
                                        <td>{{ $booking->title }}</td>
                                        <td>{{ $booking->subject_name }}</td>
                                        <td><span class="status-badge {{ $sc }}">{{ $booking->status }}</span></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
            </div>
        </div>
    @elseif($action=='edit')
        @php
            $errorlist = [
                '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
                '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Confirmation Error! Reconfirm Password</label>',
                '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
                '4' => '',
                '0' => '',
            ];
        @endphp
        @if($error_1 != '4')
        <div id="popup1" class="overlay">
                <div class="popup">
                <center>
                
                    <a class="close" href="{{ url('/faculty/settings') }}">&times;</a> 
                    <div style="display: flex;justify-content: center;">
                    <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                    <tr>
                            <td class="label-td" colspan="2">
                                {!! $errorlist[$error_1] !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Edit Faculty Details.</p>
                            Faculty ID : {{ $faculty->facid }} (Auto Generated)<br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <form action="{{ route('faculty.settings.edit') }}" method="POST" class="add-new-form">
                                @csrf
                                <label for="Email" class="form-label">Email: </label>
                                <input type="hidden" value="{{ $faculty->facid }}" name="id00">
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                            <input type="hidden" name="oldemail" value="{{ $faculty->facemail }}" >
                            <input type="email" name="email" class="input-text" placeholder="Email Address" value="{{ $faculty->facemail }}" required><br>
                            </td>
                        </tr>
                        <tr>
                            
                            <td class="label-td" colspan="2">
                                <label for="name" class="form-label">Name: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="name" class="input-text" placeholder="Faculty Name" value="{{ $faculty->facname }}" required><br>
                            </td>
                            
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Tele" class="form-label">Telephone: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" value="{{ $faculty->factel }}" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="spec" class="form-label">Subject: (Current: {{ $faculty->subject }})</label>
                                
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="spec" class="input-text" placeholder="Enter Subject" value="{{ $faculty->subject }}" required><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="password" class="form-label">Password: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="password" name="password" class="input-text" placeholder="Define a Password" required><br>
                            </td>
                        </tr><tr>
                            <td class="label-td" colspan="2">
                                <label for="cpassword" class="form-label">Confirm Password: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required><br>
                            </td>
                        </tr>
                        
            
                        <tr>
                            <td colspan="2">
                                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                                <input type="submit" value="Save" class="login-btn btn-primary btn">
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
        @else
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    <br><br><br><br>
                        <h2>Edit Successfully!</h2>
                        <a class="close" href="{{ url('/faculty/settings') }}">&times;</a>
                        <div class="content">
                            If You change your email also Please logout and login again with your new email
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        
                        <a href="{{ url('/faculty/settings') }}" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Log out&nbsp;&nbsp;</font></button>
                        </form>

                        </div>
                        <br><br>
                    </center>
            </div>
            </div>
        @endif
    @endif

<script>

function sortTable(n) {

  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;

  table = document.getElementById("booking-table");

  switching = true;

  dir = "asc";

  while (switching) {

    switching = false;

    rows = table.rows;

    for (i = 0; i < (rows.length - 1); i++) {

      shouldSwitch = false;

      x = rows[i].getElementsByTagName("TD")[n];

      y = rows[i + 1].getElementsByTagName("TD")[n];

      if (dir == "asc") {

        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {

          shouldSwitch = true;

          break;

        }

      } else if (dir == "desc") {

        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {

          shouldSwitch = true;

          break;

        }

      }

    }

    if (shouldSwitch) {

      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);

      switching = true;

      switchcount ++;

    } else {

      if (switchcount == 0 && dir == "asc") {

        dir = "desc";

        switching = true;

      }

    }

  }

}

function downloadCSV() {
    var table = document.querySelector(".history-table");
    var rows = table.querySelectorAll("tr");
    var csv = [];
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        for (var j = 0; j < cols.length; j++) 
            row.push('"' + cols[j].innerText + '"');
        csv.push(row.join(","));
    }
    var csvString = csv.join("\n");
    var a = document.createElement("a");
    a.href = "data:text/csv;charset=utf-8," + encodeURIComponent(csvString);
    a.target = "_blank";
    a.download = "booking_history.csv";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

</script>
</body>
</html>
