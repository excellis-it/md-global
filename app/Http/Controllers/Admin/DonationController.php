<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        return view('admin.donations.list');
    }

    public function listAjax(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        // Total records
        $totalRecords = Donation::count();
        $totalRecordswithFilter = Donation::where('first_name', 'like', '%' . $searchValue . '%')
            ->orWhere('last_name', 'like', '%' . $searchValue . '%')
            ->orWhere('email', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records
        $records = Donation::query();
        if ($searchValue) {
            $records->where(function ($query) use ($searchValue) {
                $query->where('first_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('last_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%')
                    ->orWhere('donation_amount', 'like', '%' . $searchValue . '%');
            });
        }

        $records->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage);

        $records = $records->get();

        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "first_name" => $record->first_name,
                "last_name" => $record->last_name,
                "email" => $record->email,
                "address" => $record->address,
                "city" => $record->city,
                "state" => $record->state,
                "country" => $record->country,
                "postcode" => $record->postcode,
                "donation_amount" => $record->donation_amount,
                "payment_method" => $record->payment_method,
                "payment_status" => $record->payment_status,
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
