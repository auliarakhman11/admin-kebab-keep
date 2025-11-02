<?php

namespace App\Http\Controllers;

use App\Models\AkunPengeluaran;
use App\Models\Cabang;
use App\Models\EmailCabang;
use App\Models\HargaPengeluaran;
use App\Models\PenjualanGaji;
use App\Models\UserKasir;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Outlet',
            'outlet' => Cabang::select('cabang.id as id', 'cabang.persen_gaji', 'foto', 'cabang.nama', 'cabang.kota_id', 'alamat', 'map', 'event', 'no_tlpn', 'email_gojek', 'email_grab', 'email_shopee', 'time_zone', 'cabang.off')->orderBy('cabang.possition', 'ASC')->with(['hargaPengeluaran', 'emailCabang'])->get(),
            'akun' => AkunPengeluaran::where('jenis_akun_id', 5)->get(),
        ];
        return view('cabang.index', $data);
    }

    public function addOutlet(Request $request)
    {

        $data = [
            'nama' => $request->nama,
            'kota_id' => 1,
            'alamat' => $request->alamat,
            'foto' => NULL,
            'map' => $request->map,
            'event' => $request->event,
            'no_tlpn' => $request->no_tlpn,
            'time_zone' => $request->time_zone,
            'off' => $request->off,
            'possition' => 0,
            'persen_gaji' => $request->persen_gaji,
        ];
        $cabang = Cabang::create($data);

        $akun_id = $request->akun_id;
        $harga = $request->harga;

        for ($count = 0; $count < count($akun_id); $count++) {
            $harga_insert = [
                'cabang_id' => $cabang->id,
                'akun_id' => $akun_id[$count],
                'harga' => $harga[$count]
            ];
            HargaPengeluaran::create($harga_insert);
        }

        $email = $request->email;
        $password = $request->password;
        $ket = $request->ket;

        if ($email) {
            for ($count = 0; $count < count($email); $count++) {

                if ($email[$count]) {
                    $email_insert = [
                        'cabang_id' => $cabang->id,
                        'email' => $email[$count],
                        'password' => $password[$count],
                        'ket' => $ket[$count],
                    ];
                    EmailCabang::create($email_insert);
                }
            }
        }

        return redirect(route('outlet'))->with('success', 'Data berhasil dibuat');
    }

    public function editOutlet(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'map' => $request->map,
            'no_tlpn' => $request->no_tlpn,
            'kota_id' => $request->kota_id,
            'event' => $request->event,
            'persen_gaji' => $request->persen_gaji,
            // 'gapok' => $request->gapok,
            'off' => $request->off,
            'time_zone' => $request->time_zone,
        ];

        Cabang::where('id', $request->id)->update($data);



        UserKasir::where('cabang_id', $request->id)->update(['time_zone' => $request->time_zone]);

        PenjualanGaji::whereMonth('tgl', date('m'))->whereYear('tgl', date('Y'))->where('cabang_id', $request->id)->update([
            'persen_gaji' => $request->persen_gaji,
        ]);

        $email_edit = $request->email_edit;
        $password_edit = $request->password_edit;
        $ket_edit = $request->ket_edit;
        $email_id_edit = $request->email_id_edit;

        if ($email_id_edit) {
            for ($count = 0; $count < count($email_edit); $count++) {

                if ($email_edit[$count]) {
                    $dt_email_edit = [
                        'email' => $email_edit[$count],
                        'password' => $password_edit[$count],
                        'ket' => $ket_edit[$count],
                    ];
                    EmailCabang::where('id', $email_id_edit[$count])->update($dt_email_edit);
                }
            }
        }




        $email = $request->email;
        $password = $request->password;
        $ket = $request->ket;

        if ($email) {
            for ($count = 0; $count < count($email); $count++) {

                if ($email[$count]) {
                    $email_insert = [
                        'cabang_id' => $request->id,
                        'email' => $email[$count],
                        'password' => $password[$count],
                        'ket' => $ket[$count],
                    ];
                    EmailCabang::create($email_insert);
                }
            }
        }


        return redirect(route('outlet'))->with('success', 'Data berhasil diubah');
    }

    public function deleteEmailCabang($id)
    {
        EmailCabang::where('id', $id)->delete();

        return redirect(route('outlet'))->with('success', 'Data berhasil diubah');
    }

    public function editHargaPengeluaran(Request $request)
    {
        if ($request->akun_id) {
            $akun_id = $request->akun_id;
            $harga = $request->harga;

            for ($count = 0; $count < count($akun_id); $count++) {
                $harga_update = [
                    'harga' => $harga[$count]
                ];
                $cek = HargaPengeluaran::where('akun_id', $akun_id[$count])->where('cabang_id', $request->cabang_id)->first();
                if ($cek) {
                    HargaPengeluaran::where('akun_id', $akun_id[$count])->where('cabang_id', $request->cabang_id)->update($harga_update);
                } else {
                    $harga_insert = [
                        'cabang_id' => $request->cabang_id,
                        'akun_id' => $akun_id[$count],
                        'harga' => $harga[$count]
                    ];
                    HargaPengeluaran::create($harga_insert);
                }
            }
        }

        return redirect(route('outlet'))->with('success', 'Data berhasil diubah');
    }
}
