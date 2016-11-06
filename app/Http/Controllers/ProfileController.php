<?php

namespace App\Http\Controllers;

use App\Constant\UniversalConstant;
use App\LastId;
use App\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Traits\CapsuleManagerTrait;
use Yajra\Datatables\Facades\Datatables;

class ProfileController extends Controller
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
        return view('profile.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax()
    {
        $Data = Profile::all();

        return Datatables
            ::of($Data)
            ->editColumn('Avatar', function ($data) {
                return $this->ajax_DT_Avatar($data);
            })
            ->editColumn('Active', function ($data) {
                return $this->ajax_DT_Active($data);
            })
            ->addColumn('control', function ($data) {
                $control = [];
                $control[] = '<a href="' . url('/payments/' . $data->UserID . '/search') . '" class="btn btn-info btn-sm"><i class="fa fa-dollar "></i></a>';
                $control[] = '<a href="' . url('/profile/' . $data->UserID . '/edit') . '" class="btn btn-info btn-sm"><i class="fa fa-wrench"></i></a>';
                $control[] = '<a href="#" class="btn btn-danger btn-sm item_destroy" data-url="' . url('/profile/' . $data->UserID) . '"><i class="fa fa-trash"></i></a>';
                $control = implode('&#160;', $control);

                $control = '<div class="control">' . $control . '</div>';
                return $control;
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profile.create', [
            'active_list' => $this->active_list
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'UserID' => 'required|email|max:255',
        ]);

        $validator->after(function () use ($validator, $request) {
            $count = Profile::where('UserID', '=', $request->input('UserID'))->first();
            if (!empty($count)) {
                $validator->errors()->add('UserID', 'This email field value already exists.');
            }
        });

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $request = <pre>' . print_r($request->all(), true) . "</pre><br>\n";
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $request = <pre>' . print_r($request->file(), true) . "</pre><br>\n";

        $UserID = $request->input('UserID');
        $Active = ($request->input('Active') == 'true') ? true : false;
        $Subscribe = $request->input('Subscribe');

        if (!empty($request->file('Avatar'))) {
            $Avatar = 'data/avatars/' . $UserID;
            $path = $request->file('Avatar')->store($Avatar, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $Avatar = $this->http_avatar . $path;
        } else {
            $Avatar = false;
        }



        $create = [
            'UserID' => $UserID,
            'Active' => $Active,
            'Avatar' => $Avatar,
            'Contacts' => $request->input('Contacts'),
            'Created' => Carbon::now()->format('Y-m-d\TH:i:s\Z'),
            'Description' => $request->input('Description'),
            'NickName' => $request->input('NickName'),
            'Subscribe' => (!empty($Subscribe)) ? Carbon::parse($Subscribe)->format('Y-m-d\TH:i:s\Z') : false,
            'Updated' => false
        ];
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $create = <pre>' . print_r($create, true) . "</pre><br>\n";exit;
        $Profile = Profile::create($create);

        return redirect('/profile')->with('status', 'User added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/profile/' . $id . '/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $off_get_data = new Profile();
        $off_get_data->find($id);

        $Profile = Profile::find($id);
        return view('profile.edit', compact('Profile', '$off_get_data') + [
                'active_list' => $this->active_list
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'UserID' => 'required|email|max:255',
        ]);

        $validator->after(function () use ($validator, $request, $id) {
            $count = Profile::where('UserID', '=', $request->input('UserID'))->where('UserID', '<>', $id)->first();
            if (!empty($count)) {
                $validator->errors()->add('UserID', 'This email field value already exists.');
            }
        });

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $request = <pre>' . print_r($request->all(), true) . "</pre><br>\n";
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $request = <pre>' . print_r($request->file(), true) . "</pre><br>\n";

        $Active = ($request->input('Active') == 'true') ? true : false;
        $Subscribe = $request->input('Subscribe');

        /** @var Profile $Profile */
        $Profile = Profile::find($id);
        $Profile->Active = $Active;
        if (!empty($request->file('Avatar'))) {
            Storage::disk('s3')->delete(str_replace($this->http_avatar, '', $Profile->Avatar));

            $Avatar = 'data/avatars/' . $Profile->UserID;
            $path = $request->file('Avatar')->store($Avatar, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');

            $Profile->Avatar = $this->http_avatar . $path;
        }
        $Profile->Contacts = $request->input('Contacts');
        $Profile->Description = $request->input('Description');
        $Profile->NickName = $request->input('NickName');
        $Profile->Subscribe = (!empty($Subscribe)) ? Carbon::parse($Subscribe)->format('Y-m-d\TH:i:s\Z') : false;
        $Profile->Updated = Carbon::now()->format('Y-m-d\TH:i:s\Z');
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $Profile-> = <pre>' . print_r($Profile->toArray(), true) . "</pre><br>\n";exit;

        $Profile->save();

        return redirect('/profile')->with('status', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Profile = Profile::find($id);
        if (!empty($Profile->Avatar)) {
            Storage::disk('s3')->delete(str_replace($this->http_avatar, '', $Profile->Avatar));
        }
        $Profile->delete();
        return response()->json(['success' => true]);
    }
}
