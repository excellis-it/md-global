<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class VideoCallPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.video-call-payment.list');
    }

    public function listAjax(Request $request)
    {
        // return $request;
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
        $totalRecords = Payment::orderBy('id', 'desc')->count();
        $totalRecordswithFilter = Payment::orderBy('id', 'desc')->count();

        // Fetch records
        $records = Payment::query();
        $records->with(['patient', 'doctor']);
        $records->orWhereHas('patient', function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        });
        $records->orWhereHas('patient', function ($query) use ($searchValue) {
            $query->where('email', 'like', '%' . $searchValue . '%');
        });
        $records->orWhereHas('doctor', function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        });
        $records->orWhereHas('doctor', function ($query) use ($searchValue) {
            $query->where('email', 'like', '%' . $searchValue . '%');
        });

        $coulmns = ['amount', 'created_at', 'call_duration'];
        foreach ($coulmns as $column) {
            $records->orWhere($column, 'like', '%' . $searchValue . '%');
        }

        if ($columnName == 'duration') {
            // order by date pattern 01-01-2021
            $records->orderBy('call_duration', $columnSortOrder);
        }
        if ($columnName == 'amount') {
            $records->orderBy('amount', $columnSortOrder);
        }
        if ($columnName == 'created_at') {
            $records->orderBy('created_at', $columnSortOrder);
        }

        $records->skip($start);
        $records->take($rowperpage);

        $records = $records->orderBy('id', 'desc')->get();

        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "patient_name" => $record->patient->name,
                "patient_email" => $record->patient->email,
                "doctor_name" => $record->doctor->name,
                "doctor_email" => $record->doctor->email,
                "duration" => $record->call_duration,
                "amount" => $record->amount,
                "created_at" => $record->created_at->format('d-m-Y'),
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
