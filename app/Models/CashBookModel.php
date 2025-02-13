<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CashBookModel extends Model
{
    use LogsActivity;

    protected $table = "cash_book";
    use HasFactory;
    public $timestamps = false;

    protected $primaryKey = 'cb_id';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['cb_job_id','cb_type','cb_in','cb_out','cb_total']);
    }
}
