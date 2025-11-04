<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\UserKasir;
use Illuminate\Http\Request;

class UserKasirController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'User Kasir',
            'user_kasir' => UserKasir::with('cabang')->get(),
            'outlet' => Cabang::all()
        ];
        return view('user_kasir.index', $data);
    }

    public function addUser()
    {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users_kasir'],
            'password' => ['required', 'string', 'confirmed']
        ]);

        $cabang = Cabang::where('id', request('cabang_id'))->first();
        UserKasir::create([
            'name' => request('name'),
            'username' => request('username'),
            'password' => bcrypt(request('password')),
            'cabang_id' => request('cabang_id'),
            'time_zone' => $cabang->time_zone,
        ]);
        return redirect()->back()->with('success', 'Data user berhasil dibuat');
    }

    public function editPasswordKasir(Request $request)
    {
        if ($request->password) {

            UserKasir::where('id', $request->id)->update([
                'password' => bcrypt($request->password),
            ]);

            return redirect()->back()->with('success', 'Data password berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Password harus diisi');
        }
    }
}
