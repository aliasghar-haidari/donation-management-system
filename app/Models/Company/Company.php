<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Currency\Currency;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'mobile',
        'address',
        'currency_id',
    ];

    /**
     * Get the currency associated with the company.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function accounts()
    {
        return $this->hasMany(\App\Models\Accounting\Account::class);
    }
}
