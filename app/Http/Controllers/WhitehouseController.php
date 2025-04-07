<?php

namespace App\Http\Controllers;
use App\Models\Unit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // For logging
class WhitehouseController extends Controller
{
    public function index(){
        
        return view('whitehouse-dash');
    }
    public function updateUnits(Request $request)
    {
        try {
            $units = $request->input('units'); // Get the submitted data
    
            foreach ($units as $unitData) {
                $unit = Unit::find($unitData['id']); // Find the unit by ID
                if ($unit) {
                    $unit->update($unitData); // Update the unit with the new data
                } else {
                    Log::error("Unit with ID {$unitData['id']} not found.");
                    return response()->json([
                        'success' => false, 
                        'message' => "Unit with ID {$unitData['id']} not found."
                    ], 404);
                }
            }
    
            return response()->json(['success' => true]);
    
        } catch (\Exception $e) {
            Log::error("Error in updating units: " . $e->getMessage());
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
        $location = $request->input('location'); // Get location from the request
    
        session(['selected_limit' => $limit]);
    
        // Build the query dynamically
        $query = Unit::query();
    
        // Apply location filter if provided
        if ($location) {
            $query->where('location', $location);
        }
    
        // Apply month and year filters if provided
        if ($month && $year) {
            $query->whereMonth('date_add', $month)
                  ->whereYear('date_add', $year);
        }
    
        // Order by most recent
        $query->orderBy('created_at', 'desc');
    
        // Conditionally fetch data based on the limit
        if ($limit === 'All') {
            $units = $query->get(); // Fetch all units
        } else {
            $units = $query->paginate((int) $limit); // Paginate with the specified limit
        }
    
        // Fetch distinct locations for the dropdown
        $locations = Unit::select('location')->distinct()->get();
    
        
        return view('whitehouse-view', compact('units', 'locations'));
    }
    
    

    

    public function update(Request $request, $id)
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
        $unit = Unit::findOrFail($id);
    
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
    
        return redirect()->route('view.whitehouse', ['limit' => 10])->with('success', 'Unit updated successfully!');
    }
    public function storeFileAttachment(Request $request, $id)
    {
        $request->validate([
            'file_attach' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);
    
        // Find the unit by ID
        $unit = Unit::findOrFail($id);
    
        // Handle file upload
        $filePath = $request->file('file_attach')->store('attachments', 'public');
    
        // Update the unit record with the file path
        $unit->file_att = $filePath;
        $unit->save();
    
        return response()->json([
            'success' => true,
            'message' => 'File uploaded and attached successfully!',
            'file_path' => $filePath
        ]);
    }
    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('whitehouse-edit', compact('unit'));
     
    }
    
}
