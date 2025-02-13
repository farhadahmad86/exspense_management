<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductLoss extends Model
{

    use LogsActivity;


    protected $table = "product_loss";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'pl_id';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['pl_part_id','pl_qty','pl_remarks']);
    }
}
