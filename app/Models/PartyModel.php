<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PartyModel extends Model
{
    use LogsActivity;


    protected $table = "party";
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey='party_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['party_name','party_number','party_address']);
    }
}
