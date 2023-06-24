<?php

namespace App\Http\Controllers;

use App\Models\CenterVaccine;
use App\Models\Feedback;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function index()
    {
        return view('user.pages.dashboard');
    }

    public function schedules()
    {
        $schedules = CenterVaccine::orderBy('id', 'DESC')
                    ->leftJoin('center','center.id','=','center_has_vaccines.center_id')
                    ->leftjoin('vaccines','vaccines.id','=','center_has_vaccines.vaccines_id')
                    ->select('center_has_vaccines.*','vaccines.name as vaccine_name','center.name as center_name')
                    ->get();

        return view('user.pages.center_schedule',compact('schedules'));
    }

    public function addReservation(Request $request)
    {
        $schedule = CenterVaccine::leftJoin('center','center.id','=','center_has_vaccines.center_id')
                    ->leftjoin('vaccines','vaccines.id','=','center_has_vaccines.vaccines_id')
                    ->select('center_has_vaccines.*','vaccines.name as vaccine_name','vaccines.type as type','center.name as center_name','center.address as address')
                    ->where('center_has_vaccines.id',$request->id)
                    ->first();

        return response()->json(['success'=>true,'schedule'=>$schedule]);
    }


    public function storeReservation(Request $request)
    {
        $request->validate([
            'dose' => 'required',
            'time' => 'required',
        ]);

        $user_id = Session::get('vaccine_log_user');

        $number = mt_rand(1000000000, 9999999999);

        $reservation = new Reservation;
        $reservation->users_id = $user_id;
        $reservation->center_has_vaccines_id = $request->schedule_id;
        $reservation->date = $request->date;
        $reservation->time = $request->time;
        $reservation->token = $number;
        $reservation->dose = $request->dose;
        $reservation->is_confirm = 0;
        $reservation->status = 0;
        $reservation->save();

        $log_user = User::find($user_id);

        $reservation_date = Carbon::parse($reservation->date)->format('d/m/Y');

        $data = ['name' => $log_user->user_name,'date'=> $reservation_date,'center'=>$request->center_name,'token' => $reservation->token , 'reservation_id'=>$reservation->id];
        $user['to'] = $log_user->email;
        Mail::send('confirmation_email', $data, function ($messages) use ($user) {
            $messages->from('sandeepamuthumal8032@gmail.com', 'Vaccination Management System');
            $messages->to($user['to']);
            $messages->subject('Verify Your Reservation');
        });

        return response()->json(['success'=>true,'reservation_id'=>$reservation->id]);
    }

    public function VerifyReservation($id)
    {
        $reservation = Reservation::find($id);
        $reservation->is_confirm = 1;
        $reservation->update();

        return redirect('/reservations')->with('message','Your Verification Completed');
    }

    public function Reservation()
    {
        $schedules = CenterVaccine::orderBy('id', 'DESC')
                    ->leftJoin('center','center.id','=','center_has_vaccines.center_id')
                    ->leftjoin('vaccines','vaccines.id','=','center_has_vaccines.vaccines_id')
                    ->select('center_has_vaccines.*','vaccines.name as vaccine_name','center.name as center_name')
                    ->get();

        return view('user.pages.reservations',compact('schedules'));
    }

    public function LoadReservation()
    {
        $user_id = Session::get('vaccine_log_user');

        $reservations = Reservation::leftjoin('center_has_vaccines','center_has_vaccines.id','=','reservations.center_has_vaccines_id')
                                    ->leftJoin('center','center.id','=','center_has_vaccines.center_id')
                                    ->leftjoin('vaccines','vaccines.id','=','center_has_vaccines.vaccines_id')
                                    ->select('reservations.*','center_has_vaccines.contact_no','vaccines.name as vaccine_name','center.name as center_name')
                                    ->where('reservations.users_id',$user_id)
                                    ->get();

        $data = [];

        foreach($reservations as $row)
        {
            $delete = '<button type="button" class="btn btn-xs btn-danger show_confirm" data-toggle="tooltip" title="Delete" onclick="deleteData(' . $row->id . ')"><i class="fa-solid fa-trash-can"></i></button>';

            $edit =  '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-xs btn-primary edit" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';

            if($row->is_confirm == 0)
            {
                $verification = '<span class="badge light badge-danger">Pending</span>';
            }
            else
            {
                $verification = '<span class="badge light badge-success">Verified</span>';
            }

            array_push($data, [
                'code' => $row->token,
                'center_name' => $row->center_name,
                'vaccine_name' => $row->vaccine_name,
                'date'=>$row->date,
                'time' => $row->time,
                'verification'=>$verification,
                'edit_button' => $edit . ' ' . $delete
            ]);
        }

        header('Content-Type: application/json');
        $encode_data = json_encode($data);
        return $encode_data;
    }

    public function EditReservation(Request $request)
    {
        $reservation = Reservation::find($request->id);

        return response()->json(['success'=>true,'reservation'=>$reservation]);
    }

    public function UpdateReservation(Request $request)
    {
        $reservation = Reservation::find($request->reservation_id);
        $reservation->center_has_vaccines_id = $request->schedule_name;
        $reservation->time = $request->time;
        $reservation->dose = $request->dose;
        $reservation->update();

        return response()->json(['success'=>true]);
    }

    public function DeleteReservation($id)
    {
        $reservation = Reservation::find($id);
        $reservation->delete();
        return response()->json(['success'=>true]);
    }

    public function feedback()
    {
        $feedbacks = Feedback::leftjoin('users','users.id','=','feedbacks.users_id')
                    ->orderBy('feedbacks.id','DESC')->get();
        return view('user.pages.add_feedback',compact('feedbacks'));
    }

    public function SubmitFeedback(Request $request)
    {
        $user_id = Session::get('vaccine_log_user');

        $feedback = new Feedback;
        $feedback->users_id = $user_id;
        $feedback->feedback = $request->feedback;
        $feedback->save();

        return redirect()->back()->with('message','Your feedback added successfully');
    }


}
