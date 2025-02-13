<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StockModel extends Model
{
    use LogsActivity;


    protected $table = "stock";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'sto_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['sto_par_id','sto_job_id','sto_in','sto_out','sto_hold','sto_total']);
    }

}
