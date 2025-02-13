<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PurchaseReturnInvoiceItemsModel extends Model
{
    use LogsActivity;


    protected $table = "purchase_return_invoice_items";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey='prii_id';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['prii_pi_id','prii_part_name','prii_qty','prii_rate','prii_discount','prii_amount']);
    }
}
