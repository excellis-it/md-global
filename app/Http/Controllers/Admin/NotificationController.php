<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.notifications.list');
    }

    public function notificationListAjax(Request $request)
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
        $totalRecords = Notification::orderBy('id','desc')->count();
        $totalRecordswithFilter = Notification::orderBy('id','desc')->count();

        // Fetch records
        $records = Notification::query();
        $columns = ['send_to','message'];
        foreach($columns as $column){
            $records->orWhere($column, 'like', '%' . $searchValue . '%');
        }
        $records->orderBy($columnName,$columnSortOrder);
        $records->skip($start);
        $records->take($rowperpage);

        $records = $records->orderBy('id','desc')->get();

        $data_arr = array();

        foreach($records as $key => $record){

            $data_arr[] = array(
               "id" => $record->id,
                "send_to" => $record->send_to,
                "message" => $record->message,
                "action" => '<a href="'.route('notifications.edit',$record->id).'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;<a title="DeleteMedical Staff"  data-route="'.route('notifications.delete', $record->id).'" href="javascipt:void(0);" id="delete"><i class="fas fa-trash"></i></a>'
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
        return view ('admin.notifications.create');
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
            'send_to' => 'required',
            'message' => 'required',
        ]);

        $notification = new Notification();
        $notification->send_to = $request->send_to;
        $notification->message = $request->message;
        $notification->save();
        return redirect()->route('notifications.index')->with('success','Notification created successfully');
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
        $notification  = Notification::findOrFail($id);
        return view('admin.notifications.edit')->with(compact('notification'));
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
            'send_to' => 'required',
            'message' => 'required',
        ]);

        $notification = Notification::findOrFail($id);
        $notification->send_to = $request->send_to;
        $notification->message = $request->message;
        $notification->save();
        return redirect()->route('notifications.index')->with('success','Notification updated & send successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Notification::findOrFail($id)->delete();
        return redirect()->route('notifications.index')->with('error','Notification has been deleted from everyone.');
    }
}
