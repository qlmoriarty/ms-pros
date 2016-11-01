<?php

namespace App\Http\Controllers;

use App\LastId;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

class UserController extends Controller
{
    public $role_list = [
        User::ROLE_ADMIN => User::ROLE_ADMIN,
        User::ROLE_MANAGER => User::ROLE_MANAGER
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax()
    {
        $Data = User::all();

        return Datatables
            ::of($Data)
            ->addColumn('control', function ($data) {
                $control = [];

                $control[] = '<a href="' . url('/user/' . $data->UserId . '/edit') . '" class="btn btn-info btn-sm"><i class="fa fa-wrench"></i></a>';
                $control[] = '<a href="#" class="btn btn-danger btn-sm item_destroy" data-url="' . url('/user/' . $data->UserId) . '"><i class="fa fa-trash"></i></a>';
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
        return view('user.create', ['role_list' => $this->role_list]);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);

        $validator->after(function () use ($validator, $request) {
            $count = User::where('email', '=', $request->input('email'))->first();
            if (!empty($count)) {
                $validator->errors()->add('email', 'This email field value already exists.');
            }
        });

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $LastId = LastId::get(User::class);
        $User = User::create([
            'UserId' => $LastId->id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        $LastId->id++;
        $LastId->save();

        $User->remember_token = '';
        $User->role = $request->input('role');
        $User->created_at = Carbon::now()->toDateTimeString();
        $User->updated_at = Carbon::now()->toDateTimeString();

        $User->save();

        return redirect('/user')->with('status', 'User added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/user/' . $id . '/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $User = User::find((int)$id);
        return view('user.edit', compact('User') + ['role_list' => $this->role_list]);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'min:6',
        ]);

        $validator->after(function () use ($validator, $request, $id) {
            $count = User::where('email', '=', $request->input('email'))->where('id', '<>', $id)->first();
            if (!empty($count)) {
                $validator->errors()->add('email', 'This email field value already exists.');
            }
        });

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $User = User::find((int)$id);
        $User->name = $request->input('name');
        //$User->email = $request->input('email');
        if (!empty($request->input('password'))) {
            $User->password = bcrypt($request->input('password'));
        }
        $User->role = $request->input('role');
        $User->save();

        return redirect('/user')->with('status', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $User = User::find((int)$id);
        $User->delete();
        return response()->json(['success' => true]);
    }
}
