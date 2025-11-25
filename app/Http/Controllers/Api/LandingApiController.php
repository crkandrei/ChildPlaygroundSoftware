<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use App\Models\BirthdayReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LandingApiController extends Controller
{
    /**
     * Store contact form submission
     */
    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        ContactForm::create([
            'name' => $request->parent_name,
            'email' => 'N/A',
            'phone' => $request->phone,
            'subject' => 'Cerere de la landing page',
            'message' => $request->message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mesajul a fost trimis cu succes!',
        ]);
    }

    /**
     * Store party booking submission
     */
    public function reservation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'child_age' => 'required|integer|min:1|max:18',
            'birthday_date' => 'required|date|after:today',
            'number_of_children' => 'required|integer|min:1|max:50',
            'package' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if date is available
        $requestedDate = Carbon::parse($request->birthday_date);
        $existingReservation = BirthdayReservation::whereDate('reservation_date', $requestedDate)
            ->first();

        if ($existingReservation) {
            return response()->json([
                'success' => false,
                'message' => 'Data selectată nu este disponibilă. Te rugăm să alegi altă dată.',
            ], 409);
        }

        // Get default tenant (first tenant) or create without tenant for landing page submissions
        $defaultTenant = \App\Models\Tenant::first();

        // Get a system user or first admin user for landing page submissions
        $systemUser = \App\Models\User::whereHas('role', function ($query) {
            $query->where('name', 'SUPER_ADMIN');
        })->first();

        $notes = "Email: N/A\nPărinte: {$request->parent_name}\nVârsta copil: {$request->child_age} ani\nPachet: {$request->package}\n" . ($request->message ?? '');

        BirthdayReservation::create([
            'tenant_id' => $defaultTenant?->id,
            'child_name' => 'N/A', // Will be filled later
            'guardian_phone' => $request->phone,
            'reservation_date' => $requestedDate,
            'reservation_time' => '14:00:00', // Default time
            'number_of_children' => $request->number_of_children,
            'notes' => $notes,
            'created_by' => $systemUser?->id ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cererea a fost trimisă cu succes! Te contactăm pentru detalii în maxim 24h.',
        ]);
    }
}

