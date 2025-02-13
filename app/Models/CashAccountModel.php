<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CashAccountModel extends Model
{
    use LogsActivity;

    protected $table = "cash_account";

    use HasFactory;
    public $timestamps = false;

    protected $primaryKey = 'ca_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['ca_name','ca_balance']);
    }

}
