<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    // use HasFactory;
    protected $table = 'company_profiles';

    // Primary Key attributes
    protected $primaryKey = 'cp_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
