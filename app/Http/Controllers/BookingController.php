<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Bookings::with(['user', 'car'])->where('status', 'approved')->get();
        return view('pages.admin.data-mobil-booked', compact('bookings'));
    }

    public function databookingDashboard()
    {
        $bookings = Bookings::with('user', 'car')->where('status', 'pending')->get();
        return view("pages.admin.booking", compact("bookings"));
    }

    public function approve($id)
    {
        $booking = Bookings::findOrFail($id);
        $car = $booking->car;

        if (!$car->status === 'Booked') {
            return back()->with('error', 'Mobil sudah dibooking.');
        }
        $booking->status = 'approved';
        $booking->save();

        $car->status = 'Booked';
        $car->save();

        // $booking->update(['status' => 'approved']);

        return back()->with('success', 'Booking berhasil di-ACC.');
    }

    public function store(Request $request, $carId)
    {
        $request->validate([
            "pickup_latitude" => "required|numeric",
            "pickup_longitude" => "required|numeric",
            "distance" => "required|numeric",
            "day" => "required"
        ]);


        Bookings::create([
            'user_id' => auth()->id(),
            'car_id' => $carId,
            'pickup_latitude' => $request->pickup_latitude,
            'pickup_longitude' => $request->pickup_longitude,
            'distance' => $request->distance,
            'day' => $request->day,
            'status' => 'pending'
        ]);

        return redirect()->route('main')->with('success', 'Booking berhasil, menunggu konfirmasi admin.');
    }

    public function reject($id)
    {
        $booking = Bookings::findOrFail($id);

        $booking->update(['status' => 'rejected']);

        return back()->with('success', 'Booking ditolak.');
    }
}
