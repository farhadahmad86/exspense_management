<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model
{
    use HasFactory;
    protected $table = 'new_company';

    // Primary Key attributes
    protected $primaryKey = 'nc_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;
}
