<?php

namespace App\Http\Controllers;

use App\Constant\UniversalConstant;
use App\LastId;
use App\Payments;
use Carbon\Carbon;
use Faker\Provider\at_AT\Payment;
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
     public function search(Request $request)
    {
        $a = strtotime($request->input('Date_From')*1000);
        $b = strtotime($request->input('Date_To')*1000);
        $model = new Payments();

        // $model->where(['key' => 'key value']);
        // Chainable for 'AND'. 'OR' is not supported.
        // $model->where('foo', 'bar')
         $model->where(['DateAdd' => 1477721394620])->get();

        return $model;
    }

    public function index()
    {

    	$Data = Payments::all()->sortBy('DateAdd',SORT_ASC);
        // return $Data;

        return view('payments.index', compact('Data'));
    }


    public function show($id)
        {
//
//            $Payments = Payments::find($id);
            $Payments = Payments::all()->where('UserID', $id);

//            $data = Payments::all()->where('UserID', $id)
//                ->all();
//            return dd($data);
//             return $Payments;
//            return dd($data->find($id));
            // 
            return view('payments.single', compact('Payments'));
        }

    public function ajax()
    {

        $Data = Payments::all();

        return Datatables::of($Data)
//            ->editColumn('Avatar', function ($data) {
//                return $this->ajax_DT_Avatar($data);
//            })
//            ->editColumn('Active', function ($data) {
//                return $this->ajax_DT_Active($data);
//            })
            ->addColumn('control', function ($data) {
                $control = [];

                $control[] = '<a href="' . url('/profile/' . $data->UserID . '/edit') . '" class="btn btn-info btn-sm"><i class="fa fa-wrench"></i></a>';
                $control[] = '<a href="#" class="btn btn-danger btn-sm item_destroy" data-url="' . url('/profile/' . $data->UserID) . '"><i class="fa fa-trash"></i></a>';
                $control = implode('&#160;', $control);

                $control = '<div class="control">' . $control . '</div>';
                return $control;
            })->make(true);

    }

   
}
