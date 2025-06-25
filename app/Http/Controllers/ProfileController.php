<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        Log::info('Profile edit accessed for user: ' . $user->email);
        return view('profile.edit', compact('user')); // Tạo view profile/edit.blade.php sau
    }
    
}
