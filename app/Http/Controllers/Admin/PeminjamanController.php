<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\peminjaman;
use App\Buku;
use App\Data_siswa;
// use Auth;

class PeminjamanController extends Controller
{
    public function read(){
        $peminjaman = DB::table('peminjaman')->orderBy('id','DESC')->get();
        return view('admin.peminjaman.index', ['peminjaman'=>$peminjaman]);
    }

    public function add(){
        $buku = DB::table('buku')->orderBy('id','DESC')->get();
        $buku = DB::table('buku')->orderBy('id','DESC')->get();
        $data_siswa = DB::table('data_siswa')->orderBy('id','DESC')->get();
        return view('admin.peminjaman.tambah', ['buku'=>$buku,'data_siswa'=>$data_siswa]);
    }

    public function print_peminjaman()
    {
        $peminjaman = DB::table('peminjaman')->orderBy('id','DESC')->get();
        return view('admin/peminjaman/print_peminjaman', compact('peminjaman'));
    }

    public function create(Request $request)
    {

        // dd($request);die();


        $data = peminjaman::create([
            'id_siswa' => $request['id_siswa'],
            'tanggal_pinjam' =>$request['tanggal_pinjam'],
            'tanggal_kembali' => $request['tanggal_kembali'],
            'tanggal_pengembalian' => $request['tanggal_pengembalian'],
            'id_denda' => $request['id_denda'],
            'id_buku' => $request['id_buku'],
            'status_buku' => $request['status_buku'],
            'status_peminjaman' => $request['status_peminjaman'],

            // $data->save()
        ]);

            $sisa_stok = Buku::where('id',$data->id_buku)->get();
            foreach ($sisa_stok as $sisa) {
                $rest = Buku::find($sisa->id);
                $rest->where('id', $data->id_buku)
                ->update([
                    'ketersedian' => ($rest->ketersedian - 1),
                ]);

                $rest->save();
            }
        if($data){
        return redirect('/admin/peminjaman')->with("success","Data Berhasil Ditambah !");
    }
}

    public function edit($id){

        $peminjaman= DB::table('peminjaman')->where('id',$id)->first();
        $buku = DB::table('buku')->find($peminjaman->id_buku);
        $bukuAll = DB::table('buku')->where('id','!=',$buku->id)->orderBy('id','DESC')->get();

        $siswa = DB::table('data_siswa')->where('nama_siswa',$peminjaman->id)->first();
        $siswaAll = DB::table('data_siswa')->where('nama_siswa','!=',$peminjaman->id_siswa)->orderBy('nama_siswa','ASC')->get();

        return view('admin.peminjaman.edit',['peminjaman'=>$peminjaman,'buku'=>$buku,'bukuAll'=>$bukuAll,'siswa'=>$siswa,'siswaAll'=>$siswaAll]);
    }

    public function update(Request $request, $id) {


        // $data = peminjaman::update([


        //     'id_siswa' => $request['id_siswa'],
        //     'tanggal_pinjam' =>$request['tanggal_pinjam'],
        //     'tanggal_kembali' => $request['tanggal_kembali'],
        //     'tanggal_pengembalian' => $request['tanggal_pengembalian'],
        //     'id_buku' => $request['id_buku'],
        //     'status_buku' => $request['status_buku'],
        //     'status_peminjaman' => $request['status_peminjaman']

        // ]);

        // $sisa_stok = Buku::where('id',$data->id_buku)->get();
        // foreach ($sisa_stok as $sisa) {
        //     $rest = Buku::find($sisa->id);
        //     $rest->where('id', $data->id_buku)
        //     ->update([
        //         'ketersedian' => ($rest->ketersedian + 1),
        //     ]);

        //     $rest->save();
        // }
        // if($data){
        return redirect('/admin/peminjaman')->with("success","Data Berhasil Diupdate !");
    // }
}

    public function delete($id)
    {
        $peminjaman= DB::table('peminjaman')->where('id',$id)->first();
        DB::table('peminjaman')->where('id',$id)->delete();

        return redirect('/admin/peminjaman')->with("success","Data Berhasil Didelete !");
    }


    public function kembali($data)
    {
        // dd($data);die();
        // DB::table('peminjaman')
        // ->where('id', $id)
        // ->update([
        //     'tanggal_pengembalian' => date('Y-m-d'),
        // ]);

        // $post->update([
        //     'title'     => $request->title,
        //     'content'   => $request->content
        // ])->where('id',$id);
        $rest = Peminjaman::find($data);
        $buku = Buku::join('peminjaman','peminjaman.id_buku','=','buku.id')
        ->select('buku.ketersedian', 'buku.stok')->where('peminjaman.id',$data)->get();
        foreach ($buku as $book){
            $ketersediaan = $book->ketersedian;
            $stok = $book->stok;
        }
        $buku_update = Buku::join('peminjaman','peminjaman.id_buku','=','buku.id')
        ->select('buku.ketersedian', 'buku.stok')->where('peminjaman.id',$data)
        ->update([
            'buku.ketersedian' => $ketersediaan + 1 ,
            'buku.stok' => $stok + 1
        ]);
        // $update_book = $buku_update->save();
        // dd($ketersediaan);die();
        $rest->where('id', $data)
        ->update([
            'tanggal_pengembalian' =>date('Y-m-d'),
            'status_buku' => 'Aman',
            'status_peminjaman'=>'Telah Dikembalikan'
        ]);
        // $books->where()

       $restt = $rest->save();
        if($restt && $buku_update){

            return redirect('/admin/peminjaman/')->with("success","Buku Telah Di kembalikan !");
        }else{
            return redirect('/admin/peminjaman/')->with("gagal","Buku Telah Di kembalikan !");

        }


}


public function kehilangan($id){

    $peminjaman= DB::table('peminjaman')->where('id',$id)->first();
    $buku = DB::table('buku')->find($peminjaman->id_buku);
    $bukuAll = DB::table('buku')->where('id','!=',$buku->id)->orderBy('id','DESC')->get();

    $siswa = DB::table('data_siswa')->where('nama_siswa',$peminjaman->id)->first();
    $siswaAll = DB::table('data_siswa')->where('nama_siswa','!=',$peminjaman->id_siswa)->orderBy('nama_siswa','ASC')->get();

    return view('admin.peminjaman.edit',['peminjaman'=>$peminjaman,'buku'=>$buku,'bukuAll'=>$bukuAll,'siswa'=>$siswa,'siswaAll'=>$siswaAll]);
}


public function denda($id){

    $peminjaman= DB::table('peminjaman')->where('id',$id)->first();

    $buku = DB::table('buku')->find($peminjaman->id_buku);
    $bukuAll = DB::table('buku')->where('id','!=',$buku->id)->orderBy('id','DESC')->get();

    $denda = DB::table('denda')->find($peminjaman->id_denda);
    $dendaAll = DB::table('denda')->where('id','!=',$denda->id)->orderBy('id','DESC')->get();

    $siswa = DB::table('data_siswa')->where('nama_siswa',$peminjaman->id)->first();
    $siswaAll = DB::table('data_siswa')->where('nama_siswa','!=',$peminjaman->id_siswa)->orderBy('nama_siswa','ASC')->get();

    return view('admin.peminjaman.denda',['peminjaman'=>$peminjaman,'buku'=>$buku, 'denda'=>$denda,'bukuAll'=>$bukuAll,'siswa'=>$siswa,'siswaAll'=>$siswaAll, 'dendaAll'=>$dendaAll]);
}




}
