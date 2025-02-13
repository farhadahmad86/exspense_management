<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CashReciptVoucherModel extends Model
{
    use LogsActivity;

    protected $table = "cash_receipt_voucher";

    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'jrv_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['jrv_cash_account','jrv_recieved_by','jrv_remarks','	jrv_amount']);
    }

}
