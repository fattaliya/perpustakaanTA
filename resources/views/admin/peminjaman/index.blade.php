@extends('admin.layouts.app', [
    'activePage' => 'master',
  ])
@section('content')
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-11">
                                    {{-- <h2 class="card-title text-primary">List Data peminjaman</h2> --}}
                                    <a href="/admin/peminjaman/print_peminjaman" class="btn btn-md btn-block btn-success"><i class="fa fa-print"></i> Print</a>
                                </div>
                                <div class="col-md-1">
                                    <a href="/admin/peminjaman/add" class="btn btn-md btn-block btn-primary"><i class="bx bx-plus"></i></a>
                                </div>
                            </div>
                          <hr>
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">List Data Peminjaman</h4>
                    <div class="table-responsive">
                      <table class="table table-striped" id="table">
                         <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>BUKU</th>
                                    <th>Nama Peminjam</th>
                                    <th>NIS</th>
                                    <th>Jumlah</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                                <?php $no = 1; ?>
                                @foreach($peminjaman as $data)
                                <?php
                                  $buku = DB::table('buku')->find($data->id_buku);
                                ?>
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$data->tanggal}}</td>
                                    <td>{{DB::table('buku')->where('id',$data->id_buku)->value('judul')}}</td>
                                    <td>{{$data->nama_siswa}}</td>
                                    <td>{{$data->nis}}</td>
                                    <td>{{$data->jumlah}}
                                  <td class="text-center">
                                        <a href="/admin/peminjaman/edit/{{$data->id}}" class="btn btn-sm btn-secondary"><i class="bx bx-pencil"></i></a>
                                         <form action="/admin/peminjaman/delete/{{$data->id}}" method="get" class="-inline" onsubmit="return confirm('Yakin anda mau menghapus')">
                                      <form method="POST"><form method="POST">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">
                                        <i class="bx bx-trash"></i>
                                        </button>
                                      </form>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
                </div>
              </div>
            </div>
@endsection
