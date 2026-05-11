<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'whatsapp',
        'email',
        'national_id',
        'notes',
    ];

    /**
     * المالك لديه عدة عقارات
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
