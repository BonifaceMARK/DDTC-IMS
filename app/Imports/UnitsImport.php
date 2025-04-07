<?php
namespace App\Imports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;

class UnitsImport implements ToModel
{
    /**
     * Map each row of the Excel file to the `Unit` model and insert it into the database.
     */
    public function model(array $row)
    {
        dd($row);

        return new Unit([
            'brand'        => $row[1], // Assuming Brand/Model is in column 2
            'model'        => $row[1], // Optional: Map to a "model" column or duplicate Brand/Model
            'dev_type'     => $row[0], // Device Type in column 1
            'descript'     => null,    // No data in Excel, set to null
            'serial_no'    => $row[2], // Serial Number in column 3
            'area'         => null,    // No data in Excel, set to null
            'qty'          => 1,       // Default quantity as 1
            'remarks'      => null,    // No data in Excel, set to null
            'property_tag' => null,    // No data in Excel, set to null
            'status'       => 'active', // Default status
            'location'     => 'Whitehouse', // Example default location
            'unit_stat'    => 'Available', // Default unit status
            'date_added'   => now(),   // Current timestamp for date_added
            'date_pullout' => null,    // No data in Excel, set to null
            'file_attach'  => null,    // No data in Excel, set to null
            'audit_history'=> json_encode([]), // Default empty array as JSON
        ]);
    }
}
