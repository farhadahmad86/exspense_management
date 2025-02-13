<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PurchaseInvoiceItemsModel extends Model
{
    use LogsActivity;


    protected $table = "purchase_invoice_items";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey='pii_id';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['pii_pi_id','pii_part_name','pii_qty','pii_rate','pii_discount','pii_amount']);
    }
}
