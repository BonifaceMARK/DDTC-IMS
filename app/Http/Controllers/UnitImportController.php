<?php
namespace App\Http\Controllers;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
class UnitImportController extends Controller
{
    public function showUploadForm()
    {
        return view('units-import');
    }
    // public function importExcel(Request $request)
    // {
    //     // Validate the uploaded file
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls|max:10240', // Limit file size to 10MB
    //     ]);
    
    //     try {
    //         // Load the uploaded file
    //         $file = $request->file('file')->getPathName();
    //         $spreadsheet = IOFactory::load($file);
    
    //         $sheet = $spreadsheet->getActiveSheet();
    //         $rows = $sheet->toArray(null, true, true, true);
    
    //         // Log the rows for debugging
    //         \Log::info('Rows to process:', ['rows' => $rows]);
    
    //         foreach ($rows as $index => $row) {
    //             // Skip the header row (assuming index 1 is the header)
    //             if ($index === 1) {
    //                 continue;
    //             }
    
    //             // Skip rows with missing mandatory fields
    //             if (empty($row['A']) || empty($row['B']) || empty($row['G'])) {
    //                 \Log::warning("Missing mandatory data at row {$index}. Skipping:", ['row' => $row]);
    //                 continue;
    //             }
    
    //             // Insert data into the database
    //             Unit::create([
    //                 'brand'        => $row['A'] ?? null,    // Brand & Model
    //                 'model'        => $row['A'] ?? null,    // Brand & Model (model is repeated here)
    //                 'ser_no'       => $row['B'] ?? null,    // Serial Number
    //                 'hp_area'      => $row['C'] ?? null,    // HP AREA
    //                 'canon_area'   => $row['D'] ?? null,    // CANON AREA
    //                 'retail_area'  => $row['E'] ?? null,    // Retail Area
    //                 'av_area'      => $row['F'] ?? null,    // A.V AREA
    //                 'remarks'      => $row['G'] ?? null,    // Remarks / Property Tag
    //                 'stats'        => 'active',  
    //                 'location'     => 'DCC', 
    //                 'unit_stat'    => 'Available',  
    //                 'date_add'     => now(),     
    //                 'date_pull'    => null,      
    //                 'file_att'     => null,      
    //                 'audit_hist'   => json_encode([]), // Empty audit history
    //             ]);
    //         }
    
    //         return redirect()->back()->with('success', 'Units imported successfully!');
    //     } catch (\Exception $e) {
    //         // Log the detailed error
    //         \Log::error('Excel import error:', ['exception' => $e->getMessage()]);
    
    //         // User-friendly feedback
    //         return redirect()->back()->with('error', 'There was an error importing the file. Please ensure the file format and content are correct.');
    //     }
    // }

    

public function importExcel(Request $request)
{
    // Validate the uploaded file
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    try {
        $file = $request->file('file')->getPathName();
        $spreadsheet = IOFactory::load($file);

        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        // dd($rows);
        foreach ($rows as $index => $row) {
            if ($index == 1) {
                continue;
            }
            Unit::create([
                'dev_type'     => $row['A'],  
                'brand'        => $row['B'],
                'model'        => $row['B'],
                'ser_no'    => $row['C'], 
                'descript'     => null,      
                'area'         => null,      
                'qty'          => 1,         
                'remarks'      => null,       
                'prop_tag' => null,       
                'status'       => 'active',  
                'location'     => 'Whitehouse', 
                'unit_stat'    => 'Available',  
                'date_added'   => now(),     
                'date_pullout' => null,      
                'file_attach'  => null,      
                'audit_history'=> json_encode([]),
            ]);
        }
        return redirect()->back()->with('success', 'Units imported successfully!');
    } catch (\Exception $e) {
        \Log::error('Excel import error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'There was an error importing the file: ' . $e->getMessage());
    }
}


// public function importExcel(Request $request)
// {
//     // Validate the uploaded file
//     $request->validate([
//         'file' => 'required|mimes:xlsx,xls|max:10240', // Limit file size to 10MB
//     ]);

//     try {
//         // Load the uploaded Excel file
//         $file = $request->file('file')->getPathName();
//         $spreadsheet = IOFactory::load($file);

//         // Access the first active worksheet
//         $sheet = $spreadsheet->getActiveSheet();
//         $rows = $sheet->toArray(null, true, true, true);

//         // Log the rows for debugging purposes
//         \Log::info('Rows to process:', ['rows' => $rows]);

//         // Start processing rows from the third row onward
//         foreach ($rows as $index => $row) {
//             // Skip the first two rows explicitly
//             if ($index < 2) {
//                 \Log::info("Skipping row {$index}.", ['row' => $row]);
//                 continue;
//             }

//             // Parse and format the arrival_date column (Column H) to YYYY-MM-DD
//             $arrivalDate = null;
//             if (!empty($row['H'])) {
//                 try {
//                     $arrivalDate = Carbon::createFromFormat('m/d/y', $row['H'])->format('Y-m-d');
//                 } catch (\Exception $e) {
//                     \Log::warning("Invalid date format at row {$index}: {$row['H']}");
//                 }
//             }

//             // Ensure the `bundle_item` field fits within the database column length
//             $bundleItem = substr($row['C'] ?? '', 0, 65535); // Truncated for compatibility with TEXT columns
//             // Insert data into the database
//             Unit::create([
//                 'sku'                     => $row['A'] ?? null,  // SKU
//                 'desc'                    => $row['B'] ?? null,  // Short Item Description
//                 'bundle_item'             => $bundleItem,       // Bundled Item/s (truncated or adjusted)
//                 'ser_no'                  => $row['D'] ?? null,  // Serial Number
//                 'company'                 => $row['E'] ?? null,  // Company
//                 'allocation'              => $row['F'] ?? null,  // Allocation
//                 'input_by'                => $row['G'] ?? null,  // Inputted By
//                 'arrival_date'            => $arrivalDate,       // Arrival Date
//                 'pmg_stats'               => $row['I'] ?? null,  // PMG Status
//                 'stats'                   => $row['J'] ?? null, // Status
//                 'cust_po_ref'             => $row['K'] ?? null,  // Customer PO Reference
//                 'sales_stats'             => $row['L'] ?? null,  // Sales Status
//                 'sales_remarks'           => $row['M'] ?? null,  // Sales Remarks
//             ]);
//         }

//         // Redirect back with success message
//         return redirect()->back()->with('success', 'Units imported successfully!');
//     } catch (\Exception $e) {
//         // Log detailed error message for debugging
//         \Log::error('Excel import error:', ['exception' => $e->getMessage()]);

//         // Redirect back with an error message for user feedback
//         return redirect()->back()->with('error', 'There was an error importing the file. Please ensure the file format and content are correct.');
//     }
// }
}
