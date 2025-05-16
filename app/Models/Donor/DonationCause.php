<?php

namespace App\Models\Donor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationCause extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];
}
