<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Http\Requests;
use App\Constant\UniversalConstant;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Traits\CapsuleManagerTrait;
//use Yajra\Datatables\Facades\Datatables;

//use App\LastId;
use App\Offs;
//use App\SubCategory;

//use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Traits\CapsuleManagerTrait;
//use Yajra\Datatables\Facades\Datatables;

class OffsController extends Controller
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
         $Data = Offs::all();

        return view('offer.index',compact('Data'));
    }

 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offer.create', [
            'active_list' => $this->active_list
        ]);
    }




public function store(Request $request)
    {

//
        if ($request->input('Active') == 'true')
        {
            $Active = true;
        }
        else
        {
            $Active = false;
        }

//    $LastId = LastId::get(Offs::class);
//      $UserID = $LastId->id;;

    $UserID = $request->input('UserID');
//$UserID = uniqid('', true);

        if (!empty($request->file('Avatar'))) {
            $Avatar = 'data/avatars/' . $UserID;
            $path = $request->file('Avatar')->store($Avatar, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $Avatar = $this->http_avatar . $path;
        } else {
            $Avatar = false;
        }
//        $Avatar = false;
        $uniqid = uniqid();
//        $OfferID = $request->input('OfferID');
        $OfferID = $uniqid;
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $create = <pre>' . print_r($create, true) . "</pre><br>\n";exit;
//        $Offer = Offs::create($create);

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

//        return $Offer;
        return redirect('/offer')->with('status', 'User added!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return redirect('/offer/' . $id . '/edit');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return view('offer.edit', compact('id') );
//        return view('offer.edit', compact('ID') + [
//                'active_list' => $this->active_list
//            ]);
    }


    public function update(Request $request, $id)
    {

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
            $Avatar = false;
        }







        $OfferID = $id;
//        $Offer->save();
        $Offer->update([
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

//        return dd($Offer);
        return redirect('asdf');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function del($id)
    {


        $Offer = new Offs();
        $Offer->find($id)->delete();;

        return redirect('/offer/')->with('status', 'Offer was deleted!');;
    }



    public function destroy($id)
    {
        $Offer = Offs::class;
        $Offer->delete();
//        return dd($Offer);
//        $Offer->find($id);
//        $Offer = Offs::all()->where('OfferID', $id);
//        $Offer->delete();
//        return $Offer;
//        if (!empty($Offer->Avatar)) {
//            Storage::disk('s3')->delete(str_replace($this->http_avatar, '', $Offer->Avatar));
//        }
//        $Offer->delete();
//        return response()->json(['success' => true]);
    }
}


