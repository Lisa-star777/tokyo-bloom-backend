<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Certificate;
use App\Models\Feedback;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCertificates = Certificate::count();
        $totalFeedback = Feedback::count();
        $newFeedback = Feedback::where('status', 'new')->count();
        $totalRevenue = Order::sum('total');
        $activeCertificates = Certificate::where('status', 'active')->count();
        
        return response()->json([
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalCertificates' => $totalCertificates,
            'totalFeedback' => $totalFeedback,
            'newFeedback' => $newFeedback,
            'totalRevenue' => $totalRevenue,
            'activeCertificates' => $activeCertificates,
        ]);
    }
}