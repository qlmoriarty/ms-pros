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
            'OfferID' => (String)$OfferID,
            'Active' => (Boolean)$request->input('Active'),
            'Avatar' => $Avatar,
            'Busy' => (Boolean)false,
            'CatID' => (int)$request->input('CatID'),
            'Contact' => (String)$request->input('Contacts'),
            'Cost' => (int)$request->input('Cost'),
            'Updated' => (String)Carbon::now()->format('Y-m-d H:i:s'),
            'UserID' => (String)$UserID ,
            'Desc' => (String)$request->input('Desc'),
            'Images' => (Array)[],
            'Name' => (String)$request->input('Name'),
            'Created' => (String)Carbon::now()->format('Y-m-d H:i:s'),
        ]);

       $Offer->save();
//        return var_dump($Offer);
//    return dd($Offer);
       return redirect('/offer')->with('status', 'Offer was added!');
    }

//    public function show($id)
//    {
//        return redirect('/offer/' . $id . '/edit');
//    }

    public function edit($id)
    {
        $off_get_data = new Offs();
        $off_get_data->find($id);
//        dd($off_get_data);
//        $id = $this->$id;

//        return redirect('http://ya.ru');
        return view('offer.edit', compact('id','off_get_data') );

    }
    public function update($id, Request $request)
    {
        $off_get_data = new Offs();
        $off_get_data->find($id);
        $Offer = new Offs();

        if ($request->input('Active') == 'true')
        {
            $Active = true;
        }
        else
        {
            $Active = false;
        }


        $UserID = $request->input('UserID');


        if (!empty($request->file('Avatar'))) {
            $Avatar = 'data/avatars/' . $UserID;
            $path = $request->file('Avatar')->store($Avatar, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $Avatar = $this->http_avatar . $path;
        } else {
            $Avatar =  $off_get_data->Avatar;
        }

        $OfferID = $id;
//        $Offer->save();
        $Offer->update([
            'OfferID' => (String)$OfferID,
            'Active' => (Boolean)$request->input('Active'),
            'Avatar' => $Avatar,
            'Busy' => (Boolean)false,
            'CatID' => (int)$request->input('CatID'),
            'Contact' => (String)$request->input('Contacts'),
            'Cost' => (int)$request->input('Cost'),
            'Updated' => (String)Carbon::now()->format('Y-m-d H:i:s'),
            'UserID' => (String)$UserID ,
            'Desc' => (String)$request->input('Desc'),
            'Images' => (Array)[],
            'Name' => (String)$request->input('Name'),
            'Created' => (String)Carbon::now()->format('Y-m-d H:i:s'),
        ]);

//   return dd((String)$request->input('Desc'));
        return redirect('/offer')->with('status', 'Offer was Changed!');
//        return redirect('ya.ru');
    }

    public function del($id)
    {
        $offer = new Offs();
        $offer->find($id);
        $offer->delete();
        return redirect('/offer');
    }


}
