<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Broker extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'office_name',
        'area',
        'commission_rate',
        'email',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
    ];

    /**
     * السمسار لديه عدة عقارات
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
