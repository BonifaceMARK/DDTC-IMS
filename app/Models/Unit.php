<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Unit extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'units';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'rec_id'; // Set the primary key to 'rec_id'

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true; // Set to `false` if `rec_id` is not auto-incrementing

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int'; // Set to 'string' if `rec_id` is a non-integer

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company', 'brand', 'model', 'dev_type', 'sku', 'categ', 'ser_no', 
        'area', 'age', 'vendor_com', 'allocation', 'prop_tag', 'stats', 'qty', 
        'bundle_item', 'cust_po_ref', 'location', 'input_by', 'arrival_date', 
        'unit_stat', 'vendor_type', 'pmg_stats', 'sales_stats', 'sales_remarks',
        'desc', 'date_add', 'date_pull', 'remarks', 'file_att', 'audit_hist'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'audit_history' => 'array',
    ];

    /**
     * Custom accessor to get the exact age in days.
     *
     * @return string
     */
    public function getExactAgeInDaysAttribute()
    {
        if ($this->date_add) {
            $dateAdd = Carbon::parse($this->date_add);
            $ageInDays = $dateAdd->diffInDays(Carbon::now());
            return $ageInDays . ' days'; // e.g., "365 days"
        }
        return 'N/A'; // Default value if date_add is null
    }
}
