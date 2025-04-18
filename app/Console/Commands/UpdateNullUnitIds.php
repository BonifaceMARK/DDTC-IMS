<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Unit; // Import the Unit model
use Illuminate\Support\Str;

class UpdateNullUnitIds extends Command
{
    protected $signature = 'units:update-null-unit-ids';
    protected $description = 'Update all NULL unit_id values with unique identifiers';

    public function handle()
    {
        $units = Unit::whereNull('unit_id')->get(); // Fetch all units with NULL unit_id
        foreach ($units as $unit) {
            $unit->unit_id = 'UID-' . Str::uuid(); // Generate a unique unit_id
            $unit->save(); // Save the updated unit
        }

        $this->info('All NULL unit_ids have been updated successfully!');
    }
}
