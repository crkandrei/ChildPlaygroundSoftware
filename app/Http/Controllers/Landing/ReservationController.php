<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\BirthdayReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display the reservation form
     */
    public function show()
    {
        return view('landing.reservation', [
            'metaTitle' => 'Rezervare Zi de Naștere - Bongoland Vaslui',
            'metaDescription' => 'Rezervă o zi de naștere memorabilă la Bongoland Vaslui. Oferim pachete speciale pentru zile de naștere copii.',
            'metaKeywords' => 'rezervare zi de naștere Vaslui, zi de naștere copii Vaslui, pachet zi de naștere',
        ]);
    }

    /**
     * Store a new reservation
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'child_name' => 'required|string|max:255',
            'parent_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'birthday_date' => 'required|date|after:today',
            'number_of_children' => 'required|integer|min:1|max:50',
            'message' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('landing.reservation')
                ->withErrors($validator)
                ->withInput();
        }

        // Check if date is available
        $requestedDate = Carbon::parse($request->birthday_date);
        $existingReservation = BirthdayReservation::whereDate('reservation_date', $requestedDate)
            ->first();

        if ($existingReservation) {
            return redirect()
                ->route('landing.reservation')
                ->with('error', 'Data selectată nu este disponibilă. Te rugăm să alegi altă dată.')
                ->withInput();
        }

        // Get default tenant (first tenant) or create without tenant for landing page submissions
        $defaultTenant = \App\Models\Tenant::first();

        // Get a system user or first admin user for landing page submissions
        $systemUser = \App\Models\User::whereHas('role', function ($query) {
            $query->where('name', 'SUPER_ADMIN');
        })->first();

        BirthdayReservation::create([
            'tenant_id' => $defaultTenant?->id,
            'child_name' => $request->child_name,
            'guardian_phone' => $request->phone,
            'reservation_date' => $requestedDate,
            'reservation_time' => '14:00:00', // Default time
            'number_of_children' => $request->number_of_children,
            'notes' => "Email: {$request->email}\nPărinte: {$request->parent_name}\n" . ($request->message ?? ''),
            'created_by' => $systemUser?->id ?? 1, // Use system user or fallback to ID 1
        ]);

        return redirect()
            ->route('landing.reservation')
            ->with('success', 'Rezervarea ta a fost trimisă cu succes! Vom reveni în cel mai scurt timp pentru confirmare.');
    }
}

