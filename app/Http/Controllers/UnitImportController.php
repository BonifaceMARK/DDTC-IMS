<?php
namespace App\Http\Controllers;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
class UnitImportController extends Controller
{
    public function showUploadForm()
    {
        return view('units-import');
    }

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls',
    //     ]);
    
    //     try {
    //         // Attempt to import the Excel file
    //         Excel::import(new UnitsImport, $request->file('file'));
    
    //         return redirect()->back()->with('success', 'Units imported successfully!');
    //     } catch (\Exception $e) {
    //         // Log the error for debugging
    //         \Log::error('Excel import error: ' . $e->getMessage());
    
    //         // Provide feedback to the user
    //         return redirect()->back()->with('error', 'There was an error importing the file. Please check the format and try again.');
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
        foreach ($rows as $index => $row) {
            if ($index == 1) {
                continue;
            }
            Unit::create([
                'dev_type'     => $row['A'],  
                'brand'        => $row['B'],
                'model'        => $row['B'],
                'serial_no'    => $row['C'], 
                'descript'     => null,      
                'area'         => null,      
                'qty'          => 1,         
                'remarks'      => null,       
                'property_tag' => null,       
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

}
