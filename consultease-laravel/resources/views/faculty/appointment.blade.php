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
        .popup{ animation: transitionIn-Y-bottom 0.5s; }
        .sub-table{ animation: transitionIn-Y-bottom 0.5s; }

        /* --- Appointment Manager Layout --- */
        .appt-layout {
            display: flex;
            gap: 24px;
            padding: 0 30px;
            margin-top: 10px;
            max-width: 100%;
        }
        .appt-calendar-panel {
            flex: 0 0 60%;
            min-width: 0;
        }
        .appt-details-panel {
            flex: 1;
            min-width: 280px;
        }

        /* --- Calendar --- */
        .calendar {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            border-radius: 12px;
            overflow: hidden;
        }
        .calendar caption {
            background: linear-gradient(135deg, #228B22, #2da52d);
            color: white;
            padding: 16px 20px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .calendar th {
            background: #f5f7f5;
            color: #555;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 8px;
            border-bottom: 1px solid #e5e5e5;
        }
        .calendar td {
            border: 1px solid #f0f0f0;
            padding: 14px 8px;
            text-align: center;
            font-size: 13px;
            vertical-align: top;
            height: 70px;
            transition: background 0.15s;
            cursor: default;
        }
        .calendar .day { cursor: pointer; position: relative; }
        .calendar .day:hover { background: #f1f3f4; }
        .calendar .day.active-day {
            background: #e8f5e9 !important;
            box-shadow: inset 0 0 0 2px #228B22;
            border-radius: 4px;
        }
        .calendar .has-session {
            background: #fff8e1;
            font-weight: 600;
        }
        .calendar .has-session:hover { background: #fff3cd; }
        .calendar .has-appointment {
            background: #e3f2fd;
            font-weight: 600;
        }
        .calendar .has-appointment:hover { background: #bbdefb; }
        .calendar .has-session.has-appointment {
            background: linear-gradient(135deg, #fff8e1 50%, #e3f2fd 50%);
        }
        .calendar .day small {
            display: block;
            font-size: 9px;
            margin-top: 3px;
            font-weight: 500;
        }
        .calendar .has-session small { color: #e65100; }
        .calendar .has-appointment small { color: #1565c0; }

        /* --- Details Panel --- */
        .details-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            position: sticky;
            top: 20px;
        }
        .details-header {
            background: linear-gradient(135deg, #228B22, #2da52d);
            color: white;
            padding: 16px 20px;
            font-size: 15px;
            font-weight: 700;
        }
        .details-header .date-label {
            font-size: 12px;
            opacity: 0.85;
            font-weight: 400;
            margin-top: 4px;
        }
        .details-body {
            padding: 16px 20px;
            max-height: 520px;
            overflow-y: auto;
        }
        .details-empty {
            text-align: center;
            padding: 48px 16px;
            color: #aaa;
        }
        .details-empty .icon { font-size: 40px; margin-bottom: 10px; display: block; }
        .details-empty p { font-size: 14px; margin: 0; }
        .details-section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #888;
            margin: 16px 0 8px;
            padding-bottom: 6px;
            border-bottom: 1px solid #f0f0f0;
        }
        .details-section-title:first-child { margin-top: 0; }
        .session-item, .booking-item {
            padding: 12px;
            margin-bottom: 8px;
            border-radius: 8px;
            background: #fafafa;
            border-left: 3px solid #228B22;
        }
        .booking-item { border-left-color: #1976d2; }
        .session-item .sess-title {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }
        .session-item .sess-time {
            font-size: 12px;
            color: #777;
            margin-top: 2px;
        }
        .booking-item .book-student {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }
        .booking-item .book-meta {
            font-size: 12px;
            color: #777;
            margin-top: 2px;
        }
        .booking-item .book-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }
        .booking-item .book-actions button {
            padding: 5px 14px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .booking-item .book-actions button:hover { opacity: 0.85; }
        .booking-item .btn-done {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .booking-item .btn-cancel {
            background: #fce4ec;
            color: #c62828;
        }

        /* --- Legend --- */
        .cal-legend {
            display: flex;
            gap: 16px;
            margin-top: 12px;
            font-size: 11px;
            color: #777;
        }
        .cal-legend span {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .cal-legend .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        .cal-legend .dot-session { background: #fff3e0; border: 1px solid #e65100; }
        .cal-legend .dot-booked { background: #e3f2fd; border: 1px solid #1565c0; }

        /* --- Popups for delete/view --- */
        .appointment-popup { display: none; }
        .review-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            padding: 30px;
            z-index: 1001;
            max-width: 500px;
            width: 90%;
        }
        .review-modal h3 { margin-top: 0; color: #333; }
        .stars { display: flex; gap: 5px; margin: 10px 0; }
        .stars input { display: none; }
        .stars label { font-size: 30px; color: #ddd; cursor: pointer; }
        .stars input:checked ~ label,
        .stars label:hover,
        .stars label:hover ~ label { color: #ffc107; }
        .review-modal textarea { width: 100%; height: 80px; margin: 10px 0; }
        .review-modal .buttons { display: flex; justify-content: flex-end; gap: 10px; }
    </style>
</head>
<body>
    @php
        // Pure PHP helper function to render calendar
        function build_calendar($month, $year, $schedules, $appointments) {
            $daysOfWeek = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
            $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
            $numberDays = date('t',$firstDayOfMonth);
            $dateComponents = getdate($firstDayOfMonth);
            $monthName = $dateComponents['month'];
            $dayOfWeek = $dateComponents['wday'];

            $calendar = "<table class='calendar'>";
            $calendar .= "<caption>$monthName $year</caption>";
            $calendar .= "<tr>";
            foreach($daysOfWeek as $day) {
                $calendar .= "<th class='header'>$day</th>";
            }
            $calendar .= "</tr><tr>";

            if ($dayOfWeek > 0) {
                $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
            }

            $currentDay = 1;
            while ($currentDay <= $numberDays) {
                if ($dayOfWeek == 7) {
                    $dayOfWeek = 0;
                    $calendar .= "</tr><tr>";
                }

                $currentDate = "$year-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad($currentDay, 2, "0", STR_PAD_LEFT);
                $class = 'day';
                $content = $currentDay;
                $hasSession = isset($schedules[$currentDate]);
                $hasAppointment = isset($appointments[$currentDate]);
                if($hasSession){
                    $class .= ' has-session';
                    $content .= '<br><small>' . count($schedules[$currentDate]) . ' sess</small>';
                    if($hasAppointment){
                        $class .= ' has-appointment';
                        $content .= '<br><small>' . count($appointments[$currentDate]) . ' booked</small>';
                    }
                }
                $calendar .= "<td class='$class' data-date='$currentDate'>$content</td>";

                $currentDay++;
                $dayOfWeek++;
            }

            if ($dayOfWeek != 7) {
                $remainingDays = 7 - $dayOfWeek;
                $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
            }

            $calendar .= "</tr>";
            $calendar .= "</table>";
            return $calendar;
        }
    @endphp

    <div class="container">
        <div class="menu" id="menu">
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
                    <td class="menu-btn menu-icon-dashbord " >
                        <a href="{{ url('/faculty/dashboard') }}" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment  menu-active menu-icon-appoinment-active">
                        <a href="{{ url('/faculty/appointment') }}" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">My Appointments</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="{{ url('/faculty/schedule') }}" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="{{ url('/faculty/student') }}" class="non-style-link-menu"><div><p class="menu-text">My Students</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="{{ url('/faculty/settings') }}" class="non-style-link-menu"><div><p class="menu-text">Settings</p></div></a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body" id="dash-body">
            <table border="0" width="100%" style="border-spacing:0;margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="{{ url('/faculty/dashboard') }}"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size:23px;padding-left:12px;font-weight:600;">Appointment Manager</p>
                    </td>
                    <td width="15%">
                        <p style="font-size:14px;color:rgb(119,119,119);padding:0;margin:0;text-align:right;">Today's Date</p>
                        <p class="heading-sub12" style="padding:0;margin:0;">
                            {{ $today }}
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display:flex;justify-content:center;align-items:center;"><img src="{{ asset('img/calendar.svg') }}" width="100%"></button>
                    </td>
                </tr>
            </table>

            <div class="appt-layout">
                <div class="appt-calendar-panel">
                    {!! build_calendar(date('m'), date('Y'), $schedules, $appointments) !!}
                    <div class="cal-legend">
                        <span><span class="dot dot-session"></span> Has Sessions</span>
                        <span><span class="dot dot-booked"></span> Has Bookings</span>
                    </div>
                </div>
                <div class="appt-details-panel">
                    <div class="details-card">
                        <div class="details-header">
                            <div>Booking Details</div>
                            <div class="date-label" id="details-date-label">Click a date to view details</div>
                        </div>
                        <div class="details-body" id="details-body">
                            <div class="details-empty">
                                <span class="icon">&#128197;</span>
                                <p>Select a date on the calendar to view sessions and bookings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>

   <div id="review-modal" class="review-modal">
       <span class="close" onclick="closeReviewModal()">&times;</span>
       <h3>Review Student</h3>
       <form id="review-form" action="{{ url('/faculty/submit-review') }}" method="post">
           @csrf
           <input type="hidden" name="appoid" id="review-appoid">
           <label>Rating:</label>
           <div class="stars">
               <input type="radio" id="star5" name="rating" value="5"><label for="star5">&#9733;</label>
               <input type="radio" id="star4" name="rating" value="4"><label for="star4">&#9733;</label>
               <input type="radio" id="star3" name="rating" value="3"><label for="star3">&#9733;</label>
               <input type="radio" id="star2" name="rating" value="2"><label for="star2">&#9733;</label>
               <input type="radio" id="star1" name="rating" value="1"><label for="star1">&#9733;</label>
           </div>
           <label>Comments (optional):</label>
           <textarea name="comments" placeholder="Leave your comments here..."></textarea>
           <div class="buttons">
               <button type="button" class="btn btn-primary-soft" onclick="closeReviewModal()">Cancel</button>
               <button type="submit" class="btn btn-primary">Submit Review</button>
           </div>
       </form>
   </div>
   @if($action=='drop')
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <h2>Are you sure?</h2>
                    <a class="close" href="{{ url('/faculty/appointment') }}">&times;</a>
                    <div class="content">
                        You want to delete this record<br><br>
                        Student Name: &nbsp;<b>{{ substr($nameget,0,40) }}</b><br>
                        Appointment number &nbsp; : <b>{{ substr($apponum,0,40) }}</b><br><br>
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <form action="{{ url('/faculty/appointment/delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="appoid" value="{{ $id }}">
                            <button type="submit" class="btn-primary btn" style="display:flex;justify-content:center;align-items:center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;Yes&nbsp;</font></button>
                        </form>&nbsp;&nbsp;&nbsp;
                        <a href="{{ url('/faculty/appointment') }}" class="non-style-link"><button class="btn-primary btn" style="display:flex;justify-content:center;align-items:center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>
   @endif

    <script>
        var schedules = @json($schedules);
        var appointments = @json($appointments);
        var activeDay = null;

        document.addEventListener('DOMContentLoaded', function() {
            var days = document.querySelectorAll('.day');
            days.forEach(function(day) {
                day.addEventListener('click', function() {
                    var date = this.getAttribute('data-date');
                    if (activeDay) activeDay.classList.remove('active-day');
                    this.classList.add('active-day');
                    activeDay = this;
                    showDetails(date);
                });
            });

            // Check for review action
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('action') === 'review') {
                const appoid = urlParams.get('id');
                document.getElementById('review-appoid').value = appoid;
                document.getElementById('review-modal').style.display = 'block';
            }
            if (urlParams.get('review') === 'success') {
                alert('Review submitted successfully!');
            } else if (urlParams.get('review') === 'error') {
                const msg = urlParams.get('msg') || 'Error submitting review.';
                alert(msg);
            }
        });

        function showDetails(date) {
            var dateLabel = document.getElementById('details-date-label');
            var body = document.getElementById('details-body');

            // Format date display
            var d = new Date(date + 'T00:00:00');
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            dateLabel.textContent = d.toLocaleDateString('en-US', options);

            var html = '';
            var hasSessions = schedules[date] && schedules[date].length > 0;
            var hasAppts = appointments[date] && appointments[date].length > 0;

            if (!hasSessions && !hasAppts) {
                html = '<div class="details-empty"><span class="icon">&#128196;</span><p>No sessions or bookings on this date</p></div>';
                body.innerHTML = html;
                return;
            }

            if (hasSessions) {
                html += '<div class="details-section-title">Sessions (' + schedules[date].length + ')</div>';
                schedules[date].forEach(function(sess) {
                    html += '<div class="session-item">';
                    html += '<div class="sess-title">' + sess.title + '</div>';
                    html += '<div class="sess-time">&#128337; ' + sess.scheduletime + '</div>';
                    html += '</div>';
                });
            }

            if (hasAppts) {
                html += '<div class="details-section-title">Bookings (' + appointments[date].length + ')</div>';
                appointments[date].forEach(function(appt) {
                    html += '<div class="booking-item">';
                    html += '<div class="book-student">' + appt.sname + '</div>';
                    html += '<div class="book-meta">' + appt.title + ' &#183; ' + appt.scheduletime + ' &#183; #' + appt.apponum + '</div>';
                    html += '<div class="book-actions">';
                    html += '<button type="button" class="btn-done" onclick="markDone(' + appt.appoid + ')">&#10003; Done</button>';
                    html += '<button type="button" class="btn-cancel" onclick="cancelAppointment(' + appt.appoid + ', \'' + appt.sname.replace(/'/g, "\\'") + '\')">&#10005; Cancel</button>';
                    html += '</div>';
                    html += '</div>';
                });
            }

            body.innerHTML = html;
        }

        function markDone(appoid) {
            window.location.href = '{{ url('/faculty/appointment/done') }}?id=' + appoid;
        }

        function cancelAppointment(appoid, sname) {
            if (confirm('Are you sure you want to cancel this appointment for ' + sname + '?')) {
                window.location.href = '{{ url('/faculty/appointment') }}?action=drop&id=' + appoid + '&name=' + sname;
            }
        }

        function closeReviewModal() {
            document.getElementById('review-modal').style.display = 'none';
            // Optionally clear URL parameters if wanted
        }
    </script>
</body>
</html>
