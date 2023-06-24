<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Crypt;
use DB;
use Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function Register()
    {
        return view('admin.register');
    }

    public function UserRegister()
    {
        return view('user.register');
    }

    public function Dashboard()
    {
        return view('admin.pages.dashboard');
    }

    public function RegisterProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);

        //get admin type 
        $user_type = UserType::where('user_type','Admin')->first();
        
        $user = new User;
        $user->user_name = $request->name;
        $user->user_types_id = $user_type->id;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->dob = $request->birthday;
        $user->nic = $request->nic;
        $user->contact_no = $request->contact;
        $user->password = Crypt::encryptString($request->password);
        $user->save();

        return redirect('/admin/login')->with('messsage','Admin Registration Successfully');

    }

    public function UserRegisterProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);

        //get admin type 
        $user_type = UserType::where('user_type','User')->first();
        
        $user = new User;
        $user->user_name = $request->name;
        $user->user_types_id = $user_type->id;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->dob = $request->birthday;
        $user->nic = $request->nic;
        $user->contact_no = $request->contact;
        $user->password = Crypt::encryptString($request->password);
        $user->save();

        return redirect('/')->with('messsage','User Registration Successfully');
    }

    public function LoginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $result = DB::table('users')
            ->where(['email' => $request->email])
            ->get();

        if (isset($result[0])) {

            $db_pwd = Crypt::decryptString($result[0]->password);

            if ($db_pwd == $request->password) {

                $user_type = UserType::where('id',$result[0]->user_types_id)->get(['id','user_type']);

                //put sessions
                $request->session()->put('CM_FRONT_USER_LOGIN', true);
                $request->session()->put('vaccine_log_user', $result[0]->id);
                $request->session()->put('vaccine_log_user_type', $user_type[0]->user_type);
                $request->session()->put('vaccine_log_user_name', $result[0]->user_name);

                if($user_type[0]->user_type == "Admin")
                {
                    return redirect('/admin/dashboard');
                }
                else
                {
                    return redirect('/user/dashboard');
                }

            } else {
                return back()->with('error','Email or Password not matches.');
            }
        } 
        else
        {
            return back()->with('error','This Email is not registered.');
        }
    }

    public function AdminLogout(){
        if(Session::has('vaccine_log_user')){
           Session::pull('vaccine_log_user');
           Session::pull('vaccine_log_user_type');
           Session::pull('vaccine_log_user_name');
           session()->forget('CM_FRONT_USER_LOGIN');
           return redirect('/admin/login');
        }
    }

    public function UserLogout()
    {
        if(Session::has('vaccine_log_user')){
            Session::pull('vaccine_log_user');
            Session::pull('vaccine_log_user_type');
            Session::pull('vaccine_log_user_name');
            session()->forget('CM_FRONT_USER_LOGIN');
            return redirect('/');
        }
    }
}
