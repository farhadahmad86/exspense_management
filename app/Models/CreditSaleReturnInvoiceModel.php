<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CreditSaleReturnInvoiceModel extends Model
{
    use LogsActivity;


    protected $table = "credit_sale_return_invoice";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'csri_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['csri_si_id','csri_remarks','csri_cash_account','csri_party_id','csri_real_estimated_cost','csri_estimated_cost','csri_amount_paid','csri_remaining_cost','csri_discount','csri_status']);
    }
}
