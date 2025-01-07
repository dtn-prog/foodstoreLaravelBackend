<?php

namespace App\Http\Controllers\Api;

use \Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP in the user's pin field
        $user->pin = $otp;
        $user->save();

        // Send OTP via SMS
        $this->sendSms($user->phone, $otp);

        return response()->json(['message' => 'OTP sent successfully.']);
    }

    public function verifyOtp(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'otp' => 'required|string',
        ]);

        $otp = $request->input('otp');

        if ($user->pin == $otp) {
            $user->pin = null;
            $user->phone_verified_at = now();
            $user->save();

            return response()->json(['message' => 'OTP verified successfully.']);
        }

        return response()->json(['message' => 'Invalid OTP.'], 400);
    }

    private function sendSms($phone, $otp)
    {
        $infobip_api_key = env('INFOBIP_API_KEY');
        $infobip_base_url = env('INFOBIP_BASE_URL');

        $request = new \HTTP_Request2();
        $request->setUrl("https://" . $infobip_base_url . "/sms/2/text/advanced");
        $request->setMethod(\HTTP_Request2::METHOD_POST);
        $request->setConfig(['follow_redirects' => true]);

        $request->setHeader([
            'Authorization' => 'App ' . $infobip_api_key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);

        $requestBody = json_encode([
            'messages' => [
                [
                    'destinations' => [['to' => $phone]],
                    'from' => 'ServiceSMS',
                    'text' => "Your OTP is: $otp"
                ]
            ]
        ]);

        $request->setBody($requestBody);

        try {
            $response = $request->send();
            if ($response->getStatus() != 200) {
                // Log error or handle it as needed
                // \Log::error('Failed to send OTP: ' . $response->getStatus() . ' ' . $response->getReasonPhrase());
            }
        } catch (\HTTP_Request2_Exception $e) {
            // Log error
            // Log::error('Error sending OTP: ' . $e->getMessage());
        }
    }
}
