<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\peminjaman;
use App\Buku;
use Auth;

class PeminjamanController extends Controller
{
    public function read(){
        $peminjaman = DB::table('peminjaman')->orderBy('id','DESC')->get();
        return view('admin.peminjaman.index', ['peminjaman'=>$peminjaman]);
    }

    public function add(){
        $buku = DB::table('buku')->orderBy('id','DESC')->get();
        $siswa = DB::table('data_siswa')->orderBy('nama_siswa','ASC')->get();
        return view('admin.peminjaman.tambah', ['buku'=>$buku,'siswa'=>$siswa]);
    }

    public function print_peminjaman()
    {
        $peminjaman = DB::table('peminjaman')->orderBy('id','DESC')->get();
        return view('admin/peminjaman/print_peminjaman', compact('peminjaman'));
    }

    public function create(Request $request)
    {
        

        $data = new peminjaman();
        $data->nama_siswa = $request->nama_siswa;
        $data->tanggal = $request->tanggal;
        $data->id_buku = $request->id_buku;
        $data->jumlah = $request->jumlah;
        $data->nis = $request->nis;

        $data->save();



            $sisa_stok = Buku::where('id',$data->id_buku)->get();
            foreach ($sisa_stok as $sisa) {
                $rest = Buku::find($sisa->id);
                $rest->where('id', $data->id_buku)
                ->update([
                    'stok' => ($rest->stok - $data->jumlah),
                ]);

                $rest->save();
            }

        return redirect('/admin/peminjaman')->with("success","Data Berhasil Ditambah !");
    }

    public function edit($id){
        $peminjaman= DB::table('peminjaman')->where('id',$id)->first();
        $buku = DB::table('buku')->find($peminjaman->id_buku);
        $bukuAll = DB::table('buku')->where('id','!=',$buku->id)->orderBy('id','DESC')->get();

        $siswa = DB::table('data_siswa')->where('nis',$peminjaman->nis)->first();
        $siswaAll = DB::table('data_siswa')->where('nis','!=',$peminjaman->nama_siswa)->orderBy('nama_siswa','ASC')->get();

        return view('admin.peminjaman.edit',['peminjaman'=>$peminjaman,'buku'=>$buku,'bukuAll'=>$bukuAll,'siswa'=>$siswa,'siswaAll'=>$siswaAll]);
    }

    public function update(Request $request, $id) {
        DB::table('peminjaman')
            ->where('id', $id)
            ->update([
            'nama_siswa' => $request->nama_siswa,
            'tanggal' => $request->tanggal,
            //'judul' => $request->judul,
            'id_buku' => $request->id_buku,
            'jumlah' => $request->jumlah,
            'nis' => $request->nis]);

        return redirect('/admin/peminjaman')->with("success","Data Berhasil Diupdate !");
    }

    public function delete($id)
    {
        $peminjaman= DB::table('peminjaman')->where('id',$id)->first();
        DB::table('peminjaman')->where('id',$id)->delete();

        return redirect('/admin/peminjaman')->with("success","Data Berhasil Didelete !");
    }
}
