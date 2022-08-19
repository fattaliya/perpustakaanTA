<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\WablasTrait;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;

class DataSiswaController extends Controller
{
    public function read(){
        $data_siswa = DB::table('data_siswa')->orderBy('id','DESC')->paginate(10);


        return view('admin.data_siswa.index',['data_siswa'=>$data_siswa]);
    }

    public function index()
    {
        return view('form_send');
    }

    public function add(){
        $kelas = DB::table('kelas')->orderBy('id','DESC')->get();
    	return view('admin.data_siswa.tambah',['kelas'=>$kelas]);
    }

    public function cari(Request $request)
	{
		// menangkap data pencarian
		$cari = $request->cari;


		$data_siswa = DB::table('data_siswa')
		->where('nama_siswa','like',"%".$cari."%")
		->paginate();


		return view('admin.data_siswa.index',['data_siswa' => $data_siswa]);

	}

    public function print_data_anggota()
    {
        $data_siswa = DB::table('data_siswa')->orderBy('id','DESC')->get();
        return view('admin/data_siswa/print_data_anggota', compact('data_siswa'));
    }

    public function detail ($nis){
        $data_siswa = DB::table('data_siswa')->where('nis',$nis)->first();
    	return view('admin.data_siswa.detail',['data_siswa'=>$data_siswa]);
    }


    public function create(Request $request){



        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
                $name = time() . '.' . $foto->extension();
                $foto->move(public_path().'/foto/', $name);
        }else{
            $name = 'tidak ada file.png';
        }
        DB::table('data_siswa')->insert([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            // 'id_kelas' => $request->id_kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status' => $request->status,
            'status_akun' =>"Belum Aktif",
            'foto' => $name

        ]);

        return redirect('/admin/data_siswa')->with("success","Data Berhasil Ditambah !");
    }


    public function print_data_siswa()
    {
        $peminjaman = DB::table('data_siswa')->orderBy('id','DESC')->get();
        return view('admin.data_siswa.detail.print_data_siswa',['data_siswa'=>$data_siswa]);
    }


    public function edit($id){
        $data_siswa= DB::table('data_siswa')->where('id',$id)->first();

        $kelas = DB::table('kelas')->find($data_siswa->id_kelas);
        $kelasAll = DB::table('kelas')->where('id','!=',$kelas->id)->orderBy('id','DESC')->get();
        return view('admin.data_siswa.edit',['data_siswa'=>$data_siswa,'kelas'=>$kelas,'kelasAll'=>$kelasAll]);
    }

    public function update(Request $request, $id) {

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
                $name = time() . '.' . $foto->extension();
                $foto->move(public_path().'/foto/', $name);
        }else{
            $name = 'tidak ada file.png';
        }
        DB::table('data_siswa')
            ->where('id', $id)
            ->update([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            // 'id_kelas' => $request->id_kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_wa' =>$request->no_wa,
            'status' => $request->status,
            'status_akun' =>"Belum Aktif",
            'foto' => $name
        ]);
        return redirect('/admin/data_siswa')->with("success","Data Berhasil Diupdate !");
    }

    public function delete($id)
    {
        $data_siswa= DB::table('data_siswa')->where('id',$id)->first();
        DB::table('data_siswa')->where('id',$id)->delete();

        return redirect('/admin/data_siswa')->with("success","Data Berhasil Didelete !");
    }

    // public function konfirmasi($id)
    // {
    //     $data_siswa= DB::table('data_siswa')->where('id',$id)->first();
    //     DB::table('data_siswa')->where('id',$id)->konfirmasi();

    //     return redirect('/admin/data_siswa')->with("success","konfirmasi !");
    // }


}
