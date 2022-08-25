<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function read(){
        $denda = DB::table('denda')->orderBy('id','DESC')->get();
        return view('admin.denda.index',['denda'=>$denda]);
    }

    public function add(){
        $buku = DB::table('buku')->orderBy('id','DESC')->get();
    	return view('admin.denda.tambah',['buku'=>$buku]);
    }

    public function create(Request $request){
        DB::table('denda')->insert([
            'id_peminjaman' => $request->id_peminjaman,
            'total_denda' => $request->total_denda,
            'dibayarkan' => $request->dibayarkan,
            'status' => $request->status]);

        return redirect('/admin/denda')->with("success","Data Berhasil Ditambah !");
    }

    public function edit($id){
        $denda= DB::table('denda')->where('id',$id)->first();

        $buku = DB::table('buku')->find($denda->id_buku);
        $bukuAll = DB::table('buku')->where('id','!=',$buku->id)->orderBy('id','DESC')->get();
        return view('admin.denda.edit',['denda'=>$denda,'buku'=>$buku,'bukuAll'=>$bukuAll]);
    }

    public function update(Request $request, $id) {
        DB::table('denda')
            ->where('id', $id)
            ->update([
                'id_peminjaman' => $request->id_peminjaman,
                'total_denda' => $request->total_denda,
                'dibayarkan' => $request->dibayarkan,
                'status' => $request->status]);

        return redirect('/admin/denda')->with("success","Data Berhasil Diupdate !");
    }

    public function delete($id)
    {
        $denda= DB::table('denda')->where('id',$id)->first();
        DB::table('denda')->where('id',$id)->delete();

        return redirect('/admin/denda')->with("success","Data Berhasil Didelete !");
    }
}
