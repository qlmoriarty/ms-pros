<?php

namespace App\Http\Controllers;

use App\Constant\UniversalConstant;
use App\LastId;
use App\Push;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
    	// return $Data;
    	return view('push.index',compact('Data'));

    }

     public function ajax()
    {
       return redirect('push.index');
    }


}
