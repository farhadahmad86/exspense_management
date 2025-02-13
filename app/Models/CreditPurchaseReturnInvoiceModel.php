<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CreditPurchaseReturnInvoiceModel extends Model
{
    use LogsActivity;

    protected $table = "credit_purchase_return_invoice";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'cpri_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['cpri_pi_id','cpri_remarks','cpri_cash_account','cpri_party_id','cpri_real_estimated_cost','cpri_estimated_cost','cpri_amount_paid','cpri_remaining_cost','cpri_discount','cpri_status']);
    }
}
