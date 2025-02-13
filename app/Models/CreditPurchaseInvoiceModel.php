<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CreditPurchaseInvoiceModel extends Model
{
    use LogsActivity;

    protected $table = "credit_purchase_invoice";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'cpi_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['cpi_pi_id','cpi_remarks','cpi_cash_account','cpi_party_id','cpi_real_estimated_cost','cpi_estimated_cost','cpi_amount_paid','cpi_remaining_cost','cpi_discount','cpi_status']);
    }
}
