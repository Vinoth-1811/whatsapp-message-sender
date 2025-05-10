<?php

namespace App\Http\Controllers;

use Exception;
use Twilio\Rest\Client;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('whatsapp');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'message' => 'required'
        ]);

        $twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        // Format the phone number
        try {
            $message = $twilio->messages->create(
                'whatsapp:' . $this->formatPhoneNumber($request->phone),
                [
                    "from" => 'whatsapp:' . config('services.twilio.whatsapp_from'),
                    "body" => $request->message,
                ]
            );

            return back()->with('success', 'WhatsApp message sent successfully! ');

        } catch (\Exception $e) {
            logger()->error('Twilio WhatsApp failed', ['error' => $e]);
            return back()->with('error', $this->formatError($e));
        }
    }

    protected function formatError(\Exception $e): string
    {
        if (str_contains($e->getMessage(), 'From address')) {
            return 'Configuration error: Verify WhatsApp sandbox setup in Twilio console';
        }

        return 'Failed to send message: ' . $e->getMessage();
    }

    // Helper method to format phone numbers
    protected function formatPhoneNumber($phone)
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If number doesn't start with '+', add the country code (assuming India +91)
        if (!str_starts_with($phone, '+')) {
            // Remove leading 0 if present
            if (str_starts_with($phone, '0')) {
                $phone = substr($phone, 1);
            }
            $phone = '+91' . $phone;
        }
        return $phone;
    }
}
