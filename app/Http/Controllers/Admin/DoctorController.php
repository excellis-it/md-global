<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationMail;
use App\Models\DoctorSpecialization;
use App\Models\Specialization;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Storage;
use File;

class DoctorController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.doctor.list');
    }

    public function ajaxList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = User::role('DOCTOR')->orderBy('id','desc')->count();
        $totalRecordswithFilter = User::role('DOCTOR')->orderBy('id','desc')->count();

        // Fetch records
        $records = User::query();
        $columns = ['name','email','phone','year_of_experience','gender','location', 'status'];
        foreach($columns as $column){
            $records->orWhere($column, 'like', '%' . $searchValue . '%');
        }
        $records->orderBy($columnName,$columnSortOrder);
        $records->skip($start);
        $records->take($rowperpage);

        $records = $records->orderBy('id','desc')->role('DOCTOR')->get();

        $data_arr = array();

        foreach($records as $record){
            // get doctor specialization
            $specialization = '';
            foreach($record->doctorSpecializations as $key => $value){
                // don't add comma for last element
                if($key == count($record->doctorSpecializations) - 1){
                    $specialization .= $value['specialization']['name'];
                    continue;
                }
                $specialization .= $value['specialization']['name'] . ', ';
            }

            $data_arr[] = array(
               "name" => $record->name,
               "email" => $record->email,
               "phone" => $record->phone,
               "specialization" => '<span class="badge bg-primary">'. $specialization  .'</span>',
               "year_of_experience" => $record->year_of_experience . ' Years',
               "gender" => $record->gender,
                "location" => $record->location,
                "status" => '<div class="button-switch"><input type="checkbox" id="switch-orange" class="switch toggle-class" data-id="'.$record->id.'"'.($record->status ? 'checked' : '').'/><label for="switch-orange" class="lbl-off"></label><label for="switch-orange" class="lbl-on"></label></div>',
                "action" => '<a href="'.route('medical-stuff.edit',$record->id).'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;<a title="Delete Doctor"  data-route="'.route('medical-stuff.delete', $record->id).'" href="javascipt:void(0);" id="delete"><i class="fas fa-trash"></i></a>&nbsp;&nbsp;<a title="View Medical Stuff Service Centers Details"  href="'.route('medical-stuff.show', $record->id).'" href="javascipt:void(0);"><i class="fas fa-eye"></i></a>'
            );
        }

        $response = array(
           "draw" => intval($draw),
           "iTotalRe                                                                                                                                                   co                                                                                                                                                    rds" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illum inate\Http\Response
     */
    public function create()
    {
        $specializations = Specialization::select('id', 'name')->get();
        return view('admin.doctor.create')->with(compact('specializations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
            'phone' => 'required',
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'status' => 'required',
            'gender' => 'required',
            'year_of_experience' => 'required|numeric',
            'specialization_id' => 'required',
        ]);

        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->phone = $request->phone;
        $data->location = $request->location;
        $data->gender = $request->gender;
        $data->year_of_experience = $request->year_of_experience;
        $data->status = $request->status;
        $data->profile_picture = $this->imageUpload($request->file('profile_picture'), 'doctor');
        $data->save();

        foreach ($request->specialization_id as $key => $value) {
            $doctorSpecialization = DoctorSpecialization::create([
                'doctor_id' => $data->id,
                'specialization_id' => $value,
            ]);
        }

        $data->assignRole('DOCTOR');
        $maildata = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'type' => 'Doctor',
        ];

        Mail::to($request->email)->send(new RegistrationMail($maildata));
        return redirect()->route('medical-stuff.index')->with('message', 'Medical Stuff created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doctor = User::with('doctorSpecializations')->findOrFail($id);
        $clinics = $doctor->clinicDetails;
        return view('admin.doctor.view')->with(compact('doctor', 'clinics'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $doctor = User::with('doctorSpecializations')->findOrFail($id);
         $specializations = Specialization::select('id', 'name')->get();
         return view('admin.doctor.edit')->with(compact('doctor','specializations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,'.$id,
            'phone' => 'required',
            'status' => 'required',
            'gender' => 'required',
            'year_of_experience' => 'required',
            'specialization_id' => 'required',
        ]);
        $data = User::findOrFail($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->location = $request->location;
        $data->phone = $request->phone;
        $data->gender = $request->gender;
        $data->year_of_experience = $request->year_of_experience;
        $data->status = $request->status;
        if ($request->password != null) {
            $request->validate([
                'password' => 'min:8',
                'confirm_password' => 'min:8|same:password',
            ]);
            $data->password = bcrypt($request->password);
        }
        if ($request->hasFile('profile_picture')) {
            $request->validate([
                'profile_picture' => 'image|mimes:jpg,png,jpeg,gif,svg',
            ]);
            if ($data->profile_picture) {
                $currentImageFilename = $data->profile_picture; // get current image name
                Storage::delete('app/'.$currentImageFilename);
            }
            $data->profile_picture = $this->imageUpload($request->file('profile_picture'), 'doctor');
        }
        $data->save();
        if ($request->specialization_id) {
            DoctorSpecialization::where('doctor_id', $id)->delete();
            foreach ($request->specialization_id as $key => $value) {
                $doctorSpecialization = DoctorSpecialization::create([
                    'doctor_id' => $id,
                    'specialization_id' => $value,
                ]);
            }
        }
        return redirect()->route('medical-stuff.index')->with('message', 'Medical Stuff updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeDoctorsStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success' => 'Status change successfully.']);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('medical-stuff.index')->with('error', 'Medical Stuff has been deleted successfully.');
    }
}
