<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AdminUserPasswordResetController extends Controller
{
    /** Reset another user's password; never record the password in the activity log. */
    public function update(Request $request, User $user): RedirectResponse
    {
        abort_if($request->user()->is($user), 403, 'Gunakan fitur ubah password pada profil untuk akun sendiri.');

        $validated = $request->validate([
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        DB::transaction(function () use ($request, $user, $validated): void {
            $user->forceFill([
                'password' => $validated['password'],
                'remember_token' => Str::random(60),
            ])->save();

            DB::table('activity_log')->insert([
                'id_user' => $request->user()->getKey(),
                'waktu' => now(),
                'aktivitas' => 'reset_password_pengguna',
                'keterangan' => 'Administrator '.$request->user()->username
                    .' mereset password akun '.$user->username.'.',
            ]);
        });

        return back()->with('status', 'user-password-reset');
    }
}
