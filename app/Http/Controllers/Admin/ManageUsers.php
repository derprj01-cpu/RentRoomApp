<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $query = User::query();
        $users = $query->get();
        return view('admin.manage-users', compact('users'));
    }
}
