<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ClientModel extends Model
{
    use LogsActivity;


    protected $table = "client";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'cli_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['cli_name','cli_number','cli_address']);
    }

}
