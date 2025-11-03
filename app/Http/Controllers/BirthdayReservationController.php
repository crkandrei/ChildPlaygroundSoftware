<?php

namespace App\Http\Controllers;

use App\Models\BirthdayReservation;
use App\Support\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BirthdayReservationController extends Controller
{
    /**
     * Check if user is super admin
     */
    private function checkSuperAdmin()
    {
        $user = Auth::user();
        if (!$user || !$user->isSuperAdmin()) {
            abort(403, 'Acces permis doar pentru super admin');
        }
    }

    /**
     * Display the calendar page
     */
    public function index()
    {
        $this->checkSuperAdmin();
        return view('birthday-reservations.index');
    }

    /**
     * Get calendar events for FullCalendar
     */
    public function calendar(Request $request)
    {
        $this->checkSuperAdmin();

        $start = $request->input('start');
        $end = $request->input('end');

        $query = BirthdayReservation::query();

        if ($start) {
            $query->where('reservation_date', '>=', $start);
        }
        if ($end) {
            $query->where('reservation_date', '<=', $end);
        }

        $reservations = $query->orderBy('reservation_date')
            ->orderBy('reservation_time')
            ->get();

        $events = $reservations->map(function ($reservation) {
            // Combine date and time for FullCalendar
            // reservation_time is stored as 'H:i:s' format
            $timeStr = $reservation->reservation_time;
            if (strlen($timeStr) > 5) {
                $timeStr = substr($timeStr, 0, 5); // Keep only HH:MM
            }
            $datetime = $reservation->reservation_date->format('Y-m-d') . 'T' . $timeStr . ':00';
            
            return [
                'id' => $reservation->id,
                'title' => $reservation->child_name . ' - ' . $reservation->guardian_phone,
                'start' => $datetime,
                'allDay' => false,
                'extendedProps' => [
                    'child_name' => $reservation->child_name,
                    'guardian_phone' => $reservation->guardian_phone,
                    'number_of_children' => $reservation->number_of_children,
                    'notes' => $reservation->notes,
                    'reservation_date' => $reservation->reservation_date->format('Y-m-d'),
                    'reservation_time' => $timeStr,
                ],
            ];
        });

        return ApiResponder::success(['events' => $events->toArray()]);
    }

    /**
     * Store a newly created reservation
     */
    public function store(Request $request)
    {
        $this->checkSuperAdmin();

        $request->validate([
            'child_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required|date_format:H:i',
            'number_of_children' => 'required|integer|min:1|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $reservation = BirthdayReservation::create([
                'tenant_id' => Auth::user()->tenant_id, // nullable pentru super admin
                'child_name' => $request->child_name,
                'guardian_phone' => $request->guardian_phone,
                'reservation_date' => $request->reservation_date,
                'reservation_time' => $request->reservation_time,
                'number_of_children' => $request->number_of_children,
                'notes' => $request->notes,
                'created_by' => Auth::id(),
            ]);

            return ApiResponder::success([
                'message' => 'Rezervarea a fost creată cu succes',
                'reservation' => $reservation->toArray(),
            ]);
        } catch (\Exception $e) {
            return ApiResponder::error('Eroare la crearea rezervării: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update an existing reservation
     */
    public function update(Request $request, $id)
    {
        $this->checkSuperAdmin();

        $reservation = BirthdayReservation::findOrFail($id);

        $request->validate([
            'child_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required|date_format:H:i',
            'number_of_children' => 'required|integer|min:1|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $reservation->update([
                'child_name' => $request->child_name,
                'guardian_phone' => $request->guardian_phone,
                'reservation_date' => $request->reservation_date,
                'reservation_time' => $request->reservation_time,
                'number_of_children' => $request->number_of_children,
                'notes' => $request->notes,
            ]);

            return ApiResponder::success([
                'message' => 'Rezervarea a fost actualizată cu succes',
                'reservation' => $reservation->fresh()->toArray(),
            ]);
        } catch (\Exception $e) {
            return ApiResponder::error('Eroare la actualizarea rezervării: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete a reservation
     */
    public function destroy($id)
    {
        $this->checkSuperAdmin();

        try {
            $reservation = BirthdayReservation::findOrFail($id);
            $reservation->delete();

            return ApiResponder::success([
                'message' => 'Rezervarea a fost ștearsă cu succes',
            ]);
        } catch (\Exception $e) {
            return ApiResponder::error('Eroare la ștergerea rezervării: ' . $e->getMessage(), 500);
        }
    }
}