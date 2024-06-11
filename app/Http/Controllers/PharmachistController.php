<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmachistController extends Controller
{
    //
    public function dashboard()
    {
        return view('content.apoteker.dashboard');
    }
    public function showMedicines()
    {
        return view('content.apoteker.obat.index');
    }

    public function showCategories()
    {
        return view('content.apoteker.obat.kategori.index');
    }
    public function createCategory()
    {
        return view('content.apoteker.obat.kategori.create');
    }
    public function createMedicine()
    {
        return view('content.apoteker.obat.create');
    }
    public function storeMedicine(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'categories_id' => 'required'
        ]);

        DB::transaction(function () use ($request){
            Medicine::create([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'categories_id' => $request->get('categories_id')
            ]) ;

        });

        return redirect(route('medicines.show'))->with('success', 'Obat berhasil ditambahkan');
    }
}
