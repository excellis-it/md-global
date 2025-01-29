<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ClinicDetails;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index()
    {
        return view('admin.clinics.list');
    }

    public function listAjax(Request $request)
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
        $totalRecords = ClinicDetails::orderBy('id', 'desc')->count();
        $totalRecordswithFilter = ClinicDetails::orderBy('id', 'desc')->count();

        // Fetch records
        $records = ClinicDetails::query();
        $columns = ['clinic_name', 'clinic_address', 'clinic_phone'];
        $records->orWhereHas('doctor', function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        });
        $records->orWhereHas('doctor', function ($query) use ($searchValue) {
            $query->where('email', 'like', '%' . $searchValue . '%');
        });
        foreach ($columns as $column) {
            $records->orWhere($column, 'like', '%' . $searchValue . '%');
        }

        foreach ($columns as $column) {
            if ($columnName == $column) {
                $records->orderBy($columnName, $columnSortOrder);
            }
        }

        $records->skip($start);
        $records->take($rowperpage);

        $records = $records->orderBy('id', 'desc')->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "doctor_name" => $record->doctor->name,
                "doctor_email" => $record->doctor->email,
                "clinic_name" => $record->clinic_name,
                "clinic_address" => $record->clinic_address,
                "clinic_phone" => $record->clinic_phone,
                "slot_day" => Helper::getClinicOpeninDay($record['id']),
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
}
