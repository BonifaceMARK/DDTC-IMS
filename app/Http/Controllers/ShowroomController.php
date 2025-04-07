<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;

class ShowroomController extends Controller
{
    /**
     * Display the index page.
     */
    public function index()
    {
        return view('showroom-dash');
    }

    /**
     * Show the form for creating a new unit.
     */
    public function create()
    {
        return view('showroom-create');
    }

    /**
     * Store a newly created unit in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'dev_type' => 'nullable|string|max:50',
            'descript' => 'nullable|string|max:255',
            'ser_no' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'qty' => 'nullable|int|max:10',
            'remarks' => 'nullable|string',
            'prop_tag' => 'nullable|string|max:255',
            'stats' => 'nullable|string',
            'location' => 'nullable|string',
            'unit_stat' => 'nullable|string',
            'date_add' => 'nullable|date',
            'date_pull' => 'nullable|date',
            'file_att' => 'nullable|file|mimes:jpg,png,pdf|max:2048'
        ]);
    
        // Handle file attachment upload if provided
        $filePath = null;
        if ($request->hasFile('file_attach')) {
            $filePath = $request->file('file_attach')->store('attachments', 'public');
        }
    
        // Create a new unit record
        Unit::create([
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'dev_type' => $request->input('dev_type'),
            'descript' => $request->input('descript'),
            'ser_no' => $request->input('serial_no'),
            'area' => $request->input('area'),
            'qty' => $request->input('qty'),
            'remarks' => $request->input('remarks'),
            'prop_tag' => $request->input('property_tag'),
            'stats' => $request->input('status'),
            'location' => $request->input('location'),
            'unit_stat' => $request->input('unit_stat'),
            'date_add' => $request->input('date_added'),
            'date_pull' => $request->input('date_pullout'),
            'file_att' => $filePath, 
            'audit_hist' => [] 
        ]);
        return redirect()->back()->with('success', 'Unit added successfully!');
    }
    
    public function update(Request $request, $id)
{
    // Validate incoming data
    $request->validate([
        'brand' => 'nullable|string|max:255',
        'model' => 'nullable|string|max:255',
        'dev_type' => 'nullable|string|max:255',
        'serial_no' => 'nullable|string|max:255',
        'area' => 'nullable|string|max:255',
        'qty' => 'nullable|int|max:255',
        'property_tag' => 'nullable|string|max:255',
        'status' => 'nullable|string|max:255',
        'location' => 'nullable|string|max:255',
        'unit_stat' => 'nullable|string|max:255',
        'descript' => 'nullable|string|max:255',
        'date_added' => 'nullable|date',
        'date_pullout' => 'nullable|date',
        'remarks' => 'nullable|string',
        'file_attach' => 'nullable|file|mimes:jpg,png,pdf'
    ]);

    // Debug the request input
    \Log::info('Incoming request data:', $request->all()); // Log all request data

    // Find the unit by ID
    $unit = Unit::findOrFail($id);

    // Debug: Check if unit exists
    \Log::info('Unit found:', $unit->toArray());

    // Handle file attachment if uploaded
    if ($request->hasFile('file_attach')) {
        \Log::info('File detected:', [
            'original_name' => $request->file('file_attach')->getClientOriginalName(),
            'file_size' => $request->file('file_attach')->getSize()
        ]);

        $filePath = $request->file('file_attach')->store('attachments', 'public');

        \Log::info('File uploaded successfully:', ['file_path' => $filePath]);

        $unit->file_attach = $filePath; // Update file attachment path
    } else {
        \Log::info('No file attachment detected.');
    }

    // Update the unit with form data
    $unit->update([
        'brand' => $request->input('brand'),
        'model' => $request->input('model'),
        'dev_type' => $request->input('dev_type'),
        'serial_no' => $request->input('serial_no'),
        'area' => $request->input('area'),
        'qty' => $request->input('qty'),
        'property_tag' => $request->input('property_tag'),
        'status' => $request->input('status'),
        'location' => $request->input('location'),
        'unit_stat' => $request->input('unit_stat'),
        'descript' => $request->input('descript'),
        'date_added' => $request->input('date_added'),
        'date_pullout' => $request->input('pullout'),
        'date_added' => $request->input('date_added'),
        'remarks' => $request->input('remarks')
    ]);

    // Debug: Check final updated unit
    \Log::info('Unit updated successfully:', $unit->toArray());

    return redirect()->route('view-units', ['limit' => 10])->with('success', 'Unit updated successfully!');
}

public function analytics()
{
    // Total units count
    $totalUnits = Unit::count();

    // Recent additions within the last 7 days (or customize the time range)
    $recentAdditions = Unit::whereDate('date_add', '>=', now()->subDays(7))->count();

    // Pulled units (non-empty 'date_pull' field)
    $pulledUnits = Unit::whereNotNull('date_pull')->count();

    // Critical issues (placeholder logic - adjust as per your requirements)
    $criticalIssues = Unit::where('stats', 'Critical')->count();

    // Fetch 10 most recent units for the table
    $recentUnits = Unit::orderBy('date_add', 'desc')->take(10)->get();

    // Group units by location for the bar chart
    $unitStatistics = Unit::selectRaw('location, COUNT(*) as total_units')
                          ->groupBy('location')
                          ->get();

    // Group units by category for the cards
    $categoryTotals = Unit::selectRaw('dev_type, COUNT(*) as total_units')
                          ->groupBy('dev_type')
                          ->pluck('total_units', 'dev_type');

    // Prepare data for the pie chart (units distribution by brand)
    $chartData = [
        'labels' => Unit::select('brand')->distinct()->pluck('brand')->toArray(),
        'series' => Unit::selectRaw('brand, COUNT(*) as total_units')
                        ->groupBy('brand')
                        ->pluck('total_units')
                        ->toArray(),
    ];

    // Pass all data to the Blade template
    return view('analytics', compact(
        'totalUnits',
        'recentAdditions',
        'pulledUnits',
        'criticalIssues',
        'recentUnits',
        'unitStatistics',
        'categoryTotals',
        'chartData'
    ));
}


    /**
     * Show the edit page.
     */
    public function edit($id)
    {
        // Retrieve the unit by ID
        $unit = Unit::findOrFail($id);
    
        // Pass the unit data to the edit view
        return view('showroom-edit', compact('unit'));
    }
    

    /**
     * Show the view page.
     */
    public function view(Request $request)
{
    $limit = $request->input('limit', '10');  
    session(['selected_limit' => $limit]);
    
    if ($limit === 'All') {
        // Fetch only units where the location is 'dcc'
        $units = Unit::where('location', 'dcc')->get();  
    } else {
        // Fetch and paginate only units where the location is 'dcc'
        $units = Unit::where('location', 'dcc')->paginate((int) $limit);
    }
    
    return view('showroom-view', compact('units'));
}

}