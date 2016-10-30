<?php

namespace App\Http\Controllers;


// use App\Http\Requests;
use App\Constant\UniversalConstant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Traits\CapsuleManagerTrait;

use App\Offs;
//use App\SubCategory;
use Illuminate\Http\Request;

class OfController extends Controller
{
    // нездаровая фигня для подгрузки елементов
    public $active_list = [];
    public $http_avatar = 'https://s3.amazonaws.com/ms-pros/';
    //Конструктор для выпадающего списка
    public function __construct()
    {
        $this->active_list = UniversalConstant::getActiveList();
    }


    public function index()
    {
        $offer = Offs::all();
        $Data = $offer;
        return view('offer.index', compact('Data'));
    }

    /**
     * @return array
     */

    public function create()
    {
//        return dd($this->active_list);
        return view('offer.create', [
            'active_list' => $this->active_list
        ]);
    }

    public function store(Request $request)
    {

        if ($request->input('Active') == 'true')
        {
            $Active = true;
        }
        else
        {
            $Active = false;
        }

      $UserID = $request->input('UserID');
        //        Get Avatar
        if (!empty($request->file('Avatar'))) {
            $Avatar = 'data/avatars/' . $UserID;
            $path = $request->file('Avatar')->store($Avatar, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $Avatar = $this->http_avatar . $path;
        } else {
            $Avatar = false;
        }

        // Get UIID
      $uniqid = uniqid();
      $OfferID = $uniqid;

//        $Offer = new Offs();

      $Offer = Offs::create([
            'OfferID' => $OfferID,
            'Active' => $Active,
            'Avatar' => $Avatar,
            'Busy' => false,
            'CarID' => $request->input('CatID'),
            'Contact' => $request->input('Contacts'),
            'Cost' => $request->input('Cost'),
            'Updated' => Carbon::now()->format('Y-m-d H:i:s'),
            'UserID' => $UserID ,
            'Desc' => $request->input('Desc'),
            'Images' => false,
            'Name' => $request->input('Name'),
            'Created' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

       $Offer->save();
    return dd($Offer);
//       return redirect('/off')->with('status', 'Offer was added!');
    }

    public function show($id)
    {
        return redirect('/off/' . $id . '/edit');
    }

    public function edit($id)
    {

        return view('offer.edit', compact('id') );

    }


}
