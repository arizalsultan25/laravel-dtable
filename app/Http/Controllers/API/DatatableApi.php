<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DatatableApi extends Controller
{
    // datatable user table
    public function userDatatable(Request $request)
    {
        // Declaration
        $userModel = new User(); 
        $data = [];
        $no = $request->start;

        // Datatable data
        $datatableData = $userModel->datatableData($request);

        // Row view
        foreach($datatableData as $dt):
            $no++;
            $row = [];

            // Action button (dummy)
            $action = "<div class='btn-group' role='group' aria-label='Button group name'>
                <button type='button' class='btn btn-outline-info'>Detail</button>
                <button type='button' class='btn btn-outline-warning'>Edit</button>
                <button type='button' class='btn btn-outline-danger'>Delete</button>
            </div>";

            // Badge status
            if($dt->is_active){
                $badge = "<span class='badge bg-success rounded-pill'>active</span>";
            }else{
                $badge = "<span class='badge bg-danger rounded-pill'>nonactive</span>";
            }

            // response row
            $row[] = $no;
            $row[] = $dt->name;
            $row[] = $dt->email;
            $row[] = $badge;
            $row[] = $action;

            $data[] = $row;
        endforeach;

        // Response
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $userModel->datatableCountAll($request),
            'recordsFiltered' => $userModel->datatableCountFiltered($request),
            'data' => $data
        ]);
    }
}
