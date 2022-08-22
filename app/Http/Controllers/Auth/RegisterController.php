<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nis' => ['required', 'string', 'max:255'],
            'nama' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'enum', "laki-laki", "Perempuan"],
            'no_wa' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'status_akun' => ['required', 'enum', "Aktif" ,"Belum Aktif"],
        ]);
    }
      /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nis' => $data['nis'],
            'nama' => $data['nama'],
            'status' =>$data['status'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'no_wa' => $data['no_wa'],
            'alamat' => $data['alamat'],
            'status_akun' =>$data['status_akun']
        ]);
    }
}
