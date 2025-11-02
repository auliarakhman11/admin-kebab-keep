<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\JenisBahan;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BahanSatuanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Bahan',
            'bahan' => Bahan::where('aktif', 'Y')->orderBy('possition', 'ASC')->with(['satuan', 'jenisBahan'])->get(),
            'satuan' => Satuan::all(),
            'jenis_bahan' => JenisBahan::all(),
        ];
        return view('bahan.index', $data);
    }


    public function addSatuan(Request $request)
    {
        $cek = Satuan::where('satuan', $request->satuan)->first();
        if ($cek) {
            return redirect(route('bahanSatuan'))->with('error', 'Satuan sudah ada');
        } else {
            $data = [
                'satuan' => $request->satuan,
            ];
            Satuan::create($data);
            return redirect(route('bahanSatuan'))->with('success', 'Data berhasil dibuat');
        }
    }

    public function addBahan(Request $request)
    {

        $cek = Bahan::where('bahan', $request->bahan)->where('aktif', 'Y')->first();

        if ($cek) {
            return redirect(route('bahanSatuan'))->with('error', 'Bahan sudah ada');
        } else {
            $data = [
                'satuan_id' => $request->satuan_id,
                'bahan' => $request->bahan,
                'jenis_bahan_id' => $request->jenis_bahan_id,
                'possition' => 0,
            ];
            $bahan = Bahan::create($data);


            return redirect(route('bahanSatuan'))->with('success', 'Data berhasil dibuat');
        }
    }

    public function editBahan(Request $request)
    {
        $data = [
            'satuan_id' => $request->satuan_id,
            'bahan' => $request->bahan,
            'jenis_bahan_id' => $request->jenis_bahan_id,
        ];
        Bahan::where('id', $request->id)->update($data);


        return redirect(route('bahanSatuan'))->with('success', 'Data berhasil diubah');
    }

    public function editSatuan(Request $request)
    {
        $data = [
            'satuan' => $request->satuan,
        ];
        Satuan::where('id', $request->id)->update($data);
        return redirect(route('bahanSatuan'))->with('success', 'Data berhasil diubah');
    }

    public function dropDataBahan(Request $request)
    {
        $data = [
            'aktif' => 'T'
        ];

        Bahan::where('id', $request->id)->update($data);
        return redirect(route('bahanSatuan'))->with('success', 'Data berhasil dihapus');
    }
}
