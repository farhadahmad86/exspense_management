<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PurchaseInvoiceModel extends Model
{
    use LogsActivity;


    protected $table = "purchase_invoice";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey='pi_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['pi_party_id','pi_cash_account','pi_total_items','pi_total_price','pi_discount','pi_grand_total','pi_amount_pay','pi_remaining','pi_status','pi_remarks']);
    }

}
