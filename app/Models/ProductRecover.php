<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductRecover extends Model
{
    use LogsActivity;


    protected $table = "product_recover";

    use HasFactory;
    public $timestamps = false;

    protected $primaryKey = 'pr_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['pr_part_id','pr_qty','pr_remarks']);
    }

}
