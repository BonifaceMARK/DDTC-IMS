<?php

namespace App\Observers;
use App\Models\UnitTrail;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;


class Units
{
    public function created(Unit $unit){

        $this->logHistory($unit, 'Created','NoData','NoData','NoData', $unit->toArray(),'Created a new unit.!');
    }

    public function updated(Unit $unit){
        $changes = $unit->getchanges();

        foreach ($changes as $field => $newValue){
            if ($field === 'history' || $field === 'updated_at'){
                continue;
            }

            $oldValue = $unit->getOriginal($field);

            $this->logHistory($unit, 'Updated', $field, $oldValue, $newValue,null,'Updated a Unit.!');
        }
    }

        protected function logHistory(Unit $unit, string $action, ?string $field = null, $oldValue = null, $newValue = null, ?array $details = null, ?string $description = null)
                {
            $unitTrail = new UnitTrail();
            $unitTrail->model = 'Unit Managed';
            $unitTrail->action = $action;
            $unitTrail->field = $field;
            $unitTrail->old_value = $oldValue;
            $unitTrail->new_value = $newValue;
            $unitTrail->details = $details ? json_encode($details) : null;
            $unitTrail->description = $description;
            $unitTrail->user_id = Auth::id();
            $unitTrail->save();
        }
}
