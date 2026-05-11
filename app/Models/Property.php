<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    protected $fillable = [
        'broker_id',
        'owner_id',
        'type',
        'governorate',
        'district',
        'street',
        'area_sqm',
        'floor',
        'bedrooms',
        'bathrooms',
        'price',
        'offer_type',
        'status',
        'description',
    ];

    protected $casts = [
        'area_sqm'  => 'decimal:2',
        'price'     => 'decimal:2',
        'floor'     => 'integer',
        'bedrooms'  => 'integer',
        'bathrooms' => 'integer',
    ];

    /**
     * خيارات نوع العقار
     */
    public static array $types = ['شقة', 'فيلا', 'محل', 'مكتب', 'أرض'];

    /**
     * خيارات نوع العرض
     */
    public static array $offerTypes = ['بيع', 'إيجار'];

    /**
     * خيارات الحالة
     */
    public static array $statuses = ['متاح', 'مباع', 'مؤجر'];

    /**
     * العقار ينتمي إلى سمسار
     */
    public function broker(): BelongsTo
    {
        return $this->belongsTo(Broker::class);
    }

    /**
     * العقار ينتمي إلى مالك
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * لون الحالة لعرضه في الواجهة
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'متاح'  => 'green',
            'مباع'  => 'red',
            'مؤجر'  => 'blue',
            default => 'gray',
        };
    }

    /**
     * ميديا العقار (صور وفيديوهات)
     */
    public function media(): HasMany
    {
        return $this->hasMany(PropertyMedia::class);
    }

    /**
     * الحصول على الصورة الأساسية أو صورة افتراضية
     */
    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->media()->where('type', 'image')->where('is_primary', true)->first();
        
        if (!$primary) {
            $primary = $this->media()->where('type', 'image')->first();
        }

        if ($primary) {
            return asset('storage/' . $primary->file_path);
        }

        return asset('images/property-placeholder.jpg');
    }
}
