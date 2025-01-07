<?php

namespace App\Http\Controllers\Api;

use Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OtpController extends Controller
{
    public function requestPasswordReset(Request $request)
    {
        $request->validate(['phone' => 'required|string']);

        // Find user by phone number
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Store hashed OTP in the user's pin field and set timestamp
        $user->pin = Hash::make($otp);
        $user->otp_sent_at = now(); // Set the timestamp
        $user->save();

        // Format the phone number: replace leading 0 with 84
        $phone = $user->phone;
        if (strpos($phone, '0') === 0) {
            $phone = '84' . substr($phone, 1);
        }

        // Send OTP via SMS
        $this->sendSms($phone, $otp);

        return response()->json(['message' => 'OTP sent successfully.']);
    }

    public function verifyPasswordReset(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Find the user based on the phone number sent in the request
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Check if OTP is expired (1 minutes)
        if ($user->otp_sent_at && Carbon::now()->diffInMinutes($user->otp_sent_at) > 1) {
            $user->pin = null; // Clear the OTP if expired
            $user->otp_sent_at = null; // Clear the timestamp
            $user->save();
            return response()->json(['message' => 'OTP has expired.'], 400);
        }

        // Verify the hashed OTP
        if (Hash::check($request->input('otp'), $user->pin)) {
            // Reset the password
            $user->password = bcrypt($request->input('new_password'));
            $user->pin = null; // Clear the OTP after verification
            $user->otp_sent_at = null; // Clear the timestamp
            $user->phone_verified_at = now(); // Mark phone as verified
            $user->save();

            return response()->json(['message' => 'Password reset successfully.']);
        }

        return response()->json(['message' => 'Invalid OTP.'], 400);
    }

    public function sendOtp(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Store hashed OTP in the user's pin field and set timestamp
        $user->pin = Hash::make($otp);
        $user->otp_sent_at = now(); // Set the timestamp
        $user->save();

        // Format the phone number: replace leading 0 with 84
        $phone = $user->phone;
        if (strpos($phone, '0') === 0) {
            $phone = '84' . substr($phone, 1);
        }

        // Send OTP via SMS
        $this->sendSms($phone, $otp);

        return response()->json(['message' => 'OTP sent successfully.']);
    }

    public function verifyOtp(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'otp' => 'required|string',
        ]);

        $otp = $request->input('otp');

        // Check if OTP is expired (1 minutes)
        if ($user->otp_sent_at && Carbon::now()->diffInMinutes($user->otp_sent_at) > 1) {
            $user->pin = null; // Clear the OTP if expired
            $user->otp_sent_at = null; // Clear the timestamp
            $user->save();
            return response()->json(['message' => 'OTP has expired.'], 400);
        }

        // Verify the hashed OTP
        if (Hash::check($otp, $user->pin)) {
            $user->pin = null; // Clear the OTP after verification
            $user->otp_sent_at = null; // Clear the timestamp
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
