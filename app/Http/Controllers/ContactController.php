<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_name' => ['required', 'string', 'max:120'],
            'contact_email' => ['required', 'email', 'max:2048'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_message' => ['required', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            return $this->redirectToContact()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $recipient = $this->recipientEmail();

        if (! filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            return $this->redirectToContact()
                ->withInput()
                ->with('contact_error', 'Pesan belum dapat dikirim karena email tujuan belum diatur.');
        }

        try {
            Mail::raw($this->messageBody($validated), function ($message) use ($recipient, $validated): void {
                $message
                    ->to($recipient)
                    ->replyTo($validated['contact_email'], $validated['contact_name'])
                    ->subject('Pesan Kontak Baru - '.site_name());
            });
        } catch (Throwable $exception) {
            Log::error('Contact form email failed: '.$exception->getMessage(), [
                'recipient' => $recipient,
                'contact_email' => $validated['contact_email'],
            ]);

            return $this->redirectToContact()
                ->withInput()
                ->with('contact_error', 'Pesan belum dapat dikirim. Silakan coba lagi nanti.');
        }

        return $this->redirectToContact()
            ->with('contact_status', 'Pesan berhasil dikirim. Terima kasih sudah menghubungi kami.');
    }

    private function recipientEmail(): string
    {
        return trim((string) (
            setting('contact_form_recipient_email')
            ?: setting('contact_email')
            ?: setting('email')
        ));
    }

    private function messageBody(array $data): string
    {
        return implode(PHP_EOL, [
            'Pesan baru dari halaman kontak '.site_name(),
            '',
            'Nama: '.$data['contact_name'],
            'Email: '.$data['contact_email'],
            'Nomor Kontak: '.($data['contact_phone'] ?: '-'),
            '',
            'Pesan:',
            $data['contact_message'],
        ]);
    }

    private function redirectToContact()
    {
        $previousUrl = strtok(url()->previous(), '#') ?: route('home');

        return redirect()->to($previousUrl.'#contact');
    }
}
