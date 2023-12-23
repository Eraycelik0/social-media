<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgot_password_mail(Request $request){

        $data = $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        // Delete all old code that user send before.
        ResetCodePassword::where('email', $request->email)->delete();

        $user = User::where('email',$request->email)->first();

        if (!$user){
            return response(['data' => [
                'message' => 'Reset email sent.'
            ]], 200);
        }

        // Generate random code
        $data['code'] = Str::random(6);

        // Create a new code
        $codeData = ResetCodePassword::create($data);

        $content = [
            'code' => $codeData->code,
            'reset_url' => env('FRONTEND_URL').'/change-password',
        ];

        // Send email to user
        MailHelper::sendMail(
            'Reverse password reset code',
            $request->email,
            'Reset Your Password',
            $content,
            '/mail_template/reset_password'
        );

        return response(['data' => [
            'message' => 'Reset email sent.'
        ]], 200);
    }
    public function reset_password(Request $request){
        $request->validate([
            'code' => 'required|string|exists:reset_code_passwords',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // find the code
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        // check if it does not expired: the time is one hour
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return response(['errors' => ['Code expired.']], 422);
        }

        // find user's email
        $user = User::firstWhere('email', $passwordReset->email);

        // update user password
        $user->update([
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('login');

        // delete current code
        $passwordReset->delete();

        return response(['message' =>'Password has been successfully reset.','token' => $token], 200);
    }
}
