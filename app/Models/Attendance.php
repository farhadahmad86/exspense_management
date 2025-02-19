<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances'; // Table name

    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'check_in_status',
        'break_out',
        'break_out_status',
        'break_in',
        'break_in_status',
        'check_out',
        'check_out_status'
    ];

    /**
     * Relationship with User model
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
