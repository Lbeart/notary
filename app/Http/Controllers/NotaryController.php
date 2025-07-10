<?php

namespace App\Http\Controllers;

use App\Models\Notary;
use App\Models\City;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use ZipArchive;

class NotaryController extends Controller
{
    public function dashboard(Request $request)
    {
        $notaryId = auth()->user()->notary->id;
        $search = $request->query('search');

        $bookingsQuery = Booking::with(['user', 'serviceType'])
            ->where('notary_id', $notaryId)
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%") // SHTUAR mbiemri
                      ->orWhere('email', 'like', "%$search%");
                });
            })
            ->whereDate('selected_time', now());

        $bookings = $bookingsQuery->get();

        return view('notaries.dashboard', compact('bookings', 'search'));
    }

    public function index(Request $request)
    {
        $cities = City::all()->unique('name')->values();

        $notaries = Notary::with('user', 'city')
            ->when($request->city, function ($query, $cityId) {
                $query->where('city_id', $cityId);
            })
            ->get();

        return view('home', compact('notaries', 'cities'));
    }

    public function show($id)
    {
        $notary = Notary::with('user', 'city')->findOrFail($id);
        return view('notaries.show', compact('notary'));
    }

    public function downloadDocuments($id)
    {
        $booking = Booking::with('notary.user', 'user')->findOrFail($id);

        if (auth()->id() !== $booking->notary->user_id) {
            abort(403);
        }

        $documentFields = array_filter($booking->getAttributes(), function ($value, $key) {
            return str_ends_with($key, '_path') && $value;
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($documentFields)) {
            return back()->with('warning', 'Ky klient nuk ka ngarkuar dokumente.');
        }

        // Emri i klientit dhe data për emër të ZIP-it
        $user = $booking->user;
        $folderName = \Str::slug($user->name . '-' . $user->last_name) . '-' . now()->format('Ymd_His');
        $zipFileName = 'documents-' . $folderName . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($documentFields as $field => $path) {
                $filePath = storage_path('app/public/' . $path);
                if (file_exists($filePath)) {
                    $filename = basename($path);
                    $zip->addFile($filePath, $filename);
                }
            }
            $zip->close();
        } else {
            return back()->with('error', 'Nuk u krijua dot arkivi ZIP.');
        }

        return response()->download($zipPath)->deleteFileAfterSend();
    }
}
