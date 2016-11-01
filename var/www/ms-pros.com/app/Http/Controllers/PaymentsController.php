<?php

namespace App\Http\Controllers;

use App\Constant\UniversalConstant;
use App\LastId;
use App\Payments;
use Carbon\Carbon;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Traits\CapsuleManagerTrait;
use Yajra\Datatables\Facades\Datatables;


use App\Http\Requests;

class PaymentsController extends Controller
{
    public $active_list = [];

    public $http_avatar = 'https://s3.amazonaws.com/ms-pros/';

    public function __construct()
    {
        $this->active_list = UniversalConstant::getActiveList();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Data = Payments::all();
        return $Data;
//        return view('payments.index');
    }

 public function ajax()
    {
        $Data = Payments::all();
        return $Data;
//        return Datatables
//            ::of($Data)
//
//            // ->editColumn('Active', function ($data) {
//            //     return $this->ajax_DT_Active($data);
//            // })
//            ->addColumn('control', function ($data) {
//                $control = [];
//
//                $control[] = '<a href="' . url('/payments/' . $data->UserID . '/edit') . '" class="btn btn-info btn-sm"><i class="fa fa-wrench"></i></a>';
//                $control[] = '<a href="#" class="btn btn-danger btn-sm item_destroy" data-url="' . url('/payments/' . $data->UserID) . '"><i class="fa fa-trash"></i></a>';
//                $control = implode('&#160;', $control);
//
//                $control = '<div class="control">' . $control . '</div>';
//                return $control;
//            })
//            ->make(true);
    }
}
