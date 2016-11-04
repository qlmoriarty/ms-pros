<?php

namespace App\Http\Controllers;

use App\Constant\UniversalConstant;
use App\LastId;
use App\Message;
use App\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Traits\CapsuleManagerTrait;
use Yajra\Datatables\Facades\Datatables;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('message.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax()
    {
        $MessageUnreadProfileIDs = [];
        $MessageUnread = Message::where('To', 'Users:' . Auth::id())->where('Readed', false)->get();
        foreach ($MessageUnread as $MessageUnread_) {
            $MessageUnreadProfileIDs[] = str_replace('Profiles:', '', $MessageUnread_->From);
        }

        $Data = Profile::all();

        return Datatables
            ::of($Data)
            ->editColumn('Avatar', function ($data) {
                if (empty($data->Avatar)) {
                    return '';
                } else {
                    return '<img src="' . $data->Avatar . '" style="max-width: 100px;max-height: 100px;">';
                }
            })
            ->addColumn('MessageUnReaded', function ($data) use ($MessageUnreadProfileIDs) {
                return (in_array($data->UserID, $MessageUnreadProfileIDs)) ? UniversalConstant::TITLE_YES : UniversalConstant::TITLE_NO;
            })
            ->addColumn('control', function ($data) {
                $control = [];

                $control[] = '<a href="' . url('/message/' . $data->UserID . '/') . '" class="btn btn-info btn-sm"> Chat</a>';
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
        return redirect('/message');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect('/message');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Message = Message::get($id);
        $From = Auth::user();
        $To = Profile::find($id);

        return view('message.show', compact('Message', 'From', 'To'));
    }

    public function show_message(Request $request, $id)
    {
        $Message = Message::get($id, $request->input('direction'), $request->input('last_time'));
        $From = Auth::user();
        $To = Profile::find($id);

        return response()->json([
            'last_time' => $Message['last_time'],
            'html' => view('message.show_message', compact('Message', 'From', 'To'))->render()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect('/message/' . $id);
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
        $this->validate($request, [
            'message' => 'required',
        ]);

        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $request = <pre>' . print_r($request->all(), true) . "</pre><br>\n";

        $Message = Message::create([
            'MesID' => uniqid('From_To_'),
            'From' => 'Users:' . Auth::id(),
            'To' => 'Profiles:' . $id,
            //
            'DateAdd' => Carbon::now()->timestamp,
//            'DateAdd' => Carbon::now()->format('Y-m-d H:i:s')->timestamp,
            'Text' => $request->input('message'),
            'Readed' => false
        ]);
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $Message = <pre>' . print_r($Message->toArray(), true) . "</pre><br>\n";

        return response()->json(['success' => true]);
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
