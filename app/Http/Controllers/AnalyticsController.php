<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
class AnalyticsController extends Controller
{
    public function getChartData()
    {
        // Fetching all units and grouping the data
        $units = Unit::select('company', 'input_by', 'pmg_stats', 'sales_stats', 'allocation')->get();
    
        // Group and count data for charts
        $chartData = [
            'companies' => $units->groupBy('company')->map->count(),
            'unitStatus' => $units->groupBy('input_by')->map->count(),
            'pmgStats' => $units->groupBy('pmg_stats')->map->count(),
            'salesStats' => $units->groupBy('sales_stats')->map->count(),
            'allocations' => $units->groupBy('allocation')->map->count(),
        ];
    
        return response()->json($chartData);
    }
    

public function dashboard()
{
    return view('dashboard');
}
}
