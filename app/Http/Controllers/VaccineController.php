<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\CenterVaccine;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    public function index()
    {
        return view('admin.pages.vacccines');
    }
    public function showvaccines()
    {
        $vaccines = Vaccine::orderBy('id', 'DESC')->get();

        $data = [];
        $count = 1;
        foreach ($vaccines as $row) {

            $delete = '<button type="button" class="btn btn-xs btn-danger show_confirm" data-toggle="tooltip" title="Delete" onclick="deleteData(' . $row->id . ')"><i class="fa-solid fa-trash-can"></i></button>';

            $edit =  '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-xs btn-primary edit" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';

            array_push($data, [
                'count'=>$count++,
                'name' => $row->name,
                'details' => $row->vaccine_details,
                'type' => $row->type,
                'edit_button' => $edit . ' ' . $delete
            ]);
        }

        header('Content-Type: application/json');
        $encode_data = json_encode($data);
        return $encode_data;
    }

    public function StoreNewVaccine(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        $vaccine = new Vaccine;
        $vaccine->name = $request->name;
        $vaccine->vaccine_details = $request->vaccine_details;
        $vaccine->type = $request->type;
        $vaccine->save();

        return response()->json(['success' => true]);

    }

    public function VaccineUpdate(Request $request)
    {
   
        $vaccine = Vaccine::find($request->vaccine_id);
        $vaccine->name = $request->name;
        $vaccine->vaccine_details = $request->vaccine_details;
        $vaccine->type = $request->type;
        $vaccine->update();

        return response()->json(['success' => true]);
    }

    public function VaccineDelete($id)
    {
        $vaccine = Vaccine::find($id);
        $vaccine->delete();

        return response()->json(['code' => 200, 'message' => 'User Deleted Successfully'], 200);
    }

    public function VaccineEdit(Request $request)
    {
        $id = $request->id;
        $vaccine = Vaccine::find($id);

        return response()->json(['vaccine' => $vaccine,'code' => 200], 200);
    }


    public function centers()
    {
        return view('admin.pages.centers');
    }
    public function showCenters()
    {
        $centers = Center::orderBy('id', 'DESC')->get();

        $data = [];
        $count = 1;
        foreach ($centers as $row) {

            $delete = '<button type="button" class="btn btn-xs btn-danger show_confirm" data-toggle="tooltip" title="Delete" onclick="deleteData(' . $row->id . ')"><i class="fa-solid fa-trash-can"></i></button>';

            $edit =  '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-xs btn-primary edit" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';

            array_push($data, [
                'count'=>$count++,
                'name' => $row->name,
                'address' => $row->address,
                'edit_button' => $edit . ' ' . $delete
            ]);
        }

        header('Content-Type: application/json');
        $encode_data = json_encode($data);
        return $encode_data;
    }

    public function StoreNewCenter(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $center = new Center;
        $center->name = $request->name;
        $center->address = $request->address;
        $center->save();

        return response()->json(['success' => true]);

    }

    public function CenterUpdate(Request $request)
    {
   
        $center = Center::find($request->center_id);
        $center->name = $request->name;
        $center->address = $request->address;
        $center->update();

        return response()->json(['success' => true]);
    }

    public function CenterDelete($id)
    {
        $center = Center::find($id);
        $center->delete();

        return response()->json(['code' => 200, 'message' => 'User Deleted Successfully'], 200);
    }

    public function CenterEdit(Request $request)
    {
        $id = $request->id;
        $center = Center::find($id);

        return response()->json(['center' => $center,'code' => 200], 200);
    }

    // center has vaccines

    public function centerVaccine()
    {
        $centers = Center::all();
        $vaccines = Vaccine::all();
        return view('admin.pages.center_schedule',compact('centers','vaccines'));
    }
    public function showVaccineCenters()
    {
        $centers = CenterVaccine::orderBy('id', 'DESC')
                    ->leftJoin('center','center.id','=','center_has_vaccines.center_id')
                    ->leftjoin('vaccines','vaccines.id','=','center_has_vaccines.vaccines_id')
                    ->select('center_has_vaccines.*','vaccines.name as vaccine_name','center.name as center_name')
                    ->get();

        $data = [];
        $count = 1;
        foreach ($centers as $row) {

            $delete = '<button type="button" class="btn btn-xs btn-danger show_confirm" data-toggle="tooltip" title="Delete" onclick="deleteData(' . $row->id . ')"><i class="fa-solid fa-trash-can"></i></button>';

            $edit =  '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-xs btn-primary edit" data-toggle="tooltip" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>';

            array_push($data, [
                'count'=>$count++,
                'center_name' => $row->center_name,
                'vaccine_name' => $row->vaccine_name,
                'date'=>$row->date,
                'time'=>$row->time,
                'ava_count'=>$row->count,
                'contact_no'=>$row->contact_no,
                'edit_button' => $edit . ' ' . $delete
            ]);
        }

        header('Content-Type: application/json');
        $encode_data = json_encode($data);
        return $encode_data;
    }

    public function StoreNewVaccineCenter(Request $request)
    {
        $request->validate([
            'center_name' => 'required',
            'vaccine_name' => 'required'
        ]);

        $center = new CenterVaccine;
        $center->center_id = $request->center_name;
        $center->vaccines_id = $request->vaccine_name;
        $center->date = $request->date;
        $center->time = $request->time;
        $center->count = $request->count;
        $center->contact_no = $request->contact_number;
        $center->save();

        return response()->json(['success' => true]);

    }

    public function CenterVaccineUpdate(Request $request)
    {
   
        $center = CenterVaccine::find($request->schedule_id);
        $center->center_id = $request->center_name;
        $center->vaccines_id = $request->vaccine_name;
        $center->date = $request->date;
        $center->time = $request->time;
        $center->count = $request->count;
        $center->contact_no = $request->contact_number;
        $center->update();

        return response()->json(['success' => true]);
    }

    public function CenterVaccineDelete($id)
    {
        $center = CenterVaccine::find($id);
        $center->delete();

        return response()->json(['code' => 200, 'message' => 'User Deleted Successfully'], 200);
    }

    public function CenterVaccineEdit(Request $request)
    {
        $id = $request->id;
        $center = CenterVaccine::find($id);

        return response()->json(['schedule' => $center,'code' => 200], 200);
    }

}
