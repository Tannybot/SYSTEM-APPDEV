<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebUser;
use App\Models\Admin;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'useremail' => 'required|email',
            'userpassword' => 'required'
        ]);

        $email = $request->input('useremail');
        $password = $request->input('userpassword');

        $webuser = WebUser::where('email', $email)->first();

        if ($webuser) {
            $utype = $webuser->usertype;

            if ($utype == 's') {
                $student = Student::where('semail', $email)->where('spassword', $password)->first();
                if ($student) {
                    Session::put('user', $email);
                    Session::put('usertype', 's');
                    return redirect('/student/dashboard');
                }
            }
            elseif ($utype == 'a') {
                $admin = Admin::where('aemail', $email)->where('apassword', $password)->first();
                if ($admin) {
                    Session::put('user', $email);
                    Session::put('usertype', 'a');
                    return redirect('/admin/dashboard');
                }
            }
            elseif ($utype == 'f') {
                $faculty = Faculty::where('facemail', $email)->where('facpassword', $password)->first();
                if ($faculty) {
                    Session::put('user', $email);
                    Session::put('usertype', 'f');
                    return redirect('/faculty/dashboard');
                }
            }

            return back()->with('error', 'Wrong credentials: Invalid email or password');
        }

        return back()->with('error', 'We cant found any account for this email.');
    }

    public function showSignup()
    {
        return view('auth.signup');
    }

    public function processSignupRole(Request $request)
    {
        $role = $request->input('role');
        if ($role == 'student') {
            return redirect()->route('signup.student');
        }
        elseif ($role == 'faculty') {
            return redirect()->route('signup.faculty');
        }
        return back()->with('error', 'Please select a role.');
    }

    public function showStudentSignup()
    {
        return view('auth.signup-student');
    }

    public function registerStudent(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'address' => 'required',
            'dob' => 'required|date',
            'newemail' => 'required|email|unique:webuser,email',
            'tele' => 'required|regex:/^\d{11}$/',
            'newpassword' => 'required',
            'cpassword' => 'required|same:newpassword'
        ]);

        $name = $request->input('fname') . " " . $request->input('lname');
        $email = $request->input('newemail');

        Student::insert([
            'semail' => $email,
            'sname' => $name,
            'spassword' => $request->input('newpassword'),
            'saddress' => $request->input('address'),
            'snic' => '',
            'sdob' => $request->input('dob'),
            'stel' => $request->input('tele')
        ]);

        WebUser::insert([
            'email' => $email,
            'usertype' => 's'
        ]);

        Session::put('user', $email);
        Session::put('usertype', 's');
        Session::put('username', $request->input('fname'));

        return redirect('/student/dashboard');
    }

    public function showFacultySignup()
    {
        return view('auth.signup-faculty');
    }

    public function registerFaculty(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'newemail' => 'required|email|unique:webuser,email',
            'tele' => 'required|regex:/^\d{11}$/',
            'subject' => 'required',
            'newpassword' => 'required',
            'cpassword' => 'required|same:newpassword'
        ]);

        $name = $request->input('fname') . " " . $request->input('lname');
        $email = $request->input('newemail');

        Faculty::insert([
            'facemail' => $email,
            'facname' => $name,
            'facpassword' => $request->input('newpassword'),
            'factel' => $request->input('tele'),
            'subject' => $request->input('subject')
        ]);

        WebUser::insert([
            'email' => $email,
            'usertype' => 'f'
        ]);

        Session::put('user', $email);
        Session::put('usertype', 'f');
        Session::put('username', $request->input('fname'));

        return redirect('/faculty/dashboard');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
