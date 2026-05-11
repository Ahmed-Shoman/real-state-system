<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Broker;
use App\Models\Owner;
use App\Models\PropertyMedia;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    /**
     * عرض قائمة العقارات مع الفلترة
     */
    public function index()
    {
        $query = Property::with(['broker', 'owner']);

        // فلترة حسب النوع
        if (request('type')) {
            $query->where('type', request('type'));
        }

        // فلترة حسب الحالة
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // فلترة حسب نوع العرض
        if (request('offer_type')) {
            $query->where('offer_type', request('offer_type'));
        }

        // فلترة حسب المحافظة
        if (request('governorate')) {
            $query->where('governorate', 'like', '%' . request('governorate') . '%');
        }

        $properties = $query->latest()->paginate(12)->withQueryString();

        return view('properties.index', compact('properties'));
    }

    /**
     * عرض نموذج إضافة عقار
     */
    public function create()
    {
        $brokers = Broker::orderBy('name')->get();
        $owners  = Owner::orderBy('name')->get();

        return view('properties.create', compact('brokers', 'owners'));
    }

    /**
     * حفظ عقار جديد
     */
    public function store(StorePropertyRequest $request)
    {
        DB::transaction(function () use ($request) {
            $property = Property::create($request->validated());

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('properties/images', 'public');
                    $property->media()->create([
                        'file_path' => $path,
                        'type'      => 'image',
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $video) {
                    $path = $video->store('properties/videos', 'public');
                    $property->media()->create([
                        'file_path' => $path,
                        'type'      => 'video',
                    ]);
                }
            }
        });

        return redirect()
            ->route('properties.index')
            ->with('success', 'تم إضافة العقار بنجاح.');
    }

    /**
     * عرض تفاصيل عقار
     */
    public function show(Property $property)
    {
        $property->load(['broker', 'owner', 'media']);
        return view('properties.show', compact('property'));
    }

    /**
     * عرض نموذج تعديل عقار
     */
    public function edit(Property $property)
    {
        $brokers = Broker::orderBy('name')->get();
        $owners  = Owner::orderBy('name')->get();
        $property->load('media');

        return view('properties.edit', compact('property', 'brokers', 'owners'));
    }

    /**
     * تحديث بيانات العقار
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        DB::transaction(function () use ($request, $property) {
            $property->update($request->validated());

            // حذف الميديا المحددة
            if ($request->filled('delete_media')) {
                $mediaToDelete = PropertyMedia::whereIn('id', $request->delete_media)->get();
                foreach ($mediaToDelete as $media) {
                    Storage::disk('public')->delete($media->file_path);
                    $media->delete();
                }
            }

            // رفع صور جديدة
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('properties/images', 'public');
                    $property->media()->create([
                        'file_path' => $path,
                        'type'      => 'image',
                    ]);
                }
            }

            // رفع فيديوهات جديدة
            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $video) {
                    $path = $video->store('properties/videos', 'public');
                    $property->media()->create([
                        'file_path' => $path,
                        'type'      => 'video',
                    ]);
                }
            }

            // تحديث الصورة الأساسية إذا لزم الأمر
            if (!$property->media()->where('type', 'image')->where('is_primary', true)->exists()) {
                $firstImage = $property->media()->where('type', 'image')->first();
                if ($firstImage) {
                    $firstImage->update(['is_primary' => true]);
                }
            }
        });

        return redirect()
            ->route('properties.index')
            ->with('success', 'تم تحديث بيانات العقار بنجاح.');
    }

    /**
     * حذف عقار
     */
    public function destroy(Property $property)
    {
        foreach ($property->media as $media) {
            Storage::disk('public')->delete($media->file_path);
        }
        
        $property->delete();

        return redirect()
            ->route('properties.index')
            ->with('success', 'تم حذف العقار بنجاح.');
    }
}
