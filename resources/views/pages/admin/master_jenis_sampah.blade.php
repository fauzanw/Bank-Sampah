@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Master Jenis Sampah</h1>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                    <div class="card">
                        <div class="card-body">
                            @if (sizeof($jenis_sampah) > 0)
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Harga / Kilogram</th>
                                            <th>Deskripsi</th>
                                            <th>Foto</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($jenis_sampah as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $data->nama }}</td>
                                                <td>Rp. {{ currency($data->harga_per_kilogram) }},-</td>
                                                <td>{{ $data->deskripsi }}</td>
                                                <td>
                                                    <img src="{{ asset("storage/{$data->foto}") }}" class="img-fluid">
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.master_jenis_sampah.delete', $data->id) }}" class="badge badge-danger" onclick="return confirm('Are you sure want to delete this item?')">Hapus</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center">
                                    <img src="{{ asset('img/no_jenis_sampah.svg') }}" width="60%" class="img-fluid">
                                    <p class="mt-3">Belum ada jenis sampah yang dibuat!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.master_jenis_sampah.add') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="nama">
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <input type="file" name="foto" id="foto" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="harga_per_kilogram">Harga Per Kilogram</label>
                                    <input type="text" class="form-control" name="harga_per_kilogram">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Tambah Jenis Sampah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection