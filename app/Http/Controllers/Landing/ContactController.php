<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display the contact form
     */
    public function show()
    {
        return view('landing.contact', [
            'metaTitle' => 'Contact - Bongoland Vaslui',
            'metaDescription' => 'Contactează-ne la Bongoland Vaslui. Suntem aici să răspundem la întrebările tale despre serviciile noastre.',
            'metaKeywords' => 'contact Bongoland, loc de joacă Vaslui contact',
        ]);
    }

    /**
     * Store a new contact form submission
     */
    public function store(Request $request)
    {
        // Handle both old form format and new landing page format
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'parent_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'child_name' => 'nullable|string|max:255',
            'child_age' => 'nullable|integer|min:1|max:18',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->to(url()->previous() . '#contact')
                ->withErrors($validator)
                ->withInput();
        }

        // Build message with all information
        $fullMessage = $request->message;
        if ($request->child_name) {
            $fullMessage = "Copil: {$request->child_name}" . ($request->child_age ? " (vârstă: {$request->child_age} ani)" : '') . "\n\n" . $fullMessage;
        }
        if ($request->parent_name) {
            $fullMessage = "Părinte: {$request->parent_name}\n" . $fullMessage;
        }

        ContactForm::create([
            'name' => $request->parent_name ?? $request->name ?? 'N/A',
            'email' => $request->email ?? 'N/A',
            'phone' => $request->phone,
            'subject' => $request->subject ?? 'Cerere de la landing page',
            'message' => $fullMessage,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->to(url()->previous() . '#contact')
            ->with('success', 'Cererea ta a fost trimisă cu succes! Vom reveni în cel mai scurt timp.');
    }
}

