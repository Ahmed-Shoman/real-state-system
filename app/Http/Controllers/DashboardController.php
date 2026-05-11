<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use App\Models\Owner;
use App\Models\Property;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_properties' => Property::count(),
            'available'        => Property::where('status', 'متاح')->count(),
            'sold'             => Property::where('status', 'مباع')->count(),
            'rented'           => Property::where('status', 'مؤجر')->count(),
            'for_sale'         => Property::where('offer_type', 'بيع')->count(),
            'for_rent'         => Property::where('offer_type', 'إيجار')->count(),
            'total_owners'     => Owner::count(),
            'total_brokers'    => Broker::count(),
        ];

        $latestProperties = Property::with(['broker', 'owner'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'latestProperties'));
    }
}
