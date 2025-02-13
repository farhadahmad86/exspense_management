<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SaleInvoiceItemsModel extends Model
{

    use LogsActivity;

    protected $table = "sale_invoice_items";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey='sii_id';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['sii_si_id','sii_part_name','sii_qty','sii_rate','sii_discount','sii_amount']);
    }
}
