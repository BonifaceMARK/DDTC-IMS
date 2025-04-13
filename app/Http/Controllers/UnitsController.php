<?php

namespace App\Http\Controllers;
use App\Models\UnitRemark;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;

class UnitsController extends Controller
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
        return view('units-create');
    }

    /**
     * Store a newly created unit in the database.
     */
    public function store(Request $request)
{
    $request->validate([
        'company' => 'nullable|string|max:255',
        'brand' => 'nullable|string|max:255',
        'model' => 'nullable|string|max:255',
        'dev_type' => 'nullable|string|max:50',
        'sku' => 'nullable|string|max:50',
        'categ' => 'nullable|string|max:50',
        'desc' => 'nullable|string|max:255',
        'ser_no' => 'nullable|string|max:255',
        'area' => 'nullable|string|max:255',
        'vendor_com' => 'nullable|string|max:255',
        'allocation' => 'nullable|string|max:255',
        'qty' => 'nullable|integer|max:10',
        'bundle_item' => 'nullable|string|max:10',
        'prop_tag' => 'nullable|string|max:255',
        'cust_po_ref' => 'nullable|string|max:255',
        'stats' => 'nullable|string',
        'location' => 'nullable|string',
        'input_by' => 'nullable|string',
        'unit_stat' => 'nullable|string',
        'pmg_stats' => 'nullable|string',
        'vendor_type' => 'nullable|string',
        'sales_stats' => 'nullable|string',
        'sales_remarks' => 'nullable|string',
        'date_add' => 'nullable|date',
        'date_pull' => 'nullable|date',
    ]);
    // Create a new unit record with JSON-encoded audit_hist
    Unit::create([
        'company' => $request->input('company'),
        'brand' => $request->input('brand'),
        'model' => $request->input('model'),
        'dev_type' => $request->input('dev_type'),
        'sku' => $request->input('sku'),
        'categ' => $request->input('categ'),
        'desc' => $request->input('desc'),
        'ser_no' => $request->input('ser_no'),
        'area' => $request->input('area'),
        'vendor_com' => $request->input('vendor_com'),
        'allocation' => $request->input('allocation'),
        'qty' => $request->input('qty'),
        'bundle_item' => $request->input('bundle_item'),
        'prop_tag' => $request->input('prop_tag'),
        'cust_po_ref' => $request->input('cust_po_ref'),
        'stats' => $request->input('stats'),
        'location' => $request->input('location'),
        'input_by' => $request->input('input_by'),
        'unit_stat' => $request->input('unit_stat'),
        'pmg_stats' => $request->input('pmg_stats'),
        'vendor_type' => $request->input('vendor_type'),
        'sales_stats' => $request->input('sales_stats'),
        'sales_remarks' => $request->input('sales_remarks'),
        'date_add' => $request->input('date_add'),
        'date_pull' => $request->input('date_pull'),
    ]);

    return redirect()->route('view.whitehouse')->with('success', 'Unit added successfully!');
}
    
//     public function update(Request $request, $id)
// {
//     // Validate incoming data
//     $request->validate([
//         'brand' => 'nullable|string|max:255',
//         'model' => 'nullable|string|max:255',
//         'dev_type' => 'nullable|string|max:255',
//         'serial_no' => 'nullable|string|max:255',
//         'area' => 'nullable|string|max:255',
//         'qty' => 'nullable|int|max:255',
//         'property_tag' => 'nullable|string|max:255',
//         'status' => 'nullable|string|max:255',
//         'location' => 'nullable|string|max:255',
//         'unit_stat' => 'nullable|string|max:255',
//         'descript' => 'nullable|string|max:255',
//         'date_added' => 'nullable|date',
//         'date_pullout' => 'nullable|date',
//         'remarks' => 'nullable|string',
//         'file_attach' => 'nullable|file|mimes:jpg,png,pdf'
//     ]);

//     // Debug the request input
//     \Log::info('Incoming request data:', $request->all()); // Log all request data

//     // Find the unit by ID
//     $unit = Unit::findOrFail($id);

//     // Debug: Check if unit exists
//     \Log::info('Unit found:', $unit->toArray());

//     // Handle file attachment if uploaded
//     if ($request->hasFile('file_attach')) {
//         \Log::info('File detected:', [
//             'original_name' => $request->file('file_attach')->getClientOriginalName(),
//             'file_size' => $request->file('file_attach')->getSize()
//         ]);

//         $filePath = $request->file('file_attach')->store('attachments', 'public');

//         \Log::info('File uploaded successfully:', ['file_path' => $filePath]);

//         $unit->file_attach = $filePath; // Update file attachment path
//     } else {
//         \Log::info('No file attachment detected.');
//     }

//     // Update the unit with form data
//     $unit->update([
//         'brand' => $request->input('brand'),
//         'model' => $request->input('model'),
//         'dev_type' => $request->input('dev_type'),
//         'serial_no' => $request->input('serial_no'),
//         'area' => $request->input('area'),
//         'qty' => $request->input('qty'),
//         'property_tag' => $request->input('property_tag'),
//         'status' => $request->input('status'),
//         'location' => $request->input('location'),
//         'unit_stat' => $request->input('unit_stat'),
//         'descript' => $request->input('descript'),
//         'date_added' => $request->input('date_added'),
//         'date_pullout' => $request->input('pullout'),
//         'date_added' => $request->input('date_added'),
//         'remarks' => $request->input('remarks')
//     ]);

//     // Debug: Check final updated unit
//     \Log::info('Unit updated successfully:', $unit->toArray());

//     return redirect()->route('view-units', ['limit' => 10])->with('success', 'Unit updated successfully!');
// }

// public function analytics()
// {
//     // Total units count
//     $totalUnits = Unit::count();

//     // Recent additions within the last 7 days (or customize the time range)
//     $recentAdditions = Unit::whereDate('date_add', '>=', now()->subDays(7))->count();

//     // Pulled units (non-empty 'date_pull' field)
//     $pulledUnits = Unit::whereNotNull('date_pull')->count();

//     // Critical issues (placeholder logic - adjust as per your requirements)
//     $criticalIssues = Unit::where('stats', 'Critical')->count();

//     // Fetch 10 most recent units for the table
//     $recentUnits = Unit::orderBy('date_add', 'desc')->take(10)->get();

//     // Group units by location for the bar chart
//     $unitStatistics = Unit::selectRaw('location, COUNT(*) as total_units')
//                           ->groupBy('location')
//                           ->get();

//     // Group units by category for the cards
//     $categoryTotals = Unit::selectRaw('dev_type, COUNT(*) as total_units')
//                           ->groupBy('dev_type')
//                           ->pluck('total_units', 'dev_type');

//     // Prepare data for the pie chart (units distribution by brand)
//     $chartData = [
//         'labels' => Unit::select('brand')->distinct()->pluck('brand')->toArray(),
//         'series' => Unit::selectRaw('brand, COUNT(*) as total_units')
//                         ->groupBy('brand')
//                         ->pluck('total_units')
//                         ->toArray(),
//     ];

//     // Pass all data to the Blade template
//     return view('analytics', compact(
//         'totalUnits',
//         'recentAdditions',
//         'pulledUnits',
//         'criticalIssues',
//         'recentUnits',
//         'unitStatistics',
//         'categoryTotals',
//         'chartData'
//     ));
// }


//     /**
//      * Show the edit page.
//      */
//     public function edit($id)
//     {
//         // Retrieve the unit by ID
//         $unit = Unit::findOrFail($id);
    
//         // Pass the unit data to the edit view
//         return view('showroom-edit', compact('unit'));
//     }


public function addRemark(Request $request, $rec_id)
{
    try {
        // Log::info('AddRemark Route Hit', [
        //     'rec_id' => $rec_id,
        //     'request_method' => $request->method(),
        //     'request_data' => $request->all(),
        // ]);

        $request->validate([
            'remark' => 'required|max:500', // Limit remark length
        ]);

        UnitRemark::create([
            'unit_id' => $rec_id,
            'remark' => $request->input('remark'),
            'user_id' => auth()->id(), // Attach the logged-in user
        ]);

        return response()->json(['success' => true, 'message' => 'Remark added successfully']);
    } catch (\Exception $e) {
        Log::error('Error in AddRemark', [
            'error_message' => $e->getMessage(),
            'rec_id' => $rec_id,
        ]);
        return response()->json(['success' => false, 'message' => 'An error occurred. Please try again.'], 500);
    }
}
    
public function fetchRemarks($rec_id)
{
    // Log::info('FetchRemarks Route Hit', [
    //     'rec_id' => $rec_id,
    // ]);

    $remarks = UnitRemark::where('unit_id', $rec_id)
        ->with('user') // Eager load user details
        ->orderBy('created_at', 'desc')
        ->get();
    return response()->json($remarks);
}

    
    public function remarks($rec_id)
    {
        $unit = Unit::where('rec_id', $rec_id)->firstOrFail(); // Find the unit by rec_id
        return view('units-remarks', compact('unit'));
    }
    
    public function updateRemarks(Request $request, $rec_id)
    {
        $unit = Unit::where('rec_id', $rec_id)->firstOrFail(); // Find by rec_id
        $unit->remarks = $request->input('remarks');
        $unit->save();
    
        return redirect()->route('units.remarks', $unit->rec_id)->with('success', 'Remarks updated successfully!');
    }
    public function editRemark(Request $request, $remark_id)
{
    $request->validate([
        'remark' => 'required|max:500', // Validate updated remark
    ]);

    $remark = UnitRemark::findOrFail($remark_id); // Find the remark by ID
    $remark->remark = $request->input('remark'); // Update the remark content
    $remark->save(); // Save changes

    return response()->json(['success' => true, 'message' => 'Remark updated successfully']);
}

public function deleteRemark($remark_id)
{
    $remark = UnitRemark::findOrFail($remark_id); // Find the remark by ID
    $remark->delete(); // Delete the remark

    return response()->json(['success' => true, 'message' => 'Remark deleted successfully']);
}


    /**
     * Show the view page.
     */
//     public function view(Request $request)
// {
//     $limit = $request->input('limit', '10');  
//     session(['selected_limit' => $limit]);
    
//     if ($limit === 'All') {
//         // Fetch only units where the location is 'dcc'
//         $units = Unit::where('location', 'dcc')->get();  
//     } else {
//         // Fetch and paginate only units where the location is 'dcc'
//         $units = Unit::where('location', 'dcc')->paginate((int) $limit);
//     }
    
//     return view('showroom-view', compact('units'));
// }

}