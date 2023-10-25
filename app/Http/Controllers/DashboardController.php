<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use App\Models\TransaksiSampah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jenis_sampahs = JenisSampah::all();
        $transaksi_sampah = TransaksiSampah::with('jenis_sampah')->orderBy('id', 'desc')->limit(4)->get();
        $transaksi = TransaksiSampah::select('jenis_sampah_id', DB::raw('count(*) as total_transactions'))
            ->groupBy('jenis_sampah_id')
            ->get();

        $nama_jenis_sampah = collect($transaksi)->map(function ($transaction) {
            return ['value' => $transaction->jenis_sampah->nama];
        })->toJson();

        $jumlah_transaksi = collect($transaksi)->pluck('total_transactions')->toJson();

        return view('pages.index', [
            'type_menu' => 'dashboard', 
            'jenis_sampah' => $jenis_sampahs, 
            'transaksi_sampah' => $transaksi_sampah, 
            'nama_jenis_sampah' => $nama_jenis_sampah, 
            'jumlah_transaksi' => $jumlah_transaksi
        ]);
    }

    public function calculate_price(Request $request)
    {
        $request->validate(([
            'jenis_sampah_id' => 'required|numeric|exists:jenis_sampah,id',
            'jumlah_sampah' => 'required|numeric'
        ]));

        
        $jenis_sampah = JenisSampah::where('id', $request->get('jenis_sampah_id'))->first();
        $harga = $jenis_sampah->harga_per_kilogram * $request->get('jumlah_sampah');
        echo "Rp. ". currency($harga) .",-";
    }

    public function add_transaksi_sampah(Request $request)
    {
        $request->validate([
            'jenis_sampah_id' => 'required|numeric|exists:jenis_sampah,id',
            'jumlah_sampah' => 'required|numeric'
        ]);
        $jenis_sampah = JenisSampah::where('id', $request->get('jenis_sampah_id'))->first();
        $harga = $jenis_sampah->harga_per_kilogram * $request->get('jumlah_sampah');
        $data = [
            'jenis_sampah_id' => $request->get('jenis_sampah_id'),
            'jumlah_kilogram' => $request->get('jumlah_sampah'),    
            'total_harga' => $harga,
            'waktu_penerimaan' => Carbon::now()
        ];
        TransaksiSampah::create($data);
        return back()->with('success', 'Added successfully.');
    }
}
