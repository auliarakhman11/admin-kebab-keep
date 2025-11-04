<?php

namespace App\Http\Controllers;

use App\Models\Varian;
use Illuminate\Http\Request;

class VarianController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Varian',
            'varian' => Varian::all(),

        ];
        return view('varian.index', $data);
    }

    public function addVarian(Request $request)
    {
        $data = [
            'nm_varian' => $request->nm_varian,
        ];
        Varian::create($data);


        return redirect(route('varian'))->with('success', 'Data berhasil dibuat');
    }

    public function editVarian(Request $request)
    {
        $id = $request->id;
        $nm_varian = $request->nm_varian;


        $data = [
            'nm_varian' => $nm_varian,
        ];
        Varian::where('id', $id)->update($data);

        return redirect(route('varian'))->with('success', 'Data berhasil diedit');
    }
}
