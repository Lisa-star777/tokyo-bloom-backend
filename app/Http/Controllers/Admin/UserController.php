<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json($users);
    }
    
    public function updateBonuses(Request $request, User $user)
    {
        $validated = $request->validate([
            'bonuses' => 'required|integer|min:0',
        ]);
        
        $user->bonuses = $validated['bonuses'];
        $user->save();
        
        return response()->json($user);
    }
}