<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CashPaymentVoucherModel extends Model
{
    use LogsActivity;

    protected $table = "cash_payment_voucher";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey='jpv_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['jpv_cash_account','jpv_deliver_to','jpv_remarks','	jpv_amount']);
    }
}
