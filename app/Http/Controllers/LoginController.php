<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Query the database for the user
        $user = DB::table('admins')->where('username', $username)->first();

        if ($user && $this->checkPassword($password, $user->password)) {
            // Password matches, log the user in
            Session::put('user', $username); // Store user in session

            // Redirect to the admins index page
            return redirect('admin/index');
        }

        // Authentication failed
        return redirect('login')->with('error', 'Invalid username or password'); // Store error message in session
    }


    // Custom function to compare passwords
    private function checkPassword($inputPassword, $storedHash)
    {
        // Hash the input password with SHA1 and compare with the stored hash
        return sha1($inputPassword) === $storedHash;
    }
}
