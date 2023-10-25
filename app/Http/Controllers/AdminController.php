<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use App\Models\TransaksiSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
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

        return view('pages.admin.index', [
            'type_menu' => 'dashboard', 
            'jenis_sampah' => $jenis_sampahs, 
            'transaksi_sampah' => $transaksi_sampah, 
            'nama_jenis_sampah' => $nama_jenis_sampah, 
            'jumlah_transaksi' => $jumlah_transaksi
        ]);
    }

    public function master_jenis_sampah()
    {
        $jenis_sampah = JenisSampah::orderBy('id', 'desc')->get();
        return view('pages.admin.master_jenis_sampah', compact('jenis_sampah'));
    }

    public function add_master_jenis_sampah(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpg,jpeg,png',
            'harga_per_kilogram' => 'required|numeric'
        ]);

        $data['foto'] = $request->file('foto')->store('foto_sampah');
        JenisSampah::create($data);
        return back()->with('success', 'Added successfully');
    }

    public function delete_master_jenis_sampah(JenisSampah $id)
    {
        $id->delete();
        return back()->with('success', 'Successfully deleted');
    }
}
