<?php

namespace App\Http\Controllers;

use App\Models\CarCategory;
use Illuminate\Http\Request;

class CarCategoryController extends Controller
{
    public function kategoriDashboard()
    {
        $categories = CarCategory::all(); // Mengambil semua data kategori dari tabel car_categories
        return view('pages.admin.kategori-mobil', compact('categories')); // Kirim data ke view
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:car_categories',
            'description' => 'nullable|string',
        ]);

        CarCategory::create($request->only(['name', 'description']));
        return redirect()->route('kategori-mobil.dashboard')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, CarCategory $carCategory)
    {
        $request->validate([
            'name' => 'required|unique:car_categories,name,' . $carCategory->id,
            'description' => 'nullable|string',
        ]);

        $carCategory->update($request->only(['name', 'description']));
        return redirect()->route('kategori-mobil.dashboard')->with('success', 'Kategori berhasil diubah.');
    }

    public function destroy(CarCategory $carCategory)
    {
        $carCategory->delete();
        return redirect()->route('kategori-mobil.dashboard')->with('success', 'Kategori berhasil dihapus.');
    }
}
