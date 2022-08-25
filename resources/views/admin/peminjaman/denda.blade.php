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
                                    <h2 class="card-title text-primary">Edit Denda</h2>
                                </div>
                                <div class="col-md-1">
                                    <a href="/admin/peminjaman" class="btn btn-md btn-block btn-primary"><i class="bx bx-left-arrow-alt"></i></a>
                                </div>
                            </div>
                          <hr>
                          <form action="/admin/denda/update/{{$denda->id}}" method="POST">
                                @csrf

                                <div class="form-group mb-3">
                                    <label>Nama Peminjam</label>
                                    <select class="form-control" name="id_peminjaman" required>
                                    <option value="">-- Pilih Siswa --</option>
                                     @foreach(\DB::table('data_siswa')->get() as $data)
                                      <option value="{{$data->id}}">{{$data->nama_siswa}}</option>
                                      @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Total Denda</label>
                                    <input type="text" name="" class="total_denda" place_holder="Masukan Judul peminjaman...." value="{{$denda->total_denda}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Dibayarkan/label>
                                    <input type="text" name="dibayarkan" class="form-control" place_holder="Masukan Judul peminjaman...." value="{{$denda->dibayarkan}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label>status</label>
                                    <input type="text" name="status" class="form-control" place_holder="Masukan Judul peminjaman...." value="{{$denda->status}}">
                                </div>

                                <br>
                                <button class="btn btn-success" type="submit">Update Data</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection
