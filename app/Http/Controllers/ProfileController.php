<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /** Display account information. Identity data is maintained by the administrator. */
    public function edit(Request $request): View
    {
        $user = $request->user()->loadMissing('pegawai.satuanKerja');

        return view('profile.edit', [
            'user' => $user,
            'roles' => $user->getRoleNames(),
        ]);
    }
}
