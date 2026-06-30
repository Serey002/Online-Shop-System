<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;

class AdminUserController extends Controller
{
    // Display all registered customers with metrics loaded
    public function index()
    {
        // Fetch users where is_admin is false (regular customers)
        $users = User::select('users.*') 
            ->where('is_admin', false)
            ->withCount('orders') // Keeps working perfectly thanks to your User model update!
            ->addSelect([
                // Reverted back to the original database column string name
                'total_spent' => Order::selectRaw('COALESCE(SUM(total_amount), 0)')
                    ->whereColumn('user_id', 'users.id')
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.index', compact('users'));
    }
}