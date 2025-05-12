<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function datamobilDashboard(Request $request)
    {
        $query = Car::query();
        if ($request->filled('search')) {
            $query->where('brand', 'LIKE', "%{$request->search}%")
                  ->orWhere('model', 'LIKE', "%{$request->search}%");
        }
    
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    
        $cars = $query->with('category')->get();
        $categories = CarCategory::all();

        return view('pages.admin.data-mobil', compact('cars', 'categories')); // Kirim data ke view
    }

    public function category()
    {
        return $this->belongsTo(CarCategory::class, 'category_id');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:car_categories,id',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'license_plate' => 'required|string|max:20',
            'year' => 'nullable|integer',
            'transmission' => 'nullable|in:Manual,Automatic,Semi-Automatic',
            'fuel_type' => 'nullable|in:Bensin,Diesel,Hybrid,Elektrik',
            'passenger_capacity' => 'nullable|integer',
            'base_price_per_day' => 'nullable|numeric',
            'status' => 'nullable|in:Tersedia,Diperbaiki,Tidak Aktif',
            'image_primary' => 'nullable|image|max:2048',
            'images_additional' => 'nullable|image|max:2048',
        ]);

        // Buat instance baru berdasarkan input request
        $car = new Car($request->except(['image_primary']));

        // Simpan gambar utama
        if ($request->hasFile('image_primary')) {
            $car->image_primary = $request->file('image_primary')->store('images/cars', 'public');
        }
        
        // Simpan data ke database
        $car->save();

        // Redirect dengan pesan sukses
        return redirect()->route('data-mobil.dashboard')->with('success', 'Mobil berhasil ditambahkan.');
    }

    /**
     * Update the specified car in storage.
     */
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'category_id' => 'nullable|exists:car_categories,id',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'license_plate' => 'required|string|max:20|unique:cars,license_plate,' . $car->id,
            'year' => 'nullable|integer',
            'transmission' => 'nullable|in:Manual,Automatic,Semi-Automatic',
            'fuel_type' => 'nullable|in:Bensin,Diesel,Hybrid,Elektrik',
            'passenger_capacity' => 'nullable|integer',
            'base_price_per_day' => 'nullable|numeric',
            'status' => 'nullable|in:Tersedia,Diperbaiki,Tidak Aktif',
            'image_primary' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $car->fill($request->except('image_primary'));

        if ($request->hasFile('image_primary')) {
            // Delete old image if exists
            if ($car->image_primary && Storage::disk('public')->exists($car->image_primary)) {
                Storage::disk('public')->delete($car->image_primary);
            }

            $path = $request->file('image_primary')->store('cars', 'public');
            $car->image_primary = $path;
        }

        if ($request->hasFile('images_additional')) {
            // Hapus gambar tambahan lama
            foreach ($car->additionalImages as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }
        
            // Simpan gambar tambahan baru
            foreach ($request->file('images_additional') as $file) {
                $path = $file->store('images/cars/additional', 'public');
                $car->additionalImages()->create(['image_path' => $path]);
            }
        }

        $car->save();

        return redirect()->route('data-mobil.dashboard')->with('success', 'Mobil berhasil diperbarui.');
    }

    /**
     * Remove the specified car from storage.
     */
    public function destroy(Car $car)
    {
        // Cek dan hapus gambar utama jika ada
        if ($car->image_primary && Storage::disk('public')->exists($car->image_primary)) {
            Storage::disk('public')->delete($car->image_primary);
        }

        // Hapus data mobil
        $car->delete();

        return redirect()->route('data-mobil.dashboard')->with('success', 'Mobil berhasil dihapus.');
    }

}