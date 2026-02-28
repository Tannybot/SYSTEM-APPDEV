<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $useremail = Session::get('user');

        $admin = Admin::where('aemail', $useremail)->first();
        if (!$admin) {
            return redirect('/login');
        }

        $today = date('Y-m-d');
        $nextweek = date("Y-m-d", strtotime("+1 week"));

        // Get counts
        $facultyCount = DB::table('faculty')->count();
        $studentCount = DB::table('student')->count();
        $appointmentCount = DB::table('appointment')->where('appodate', '>=', $today)->count();
        $scheduleCount = DB::table('schedule')->where('scheduledate', $today)->count();

        // Get upcoming appointments
        $upcomingAppointments = DB::table('schedule')
            ->join('appointment', 'schedule.scheduleid', '=', 'appointment.scheduleid')
            ->join('student', 'student.sid', '=', 'appointment.pid')
            ->join('faculty', 'schedule.facid', '=', 'faculty.facid')
            ->select('appointment.appoid', 'schedule.scheduleid', 'schedule.title', 'faculty.facname', 'student.sname', 'schedule.scheduledate', 'schedule.scheduletime', 'appointment.apponum', 'appointment.appodate')
            ->where('schedule.scheduledate', '>=', $today)
            ->where('schedule.scheduledate', '<=', $nextweek)
            ->orderBy('schedule.scheduledate', 'desc')
            ->get();

        // Get upcoming sessions
        $upcomingSessions = DB::table('schedule')
            ->join('faculty', 'schedule.facid', '=', 'faculty.facid')
            ->select('schedule.scheduleid', 'schedule.title', 'faculty.facname', 'schedule.scheduledate', 'schedule.scheduletime', 'schedule.nop')
            ->where('schedule.scheduledate', '>=', $today)
            ->where('schedule.scheduledate', '<=', $nextweek)
            ->orderBy('schedule.scheduledate', 'desc')
            ->get();

        // Optional list for search datalist (admin layout)
        $facultyList = DB::table('faculty')->select('facname', 'facemail')->get();

        return view('admin.dashboard', compact(
            'admin', 'today', 'nextweek', 'facultyCount', 'studentCount', 'appointmentCount', 'scheduleCount', 'upcomingAppointments', 'upcomingSessions', 'facultyList'
        ));
    }

    public function faculty(Request $request)
    {
        $useremail = Session::get('user');
        $admin = Admin::where('aemail', $useremail)->first();
        if (!$admin) {
            return redirect('/login');
        }

        $today = date('Y-m-d');
        $action = $request->query('action', '');
        $id = $request->query('id', '');
        $error_1 = $request->query('error', '0');
        $nameget = $request->query('name', '');

        $facultyList = DB::table('faculty')->select('facname', 'facemail')->get();

        $query = DB::table('faculty');
        if ($request->isMethod('post') && $request->has('search')) {
            $keyword = $request->input('search');
            $query->where('facemail', $keyword)
                ->orWhere('facname', 'like', "%$keyword%");
            $faculties = $query->get();
        }
        else {
            $faculties = $query->orderBy('facid', 'desc')->get();
        }

        $facultyDetails = null;
        if (($action == 'view' || $action == 'edit') && $id) {
            $facultyDetails = DB::table('faculty')->where('facid', $id)->first();
        }

        return view('admin.faculty', compact(
            'admin', 'today', 'action', 'id', 'error_1', 'nameget', 'facultyList', 'faculties', 'facultyDetails'
        ));
    }

    public function addFaculty(Request $request)
    {
        $name = $request->input('name');
        $spec = $request->input('spec');
        $email = $request->input('email');
        $tele = $request->input('Tele');
        $password = $request->input('password');
        $cpassword = $request->input('cpassword');

        if ($password == $cpassword) {
            $existingUser = DB::table('webuser')->where('email', $email)->first();
            if ($existingUser == null) {
                DB::table('webuser')->insert([
                    'email' => $email,
                    'usertype' => 'f'
                ]);
                DB::table('faculty')->insert([
                    'facemail' => $email,
                    'facname' => $name,
                    'facpassword' => $password,
                    'factel' => $tele,
                    'subject' => $spec
                ]);
                return redirect('/admin/faculty?action=add&id=none&error=4');
            }
            else {
                return redirect('/admin/faculty?action=add&id=none&error=1');
            }
        }
        else {
            return redirect('/admin/faculty?action=add&id=none&error=2');
        }
    }

    public function editFaculty(Request $request)
    {
        $id = $request->input('id00');
        $name = $request->input('name');
        $oldemail = $request->input('oldemail');
        $email = $request->input('email');
        $tele = $request->input('Tele');
        $spec = $request->input('spec');
        $password = $request->input('password');
        $cpassword = $request->input('cpassword');

        if ($password == $cpassword) {
            $existingUser = DB::table('webuser')->where('email', $email)->first();
            if ($existingUser == null || $email == $oldemail) {
                DB::table('webuser')->where('email', $oldemail)->update(['email' => $email]);
                DB::table('faculty')
                    ->where('facid', $id)
                    ->update([
                    'facemail' => $email,
                    'facname' => $name,
                    'facpassword' => $password,
                    'factel' => $tele,
                    'subject' => $spec
                ]);
                return redirect("/admin/faculty?action=edit&id=$id&error=4");
            }
            else {
                return redirect("/admin/faculty?action=edit&id=$id&error=1");
            }
        }
        else {
            return redirect("/admin/faculty?action=edit&id=$id&error=2");
        }
    }

    public function deleteFaculty(Request $request)
    {
        $id = $request->input('id');
        $faculty = DB::table('faculty')->where('facid', $id)->first();

        if ($faculty) {
            $email = $faculty->facemail;
            DB::table('faculty')->where('facid', $id)->delete();
            DB::table('webuser')->where('email', $email)->delete();
        }

        return redirect('/admin/faculty');
    }

    public function schedule(Request $request)
    {
        $useremail = Session::get('user');
        $admin = Admin::where('aemail', $useremail)->first();
        if (!$admin) {
            return redirect('/login');
        }

        $today = date('Y-m-d');
        $action = $request->query('action', '');
        $id = $request->query('id', '');
        $nameget = $request->query('name', '');

        $facultyList = DB::table('faculty')->orderBy('facname', 'asc')->get();

        $query = DB::table('schedule')
            ->join('faculty', 'schedule.facid', '=', 'faculty.facid')
            ->select('schedule.scheduleid', 'schedule.title', 'faculty.facname', 'schedule.scheduledate', 'schedule.scheduletime', 'schedule.nop');

        if ($request->isMethod('post')) {
            if ($request->filled('sheduledate')) {
                $query->where('schedule.scheduledate', $request->input('sheduledate'));
            }
            if ($request->filled('docid')) {
                $query->where('faculty.facid', $request->input('docid'));
            }
            $schedules = $query->get();
        }
        else {
            $schedules = $query->orderBy('schedule.scheduledate', 'desc')->get();
        }

        $sessionDetails = null;
        $appointments = [];
        if ($action == 'view' && $id) {
            $sessionDetails = DB::table('schedule')
                ->join('faculty', 'schedule.facid', '=', 'faculty.facid')
                ->where('schedule.scheduleid', $id)
                ->select('schedule.scheduleid', 'schedule.title', 'faculty.facname', 'schedule.scheduledate', 'schedule.scheduletime', 'schedule.nop')
                ->first();

            if ($sessionDetails) {
                $appointments = DB::table('appointment')
                    ->join('student', 'student.sid', '=', 'appointment.pid')
                    ->join('schedule', 'schedule.scheduleid', '=', 'appointment.scheduleid')
                    ->where('schedule.scheduleid', $id)
                    ->select('student.sid', 'student.sname', 'student.stel', 'appointment.apponum')
                    ->get();
            }
        }

        return view('admin.schedule', compact(
            'admin', 'today', 'action', 'id', 'nameget', 'facultyList', 'schedules', 'sessionDetails', 'appointments'
        ));
    }

    public function deleteSession(Request $request)
    {
        $id = $request->input('id');
        DB::table('schedule')->where('scheduleid', $id)->delete();
        return redirect('/admin/schedule');
    }

    public function appointment(Request $request)
    {
        $useremail = Session::get('user');
        $admin = Admin::where('aemail', $useremail)->first();
        if (!$admin) {
            return redirect('/login');
        }

        $today = date('Y-m-d');
        $action = $request->query('action', '');
        $id = $request->query('id', '');
        $nameget = $request->query('name', '');
        $session = $request->query('session', '');
        $apponum = $request->query('apponum', '');

        $facultyList = DB::table('faculty')->orderBy('facname', 'asc')->get();

        $query = DB::table('appointment')
            ->join('schedule', 'schedule.scheduleid', '=', 'appointment.scheduleid')
            ->join('student', 'student.sid', '=', 'appointment.pid')
            ->join('faculty', 'schedule.facid', '=', 'faculty.facid')
            ->select('appointment.appoid', 'schedule.scheduleid', 'schedule.title', 'faculty.facname', 'student.sname', 'schedule.scheduledate', 'schedule.scheduletime', 'appointment.apponum', 'appointment.appodate');

        if ($request->isMethod('post')) {
            if ($request->filled('sheduledate')) {
                $query->where('schedule.scheduledate', $request->input('sheduledate'));
            }
            if ($request->filled('docid')) {
                $query->where('faculty.facid', $request->input('docid'));
            }
            $appointments = $query->get();
        }
        else {
            $appointments = $query->orderBy('schedule.scheduledate', 'desc')->get();
        }

        return view('admin.appointment', compact(
            'admin', 'today', 'action', 'id', 'nameget', 'session', 'apponum', 'facultyList', 'appointments'
        ));
    }

    public function deleteAppointment(Request $request)
    {
        $id = $request->input('id');
        DB::table('appointment')->where('appoid', $id)->delete();
        return redirect('/admin/appointment');
    }

    public function student(Request $request)
    {
        $useremail = Session::get('user');
        $admin = Admin::where('aemail', $useremail)->first();
        if (!$admin) {
            return redirect('/login');
        }

        $today = date('Y-m-d');
        $action = $request->query('action', '');
        $id = $request->query('id', '');

        $query = DB::table('student');
        if ($request->isMethod('post') && $request->has('search')) {
            $keyword = $request->input('search');
            $query->where('semail', $keyword)
                ->orWhere('sname', 'like', "%$keyword%");
            $students = $query->get();
        }
        else {
            $students = $query->orderBy('sid', 'desc')->get();
        }

        $studentDetails = null;
        if ($action == 'view' && $id) {
            $studentDetails = DB::table('student')->where('sid', $id)->first();
        }

        $studentDataList = DB::table('student')->select('sname', 'semail')->get();

        return view('admin.student', compact(
            'admin', 'today', 'action', 'id', 'students', 'studentDetails', 'studentDataList'
        ));
    }

    public function settings(Request $request)
    {
        $useremail = Session::get('user');
        $admin = Admin::where('aemail', $useremail)->first();
        if (!$admin) {
            return redirect('/login');
        }
        $today = date('Y-m-d');

        return view('admin.settings', compact('admin', 'today'));
    }
}
