<?php

namespace App\Http\Controllers;

use App\Models\AkunPengeluaran;
use App\Models\Cabang;
use App\Models\JenisAkunPengeluaran;
use App\Models\PersenPengeluaran;
use Illuminate\Http\Request;

class AkunPengeluaranController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Akun Pengeluaran',
            'akun' => AkunPengeluaran::with(['jenisAkun', 'persenPengeluaran'])->get(),
            'jenis_akun' => JenisAkunPengeluaran::all(),
            'cabang' => Cabang::where('off', 0)->get(),
        ];
        return view('akun.index', $data);
    }

    public function addAkun(Request $request)
    {
        AkunPengeluaran::create([
            'nm_akun' => $request->nm_akun,
            'jenis_akun_id' => $request->jenis_akun_id,
            // 'jenis_pengeluaran' => $request->jenis_pengeluaran ? $request->jenis_pengeluaran : 0,
            // 'jumlah_pengeluaran' => $request->jumlah_pengeluaran ? $request->jumlah_pengeluaran : 0,
        ]);
        return redirect(route('akunPengeluaran'))->with('success', 'Data berhasil dibuat');
    }

    public function editAkun(Request $request)
    {
        AkunPengeluaran::where('id', $request->id)->update([
            'nm_akun' => $request->nm_akun,
            'jenis_akun_id' => $request->jenis_akun_id,
        ]);

        if (isset($request->cabang_id)) {
            $cabang_id = $request->cabang_id;
            $jenis = $request->jenis;
            $jumlah = $request->jumlah;
            for ($count = 0; $count < count($cabang_id); $count++) {
                PersenPengeluaran::create([
                    'cabang_id' => $cabang_id[$count],
                    'jenis' => $jenis[$count],
                    'jumlah' => $jumlah[$count] ? $jumlah[$count] : 0,
                    'akun_id' => $request->id,
                ]);
            }
        }

        if (isset($request->persen_id)) {
            $persen_id = $request->persen_id;
            $jenis_edit = $request->jenis_edit;
            $jumlah_edit = $request->jumlah_edit;

            for ($count = 0; $count < count($persen_id); $count++) {
                PersenPengeluaran::where('id', $persen_id[$count])->update([
                    'jenis' => $jenis_edit[$count],
                    'jumlah' => $jumlah_edit[$count] ? $jumlah_edit[$count] : 0,
                ]);
            }
        }

        return redirect(route('akunPengeluaran'))->with('success', 'Data berhasil diedit');
    }
}
