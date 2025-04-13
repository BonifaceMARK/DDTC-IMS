<?php

namespace App\Http\Controllers;
use App\Models\Unit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\DB;
class UnitsIndexController extends Controller
{
    public function index(){
        
        return view('stock-dash');
    }
    public function updateUnits(Request $request)
    {
        try {
            // Retrieve the submitted data
            $units = $request->input('units');
    
            // Validate the incoming units array
            if (!is_array($units) || empty($units)) {
                Log::error('Invalid or empty units data received.');
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or empty units data received.'
                ], 400); // Bad Request
            }
    
            $updatedUnits = [];
            $skippedUnits = [];
    
            foreach ($units as $unitData) {
                // Ensure `rec_id` is provided
                if (empty($unitData['rec_id'])) {
                    Log::warning('Missing "rec_id" in unit data.', ['unitData' => $unitData]);
                    $skippedUnits[] = $unitData; // Track skipped units
                    continue; // Skip processing if rec_id is missing
                }
    
                // Find the unit by `rec_id`
                $unit = Unit::where('rec_id', $unitData['rec_id'])->first();
    
                if ($unit) {
                    // Filter the data to update only fillable attributes
                    $fillableData = array_intersect_key($unitData, array_flip($unit->getFillable()));
    
                    // Update the unit
                    $unit->update($fillableData);
                    Log::info("Updated unit with rec_id {$unitData['rec_id']}.", ['data' => $fillableData]);
                    $updatedUnits[] = $unitData; // Track successfully updated units
                } else {
                    Log::warning("Unit with rec_id {$unitData['rec_id']} not found.", ['unitData' => $unitData]);
                    $skippedUnits[] = $unitData; // Track skipped units
                }
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Units updated successfully.',
                'updated' => $updatedUnits,
                'skipped' => $skippedUnits,
            ]);
    
        } catch (\Exception $e) {
            Log::error("Error in updating units: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
    
            return response()->json([
                'success' => false,
                'message' => "An error occurred while updating units: " . $e->getMessage()
            ], 500); // Internal server error response
        }
    }

    public function view(Request $request)
    {
        $limit = $request->input('limit', 10); // Default limit is 10
        $month = $request->input('month'); // Get month from the request
        $year = $request->input('year'); // Get year from the request
        $specificDate = $request->input('specific_date'); // Get specific date from the request
        $location = $request->input('location'); // Get location from the request
    
        session(['selected_limit' => $limit]);
    
        $query = Unit::query();
    
        if ($location && $location !== 'No Location') {
            $query->where('location', $location);
        } else if ($location === 'No Location') {
            $query->whereNull('location')->orWhere('location', ''); // Include null or empty locations explicitly
        }
    
        if ($specificDate) {
            $query->whereDate('date_add', $specificDate);
        } else if ($month && $year) {
            $query->whereMonth('date_add', $month)
                  ->whereYear('date_add', $year);
        }
    
        $query->orderBy('created_at', 'desc');
    
        if ($limit === 'All') {
            $units = $query->get(); // Fetch all units
        } else {
            $units = $query->paginate((int) $limit); // Paginate with the specified limit
        }
    
        $locations = Unit::select(DB::raw("COALESCE(location, 'No Location') AS location"))
                         ->distinct()
                         ->get();
    
        return view('units-view', compact('units', 'locations'));
    }
    

    public function update(Request $request, $rec_id)
    {
        // Validate incoming data
        $request->validate([
            
            'company' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'dev_type' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255',
            'categ' => 'nullable|string|max:255',
            'ser_no' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'vendor_com' => 'nullable|string|max:255',
            'allocation' => 'nullable|string|max:255',
            'qty' => 'nullable|int|max:255',
            'bundle_item' => 'nullable|string|max:255',
            'prop_tag' => 'nullable|string|max:255',
            'cust_po_ref' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'input_by' => 'nullable|string|max:255',
            'vendor_type' => 'nullable|string|max:255',
            'pmg_stats' => 'nullable|string|max:255',
            'sales_stats' => 'nullable|string|max:255',
            'unit_stat' => 'nullable|string|max:255',
            'desc' => 'nullable|string|max:255',
            'date_add' => 'nullable|date',
            'date_pull' => 'nullable|date',
        ]);
    
        // Debug the request input
        \Log::info('Incoming request data:', $request->all()); // Log all request data
    
        // Find the unit by ID
        $unit = Unit::findOrFail($rec_id);
    
        // Debug: Check if unit exists
        \Log::info('Unit found:', $unit->toArray());
    
       
    
        $unit->update([
            'company' => $request->input('company'),
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'dev_type' => $request->input('dev_type'),
            'sku' => $request->input('sku'),
            'categ' => $request->input('categ'),
            'ser_no' => $request->input('ser_no'),
            'area' => $request->input('area'),
            'vendor_com' => $request->input('vendor_com'),
            'allocation' => $request->input('allocation'),
            'qty' => $request->input('qty'),
            'bundle_item' => $request->input('bundle_item'),
            'prop_tag' => $request->input('prop_tag'),
            'cust_po_ref' => $request->input('cust_po_ref'),
            'location' => $request->input('location'),
            'input_by' => $request->input('input_by'),
            'vendor_type' => $request->input('vendor_type'),
            'pmg_stats' => $request->input('pmg_stats'),
            'sales_stats' => $request->input('sales_stats'),
            'sales_remarks' => $request->input('sales_remarks'),
            'unit_stat' => $request->input('unit_stat'),
            'desc' => $request->input('desc'),
            'date_add' => $request->input('date_add'),
            'date_pull' => $request->input('date_pull'),
        ]);
    
        // Debug: Check final updated unit
        \Log::info('Unit updated successfully:', $unit->toArray());
    
        return response()->json([
            'success' => false,
            'message' => "An error occurred while updating units: " . $e->getMessage()
        ], 500); 
    }
    public function storeFileAttachment(Request $request, $rec_id)
    {
        $request->validate([
            'file_att' => 'required|file',
        ]);
    
        // Find the unit by ID
        $unit = Unit::findOrFail($rec_id);
    
        // Handle file upload
        $filePath = $request->file('file_att')->store('attachments', 'public');
    
        // Update the unit record with the file path
        $unit->file_att = $filePath;
        $unit->save();
        \Log::info('Incoming request data:', $request->all());
        return response()->json([
            'success' => true,
            'message' => 'File uploaded and attached successfully!',
            'file_path' => $filePath
        ]);
    }
    public function edit($rec_id)
    {
        $unit = Unit::findOrFail($rec_id);
        return view('units-edit', compact('unit'));
     
    }
    
}
