<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PurchaseReturnInvoiceModel extends Model
{
    use LogsActivity;


    protected $table = "purchase_return_invoice";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey='pri_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['pri_party_id','pri_cash_account','pri_total_items','pri_total_price','pri_discount','pri_grand_total','pri_amount_pay','pri_remaining','pri_status','pri_remarks']);
    }

}
