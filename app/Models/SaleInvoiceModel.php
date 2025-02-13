<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SaleInvoiceModel extends Model
{
    use LogsActivity;

    protected $table = "sale_invoice";

    use HasFactory;
    public $timestamps = false;
    protected $primaryKey='si_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['si_party_id','si_cash_account','si_total_items','si_total_price','si_discount','si_grand_total','si_amount_pay','si_remaining','si_status','si_remarks']);
    }
}
