<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpAndSupport;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Help;

class HelpAndSupportController extends Controller
{
    public function helpAndSupport()
    {
        return view('admin.help-and-support.list');
    }

    public function helpAndSupportListAjax(Request $request)
    {
        // return $request->all();
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
        $totalRecords = HelpAndSupport::orderBy('id', 'desc')->count();
        $totalRecordswithFilter = HelpAndSupport::orderBy('id', 'desc')->where('name', 'like', '%' . $searchValue . '%')->orWhere('email', 'like', '%' . $searchValue . '%')->orWhere('phone', 'like', '%' . $searchValue . '%')->orWhere('subject', 'like', '%' . $searchValue . '%')->orWhere('message', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = HelpAndSupport::query();
        $columns = ['name', 'email', 'phone', 'subject', 'message'];
        foreach ($columns as $column) {
            $records->orWhere($column, 'like', '%' . $searchValue . '%');
        }
        $records->orderBy($columnName, $columnSortOrder);
        $records->skip($start);
        $records->take($rowperpage);

        $records = $records->orderBy('id', 'desc')->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "name" => $record->name,
                "email" => $record->email,
                "phone" => $record->phone,
                "subject" => $record->subject,
                "message" => $record->message,
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
