<?php

namespace App\Http\Controllers\Auth;

use App\LastId;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        $validator->after(function () use ($validator, $data) {
            $count = User::where('email', '=', $data['email'])->first();
            //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $count = <pre>' . print_r($count, true) . "</pre><br>\n";exit;
            if (!empty($count)) {
                $validator->errors()->add('email', 'Такое значение поля email уже существует.');
            }
        });

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $LastId = LastId::get(User::class);

        $User = User::create([
            'UserId' => $LastId->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $LastId->id++;
        $LastId->save();

        $User->remember_token = '';
        $User->role = User::ROLE_MANAGER;
        $User->created_at = Carbon::now()->toDateTimeString();
        $User->updated_at = Carbon::now()->toDateTimeString();

        $User->save();

        return $User;
    }
}
