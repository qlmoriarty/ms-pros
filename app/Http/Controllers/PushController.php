<?php

namespace App\Http\Controllers;

use App\Constant\UniversalConstant;
use Aws\Sns\Exception;
use App\LastId;
use App\Push;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Aws;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Traits\CapsuleManagerTrait;
use Yajra\Datatables\Facades\Datatables;

class PushController extends Controller
{

	public $active_list = [];

    public $http_avatar = 'https://s3.amazonaws.com/ms-pros/';

	public function __construct()
    {
        $this->active_list = UniversalConstant::getActiveList();
    }

    public function index()
    {
    	$Data = Push::all();
    	return view('push.index',compact('Data'));

    }

    public function create()
    {

        return view('push.create');
    }

    public function show($id)
    {

        return redirect('/pushes/' . $id . '/edit');
    }


    public function store(Request $request)
    {
        $NewsId = uniqid();
        if (!empty($request->file('Avatar'))) {
            $Avatar = 'data/avatars/' . $NewsId;
            $path = $request->file('Avatar')->store($Avatar, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $Avatar = $this->http_avatar . $path;
        } else {
            $Avatar = false;
        }
        $UserID = $request->input('UserID');
        //        Get Avatar
        // Get UIID

//        $Offer = new Offs();

        $New = Push::create([
            'NewsID' => (String)$NewsId,
            'DateAdd' => (String)Carbon::now()->format('Y-m-d H:i:s'),
            'ImageUrl' => $Avatar,
            'Text' => (String)$request->input('Text'),
            'Title' => (String)$request->input('Title'),
        ]);

        $New->save();
        return redirect('/pushes')->with('status', 'News was added!');
    }

    public function edit($id,$date)
    {
        $off_get_data = new Push();
        $off_get_data->find(['NewsID' => (string)$id, 'DateAdd' => $date]);
        return view('push.edit', compact('id','off_get_data', 'date'));
    }
    public function updatee($id,$date, \Illuminate\Http\Request $request)
    {
//        $date = $this->date;
        $off_get_data = new Push();
        $off_get_data->find(['NewsID' => (string)$id, 'DateAdd' => $date]);

        $Push = new Push();

        if (!empty($request->file('Avatar'))) {
            $Avatar = 'data/avatars/' . $id;
            $path = $request->file('Avatar')->store($Avatar, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $Avatar = $this->http_avatar . $path;
        } else {
            $Avatar =  $off_get_data->ImageUrl;
        }
//
        $NewsId =  $off_get_data->NewsID;
//        $Offer->save();
        $Push->update([
            'NewsID' => (String)$NewsId,
            'DateAdd' => (String)$date,
            'ImageUrl' => $Avatar,
//        'ImageUrl' => [],
            'Text' => (String)$request->input('Text'),
            'Title' => (String)$request->input('Title'),
        ]);

//   return dd((String)$request->input('Desc'));
        return redirect('/pushes')->with('status', 'News was Changed!');
//        return redirect('ya.ru');
    }

    public function del($id, $date)
    {
//            $date = $date;
//            return dd($date,$id);
//        $DATE = '2016-11-02 13:38:45';
//
        $off_get_data = new Push();
        $off_get_data->find(['NewsID' => (string)$id, 'DateAdd' => $date]);
////        return dd($off_get_data);
        $off_get_data->delete();
        return redirect('/pushes')->with('status', 'News was deleted');;
    }
    public function pushall()
    {
        $s3 = new Aws\Sns\SnsClient(
            [
                'region' => 'us-east-1',
                'version' => 'latest',
                'credentials' => [
                    'key'    => 'AKIAIZLXN4UVCLF7XQBQ',
                    'secret' => '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',
                ],
                'scheme' => 'http',
            ]
        ) ;

//        $result = $s3->publish(array(
//            'TopicArn' => 'arn:aws:sns:us-east-1:152914134265:MS_Pros_News',
//            'Message' => 'TEST TEXT',
//            'Subject' => 'TITLE'));

        $result = $s3->publish(array(
            'TopicArn' => 'arn:aws:sns:us-east-1:152914134265:MS_Pros_News',
            'Message' => 'TEST TEXT',
            'Subject' => 'TITLE',
            'MessageStructure' => 'array',
            'MessageAttributes' => array(
                'URL' => array(
                    'DataType' => 'String',
                    'StringValue' => 'URL TEST'))));

        return redirect('/pushes')->with('status', 'Push was Sent');;
    }
//    public function pushget()
//    {
//        return view('push.push');
//    }
//    public function push(Request $request)
//    {
//        $data = [
//            'text' => $request->input('Text'),
//            'data' =>$request->input('Text')
//
//        ];
//        return $data;
//    }







    }
