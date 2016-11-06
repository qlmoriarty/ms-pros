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
use Aws;
use App\Library\CustomDateFunctions;

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
         $a = $request->input('Date_From');
         $newDate = date("d-m-Y", strtotime($a));
         $dateunix = (string) strval(strtotime($newDate)*1000);


         $b = $request->input('Date_To');
         $newDate2 = date("d-m-Y",(strtotime($b)));
         $dateunix2 = (string) strval(strtotime($newDate2)*1000);



         $sdk = new Aws\Sdk([
             'region' => 'us-east-1',
             'version' => 'latest'
         ]);

         $dynamodb = $sdk->createDynamoDb();
         $tableName = 'Payments';
         $params = [
             'TableName' => $tableName,
             'ExpressionAttributeValues' => [
                 ':datStart' => ['N' => $dateunix],
                 ':datEnd' => ['N' => $dateunix2]
             ],
             'FilterExpression' => 'DateAdd >= :datStart AND DateAdd <= :datEnd'];

        $response = $dynamodb->scan($params);

         return view('payments.search',compact('response'));

     }

    /**
     * @return array
     */
    public function searchUser(Request $request, $userID)
    {
        $a = $request->input('Date_From');
        $newDate = date("d-m-Y", strtotime($a));
        $dateunix = (string) strval(strtotime($newDate)*1000);


        $b = $request->input('Date_To');
        $newDate2 = date("d-m-Y",(strtotime($b)));
        $dateunix2 = (string) strval(strtotime($newDate2)*1000);



        $sdk = new Aws\Sdk([
            'region' => 'us-east-1',
            'version' => 'latest'
        ]);

        $dynamodb = $sdk->createDynamoDb();
        $tableName = 'Payments';
        $params = [
            'TableName' => $tableName,
            'ExpressionAttributeValues' => [
//                ':datStart' => ['N' => $dateunix],
                ':UserID' => ['S' => $userID],
//                ':datEnd' => ['N' => $dateunix2]
            ],
            'FilterExpression' => ' UserID = :UserID'];

        $response = $dynamodb->scan($params);
//        $title = 'All Payments for ' . $userID;
        return view('payments.search',compact('response'));

    }


    public function index()
    {

    	$Data = Payments::all()->sortBy('DateAdd',SORT_ASC);
        // return $Data;

        return view('payments.index', compact('Data'));
    }


    public function show($id, Request $request)
        {
            $a = $request->input('Date_From');
            $b = $request->input('Date_To');

        if(isset($a) && isset($b)){
            $newDate = date("d-m-Y", strtotime($a));
            $dateunix = (string) strval(strtotime($newDate)*1000);

            $newDate2 = date("d-m-Y",(strtotime($b)));
            $dateunix2 = (string) strval(strtotime($newDate2)*1000);

            $sdk = new Aws\Sdk([
                'region' => 'us-east-1',
                'version' => 'latest'
            ]);

            $dynamodb = $sdk->createDynamoDb();
            $tableName = 'Payments';
            $params = [
                'TableName' => $tableName,
                'ExpressionAttributeValues' => [
                    ':datStart' => ['N' => $dateunix],
                    ':datEnd' => ['N' => $dateunix2],
//                    ':datEnd' => ['S' => $id]
                ],
                'FilterExpression' => 'DateAdd >= :datStart AND DateAdd <= :datEnd'];
//                'FilterExpression' => 'DateAdd >= :datStart AND DateAdd <= :datEnd AND UserID == :datUser'];

            $response = $dynamodb->scan($params);
            $Data = $response;
        }
        else
        {
            $Data = Payments::all()->sortBy('DateAdd',SORT_ASC);
        }




//            $data = Payments::all()->where('UserID', $id)
//                ->all();
//            return dd($data);
//             return $Payments;
//            return dd($data->find($id));
            // 
            return view('payments.index', compact('Data'));
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
