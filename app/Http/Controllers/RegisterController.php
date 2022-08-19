<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\WablasTrait;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
            'jenis_kelamin' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);
    }
    public function store()
    {
        $kumpulan_data = [];
        $data['nis'] = request('nis');
        $data['nama'] = request('nama');
        $data['status'] = request('status');
        $data['jenis_kelamin'] = request('jenis_kelamin');
        $data['no_wa'] = request('no_wa');
        $data['alamat'] = request('alamat');
        $data['secret'] = false;
        $data['retry'] = false;
        $data['isGroup'] = false;
        array_push($kumpulan_data, $data);
        WablasTrait::sendText($kumpulan_data);
        return redirect()->back();
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
        ]);
    }

    public function index()
    {
        return view('register');
    }
}
