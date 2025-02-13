<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CreditSaleInvoiceModel extends Model
{
    use LogsActivity;


    protected $table = "credit_sale_invoice";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'csi_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['csi_si_id','csi_remarks','csi_cash_account','csi_party_id','csi_real_estimated_cost','csi_estimated_cost','csi_amount_paid','csi_remaining_cost','csi_discount','csi_status']);
    }
}
