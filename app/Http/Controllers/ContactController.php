<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    /* ═══════════════════════════════════════════════════════════════
       PUBLIC — simpan ke database, kembalikan data mailto:
    ═══════════════════════════════════════════════════════════════ */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'email', 'max:150'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'subject'  => ['nullable', 'string', 'max:200'],
            'message'  => ['required', 'string', 'max:5000'],
            'g-recaptcha-response' => ['required', 'string'],
        ]);

        if (! $this->verifyRecaptcha($validated['g-recaptcha-response'], $request->ip())) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi keamanan gagal. Silakan coba lagi.',
            ], 422);
        }

        $subject = $validated['subject'] ?: 'Inquiry from Website';

        $contact = ContactMessage::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'whatsapp'   => $validated['whatsapp'],
            'subject'    => $subject,
            'message'    => $validated['message'],
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
            . '?subject=' . rawurlencode($subject)
            . '&body='    . rawurlencode($bodyText);

        return response()->json([
            'success' => true,
            'message' => 'Pesan Anda tersimpan. Aplikasi email Anda akan terbuka.',
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

        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}