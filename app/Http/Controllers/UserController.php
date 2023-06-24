<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Reservation;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Crypt;

class UserController extends Controller
{
    public function index()
    {
        $user_types = UserType::all();
        return view('admin.pages.users', compact('user_types'));
    }
    public function showusers()
    {
        $users = User::orderBy('id', 'DESC')
            ->leftjoin('user_types', 'user_types.id', 'users.user_types_id')
            ->select('user_types.user_type', 'users.*')
            ->where('users.status',1)
            ->get();

        $data = [];
        foreach ($users as $row) {

            $delete = '<button type="button" class="btn btn-xs btn-danger show_confirm" data-toggle="tooltip" title="Delete" onclick="deleteData(' . $row->id . ')"><i class="fa-solid fa-trash-can"></i></button>';

            $edit =  '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-xs btn-primary edit" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';

            array_push($data, [
                'user_name' => $row->user_name,
                'email' => $row->email,
                'contact' => $row->contact_no,
                'nic'=>$row->nic,
                'type' => $row->user_type,
                'edit_button' => $edit . ' ' . $delete
            ]);
        }

        header('Content-Type: application/json');
        $encode_data = json_encode($data);
        return $encode_data;
    }

    public function StoreNewUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'user_level' => 'required'
        ]);

        $user = new User;
        $user->user_name = $request->name;
        $user->user_types_id = $request->user_level;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->dob = $request->birthday;
        $user->nic = $request->nic;
        $user->contact_no = $request->contact_number;
        $user->password = Crypt::encryptString($request->password);
        $user->save();

        return response()->json(['success' => true]);

    }

    public function Update(Request $request)
    {
   
        $user = User::find($request->user_id);
        $user->user_name = $request->name;
        $user->user_types_id = $request->user_level;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->dob = $request->birthday;
        $user->nic = $request->nic;
        $user->contact_no = $request->contact_number;
        $user->password = Crypt::encryptString($request->password);
        $user->update();

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->status = 0;
        $user->update();

        return response()->json(['code' => 200, 'message' => 'User Deleted Successfully'], 200);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);

        $db_pwd = Crypt::decryptString($user->password);

        return response()->json(['user' => $user,'code' => 200, 'password' => $db_pwd], 200);
    }

    public function reservations()
    {
        $reservations = Reservation::leftjoin('center_has_vaccines','center_has_vaccines.id','=','reservations.center_has_vaccines_id')
                                    ->leftJoin('center','center.id','=','center_has_vaccines.center_id')
                                    ->leftjoin('vaccines','vaccines.id','=','center_has_vaccines.vaccines_id')
                                    ->leftjoin('users','users.id','=','reservations.users_id')
                                    ->select('reservations.*','users.user_name','center_has_vaccines.contact_no','vaccines.name as vaccine_name','center.name as center_name')
                                    ->where('reservations.is_confirm',1)
                                    ->get();

        return view('admin.pages.reservations',compact('reservations'));
    }

    public function feedbacks()
    {
        $feedbacks = Feedback::leftjoin('users','users.id','=','feedbacks.users_id')
                    ->orderBy('feedbacks.id','DESC')->get();

        return view('admin.pages.feedbacks',compact('feedbacks'));
                       
    }

    public function reservationComplete($id)
    {
        $reservation = Reservation::find($id);
        $reservation->status = 1;
        $reservation->update();

        return redirect()->back()->with('message','Reservation Completed');
    }

}
