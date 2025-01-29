<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationMail;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Storage;
use File;

use function PHPUnit\Framework\fileExists;

class PatientController extends Controller
{
    use ImageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.patient.list');
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
        $totalRecords = User::role('PATIENT')->orderBy('id','desc')->count();
        $totalRecordswithFilter = User::role('PATIENT')->orderBy('id','desc')->count();

        // Fetch records
        $records = User::query();
        $columns = ['name','email','phone','location','gender','age', 'status'];
        foreach($columns as $column){
            $records->orWhere($column, 'like', '%' . $searchValue . '%');
        }
        // $records->orderBy($columnName,$columnSortOrder);
        if ($columnName == 'date_of_birth') {
            $records->orderBy('age',$columnSortOrder);
        } else {
            $records->orderBy($columnName,$columnSortOrder);
        }
        $records->skip($start);
        $records->take($rowperpage);

        $records = $records->orderBy('id','desc')->role('PATIENT')->get();

        $data_arr = array();

        foreach($records as $record){

            $data_arr[] = array(
               "name" => $record->name,
               "email" => $record->email,
               "phone" => $record->phone,
                "location" => $record->location,
                "gender" => $record->gender,
                "date_of_birth" => $record->age,
                "status" => '<div class="button-switch"><input type="checkbox" id="switch-orange" class="switch toggle-class" data-id="'.$record->id.'"'.($record->status ? 'checked' : '').'/><label for="switch-orange" class="lbl-off"></label><label for="switch-orange" class="lbl-on"></label></div>',
                "action" => '<a href="'.route('patients.edit',$record->id).'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;<a title="DeleteMedical Staff"  data-route="'.route('patients.delete', $record->id).'" href="javascipt:void(0);" id="delete"><i class="fas fa-trash"></i></a>'
            );
        }

        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );

        return response()->json($response);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.patient.create');
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
            'location' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'status' => 'required',
        ]);

        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->location = $request->location;
        $data->phone = $request->phone;
        $data->gender = $request->gender;
        $data->age = $request->age;
        $data->status = $request->status;
        $data->profile_picture = $this->imageUpload($request->file('profile_picture'), 'patient');
        $data->save();
        $data->assignRole('PATIENT');
        $maildata = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'type' => 'Patient',
        ];

        Mail::to($request->email)->send(new RegistrationMail($maildata));
        return redirect()->route('patients.index')->with('message', 'Patient created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = User::findOrFail($id);
        return view('admin.patient.edit')->with(compact('patient'));
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
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,' . $id,
            'location' => 'required',
            'phone' => 'required',
            'status' => 'required',
            'gender' => 'required',
            'age' => 'required',
        ]);
        $data = User::findOrFail($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->location = $request->location;
        $data->gender = $request->gender;
        $data->age = $request->age;
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
            $data->profile_picture = $this->imageUpload($request->file('profile_picture'), 'patient');
        }
        $data->save();
        return redirect()->route('patients.index')->with('message', 'Patient updated successfully.');
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

    public function changePatientsStatus(Request $request)
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
        return redirect()->route('patients.index')->with('error', 'Patient has been deleted successfully.');
    }
}
