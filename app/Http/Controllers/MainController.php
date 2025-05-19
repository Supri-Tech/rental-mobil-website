<?php

namespace App\Http\Controllers;

use App\Models\Car;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function main(Request $request)
    {
        // Ambil 5 data mobil dari database
        $cars = Car::where('status', 'Tersedia')->get();

        // Periksa apakah ada parameter query 'showUpdateModal'
        $showUpdateModal = $request->query('showUpdateModal', false);

        // Tampilkan view dengan variabel tambahan
        return view('pages.main.main', compact('showUpdateModal', 'cars'));
    }

    public function profile()
    {
        $showUpdateModal = false; // Default value
        return view('pages.main.profile', compact('showUpdateModal'));
    }

    public function book($id)
    {
        $showUpdateModal = false;
        $car = Car::findOrFail($id);
        return view('pages.main.booking', compact('showUpdateModal', 'car'));
    }
}
