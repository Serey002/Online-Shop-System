<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    // Display all registered customers
    public function index()
    {
        // Fetch users where is_admin is false (regular customers)
        $users = User::where('is_admin', false)->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }
}