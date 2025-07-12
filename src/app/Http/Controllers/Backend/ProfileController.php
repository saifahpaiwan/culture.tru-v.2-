<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function profile()
    {
        $data = array(
            "users_find" => Auth::user(),
        );
        return view('backend.profile', compact('data'));
    }

    public function saveprofile(Request $request)
    {
        $user = Auth::user();
        $userPassword = $user->password;
        if ($request->changepassCheck) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'], 
                'old_password' => ['required', 'string', 'min:8'],
                'new_password' => ['required', 'string', 'min:8', 'same:passwordConfirm'],
                'passwordConfirm' => 'required'
            ]);

            if (!Hash::check($request->old_password, $userPassword)) {
                return back()->withErrors(['old_password' => 'รหัสผ่านไม่ตรงกัน !']);
            }

            $data = array(
                'name'      => $request->name, 
                'password'  => Hash::make($request->new_password),

                'updated_at'  => new \DateTime(),
                'ip_address'    => $request->ip(),
            );
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
            ]);

            $data = array(
                'name'      => $request->name,
                 
                'updated_at'  => new \DateTime(),
                'ip_address'    => $request->ip(),
            );
        }
        DB::table('users')->where('users.id', $user->id)->update($data);
        return redirect()->route('profile')->with('success', 'Update data successfully.');
    }
}
