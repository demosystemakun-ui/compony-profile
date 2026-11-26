<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'     => ['required', 'string', 'min:2', 'max:150', 'regex:/^[\p{L}\s.\'-]+$/u'],
                'email'    => ['required', 'email', 'max:150'],
                'whatsapp' => ['required', 'string', 'min:7', 'max:30', 'regex:/^[0-9+\-()\s]+$/'],
                'subject'  => ['nullable', 'string', 'max:200'],
                'message'  => ['required', 'string', 'min:10', 'max:5000'],
                'g-recaptcha-response' => ['required', 'string'],
            ], [
                'name.regex'     => 'Full name may only contain letters, spaces, periods, apostrophes, and hyphens.',
                'whatsapp.regex' => 'Phone / WhatsApp number may only contain digits, spaces, and +, -, (, ).',
                'message.min'    => 'Please enter a message of at least 10 characters.',
            ]);
        } catch (ValidationException $e) {
            $firstError = collect($e->errors())->flatten()->first() ?? 'Please check your input and try again.';

            return response()->json([
                'success' => false,
                'message' => $firstError,
                'errors'  => $e->errors(),
            ], 422);
        }

        $digitsOnly = preg_replace('/\D/', '', $validated['whatsapp']);
        if (strlen($digitsOnly) < 7 || strlen($digitsOnly) > 15) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid WhatsApp or office phone number (7–15 digits).',
            ], 422);
        }

        if (! $this->verifyRecaptcha($validated['g-recaptcha-response'], $request->ip())) {
            return response()->json([
                'success' => false,
                'message' => 'Security verification failed. Please try again.',
            ], 422);
        }

        $cleanName    = preg_replace('/\s+/', ' ', trim($validated['name']));
        $cleanSubject = isset($validated['subject']) && trim($validated['subject']) !== ''
            ? trim($validated['subject'])
            : 'Inquiry from Website';
        $cleanMessage = trim($validated['message']);

        $contact = ContactMessage::create([
            'name'       => $cleanName,
            'email'      => trim($validated['email']),
            'whatsapp'   => trim($validated['whatsapp']),
            'subject'    => $cleanSubject,
            'message'    => $cleanMessage,
            'ip_address' => $request->ip(),
        ]);

        // Siapkan mailto: untuk aplikasi email user
        $targetEmail = 'info@pict.co.id';

        $bodyText = implode("\r\n", [
            "Name: {$contact->name}",
            "Email: {$contact->email}",
            "Phone / WhatsApp: {$contact->whatsapp}",
            "",
            "Message:",
            $contact->message,
        ]);

        $mailtoUrl = 'mailto:' . $targetEmail
            . '?subject=' . rawurlencode($cleanSubject)
            . '&body='    . rawurlencode($bodyText);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been saved. Your email application will open.',
            'mailto'  => $mailtoUrl,
        ]);
    }

    private function verifyRecaptcha(string $token, ?string $ip): bool
    {
        $secret = config('services.recaptcha.secret_key');
        if (! $secret) {
            return true; // dev fallback
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => $secret,
            'response' => $token,
            'remoteip' => $ip,
        ]);

        return (bool) ($response->json('success') ?? false);
    }

    /* ═══════════════════════════════════════════════════════════════
       ADMIN — list, detail, mark read, delete
    ═══════════════════════════════════════════════════════════════ */

    public function adminIndex(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('subject', 'like', "%{$q}%");
            });
        }

        $messages    = $query->latest()->paginate(15)->withQueryString();
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('admin.contact-messages.index', compact('messages', 'unreadCount'));
    }

    public function adminShow(ContactMessage $contactMessage)
    {
        if (! $contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('admin.contact-messages.show', compact('contactMessage', 'unreadCount'));
    }

    public function markRead(ContactMessage $contactMessage)
    {
        $contactMessage->update(['is_read' => true]);

        return back()->with('success', 'Message marked as read.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}