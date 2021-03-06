<?php

namespace App\Http\Controllers;

use App\LastId;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

class SettingController extends Controller
{

    public $fields = [
        'license' => [
            'title' => 'Fee',
            'fields' => [
                'license_ammo' => ['title' => 'The amount of license fee', 'type' => 'text'],
                'license_date' => ['title' => 'Validity', 'type' => 'text'],
            ]
        ]
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//      $Setting = Setting::getSetting();
        $Setting = Setting::all();
        return view('setting.index', compact('Setting'));
//        return view('setting.index', compact('Setting') + [
//                'fields' => $this->fields
//            ]);
    }


//    public function store(Request $request)
//    {
//
//        foreach ($request->all() as $key => $value) {
//            if (in_array($key, ['_token'])) continue;
//            Setting::create([
//                'Key' => $key,
//                'Value' => $value,
//            ]);
//        }
//
//        return redirect('/setting')->with('status', 'Settings updated!');
//    }
    public function edit($key)
    {
        $Setting = new Setting();
        $Setting->find($key);
        $data  = $Setting;
        return view('setting.edit', compact('data'));
    }

    public function update(Request $request)
    {   $key = $request->input('Key');

        $settings = new Setting();
        $settings->find($key);
        $settings->update([
            'Key' => $key,
            'Value' => $request->input('Value')
        ]);
        return redirect('/setting')->with('status', 'Setting was changed!');
    }

    public function create()
    {
//    $Setting = Setting::getSetting();

        return view('setting.create', compact('Setting'));
//    return redirect('/setting')->with('status', 'User added!');

    }
//         return view('setting.index', compact('Setting') + [
//                'fields' => $this->fields
//            ]);
//}

    public function store(Request $request)
    {
        $Setting = Setting::create([
            'Key' => $request->input('Key'),
            'Value' => $request->input('Value'),

        ]);

        $Setting->save();
        return redirect('/setting')->with('status', 'Setting added!');

    }

    public function del( $key)
    {
        $Setting = new Setting();
        $Setting->find($key);
//        $Setting = Setting::class;
//        $Setting->where('key', 'key value')->get();
//        $Setting = Setting::create([
//            'Key' => $request->input('Key'),
//            'Value' => $request->input('Value'),
//
//        ]);
        $Setting->delete();
//        dd($Setting);
//        $Setting->save();
        return redirect('/setting')->with('status', 'Setting added!');

    }



}