@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="d-inline">Transaksi sampah</h4>
                        </div>
                        <div class="card-body">
                            @if (sizeof($transaksi_sampah) > 0)
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ($transaksi_sampah as $data_transaksi)
                                <li class="media">
                                    <img class="rounded-circle mr-3"
                                        width="50"
                                        src="{{ asset("storage/{$data_transaksi->jenis_sampah->foto}") }}"
                                        alt="avatar">
                                    @php
                                    $waktuSekarang = \Carbon\Carbon::now();
                                    $selisih = $waktuSekarang->diffForHumans($data_transaksi->waktu_penerimaan);
                                    @endphp
                                    <div class="media-body">
                                        <div class="badge badge-pill badge-danger float-right mb-1">Rp. {{ currency($data_transaksi->total_harga) }},-</div>
                                        <h6 class="media-title"><a href="#">{{ $data_transaksi->jenis_sampah->nama }}</a></h6>
                                        <div class="text-small text-muted">{{ currency($data_transaksi->jumlah_kilogram) }} Kg<div class="bullet"></div>
                                            <span class="text-primary">{{ $selisih }}</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @else
                                <div class="text-center">
                                    <img src="{{ asset('img/no_sampah.svg') }}" width="60%" class="img-fluid">
                                    <p class="mt-3">Belum ada transaksi sampah di sini!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="d-inline">Kalkulator sampah</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dashboard.transaksi_sampah.add') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Jenis Sampah</label>
                                    <select class="form-control select2" name="jenis_sampah_id" id="jenis_sampah_id">
                                        @foreach ($jenis_sampah as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Sampah (kilogram)</label>
                                    <input type="number" class="form-control @error('jumlah_sampah') is-invalid @enderror" name="jumlah_sampah" required id="jumlah_sampah">
                                </div>
                                <div class="row justify-content-between mx-1 d-none" id="total_harga_section">
                                    <p>Total Harga</p>
                                    <p id="total_harga"></p>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" id="btn_calculate_submit">Hitung harga sampah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Trend Sampah Terbanyak</h4>
                </div>
                <div class="card-body">
                    <div class="card">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        let btn_calculate_submit = $('#btn_calculate_submit');
        btn_calculate_submit.on('click', function(e) {
            if(!btn_calculate_submit.attr('type')) {
                e.preventDefault();
                if(!$('#jumlah_sampah').val()) {
                    return;
                }
                $(this).addClass(['btn-progress', 'disabled'])
                $.ajax({
                    url: '{{ route("dashboard.calculate_price") }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        jenis_sampah_id: $('#jenis_sampah_id').val(), 
                        jumlah_sampah: $('#jumlah_sampah').val()
                    },
                    method: 'POST',
                    success: function(response) {
                        btn_calculate_submit.removeClass(['btn-progress', 'disabled']);
                        $('#total_harga_section').removeClass('d-none')
                        $('#total_harga').html(response);
                        btn_calculate_submit.html('Setor sampah');
                        btn_calculate_submit.attr('type', 'submit');
                    }
                })
            }
        })

        var ctx = document.getElementById("myChart").getContext('2d');
        let nama_jenis_sampah = '{{!! $nama_jenis_sampah !!}}'
        var dataArray = nama_jenis_sampah.slice(2, -2);
        var labels = JSON.parse('[' + dataArray + ']').map(data => data.value);
        var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
            label: 'Jumlah Sampah',
            data: {{ $jumlah_transaksi }},
            borderWidth: 2,
            backgroundColor: '#6777ef',
            borderColor: '#6777ef',
            borderWidth: 2.5,
            pointBackgroundColor: '#ffffff',
            pointRadius: 4
            }]
        },
        options: {
            legend: {
            display: false
            },
            scales: {
            yAxes: [{
                gridLines: {
                drawBorder: false,
                color: '#f2f2f2',
                },
                ticks: {
                beginAtZero: true,
                stepSize: 25
                }
            }],
            xAxes: [{
                ticks: {
                display: false
                },
                gridLines: {
                display: false
                }
            }]
            },
        }
        });
    </script>
@endpush
