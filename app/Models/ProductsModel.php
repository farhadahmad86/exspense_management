<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductsModel extends Model
{

    use LogsActivity;

    protected $table = "products";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'par_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['par_name','par_purchase_price','par_bottom_price','par_sale_price','par_total_qty','par_status']);
    }

}
