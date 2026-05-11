@extends('layouts.app')

@section('title', 'تعديل العقار')
@section('page-title', 'تعديل بيانات العقار')
@section('page-subtitle', '{{ $property->type }} — {{ $property->district }}')

@section('header-actions')
    <a href="{{ route('properties.index') }}"
       class="inline-flex items-center gap-2 text-sm text-slate-600 bg-white border border-slate-200 px-4 py-2 rounded-xl hover:bg-slate-50 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        رجوع
    </a>
@endsection

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('properties.update', $property) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        {{-- الأطراف المعنية --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-5">
            <h3 class="text-sm font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100">الأطراف المعنية</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="owner_id" class="block text-sm font-semibold text-slate-700 mb-1.5">مالك العقار <span class="text-red-500">*</span></label>
                    <select id="owner_id" name="owner_id"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 bg-white {{ $errors->has('owner_id') ? 'border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                        <option value="">— اختر المالك —</option>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}" {{ old('owner_id', $property->owner_id) == $owner->id ? 'selected' : '' }}>
                                {{ $owner->name }} ({{ $owner->phone }})
                            </option>
                        @endforeach
                    </select>
                    @error('owner_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="broker_id" class="block text-sm font-semibold text-slate-700 mb-1.5">السمسار المسؤول <span class="text-red-500">*</span></label>
                    <select id="broker_id" name="broker_id"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 bg-white {{ $errors->has('broker_id') ? 'border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                        <option value="">— اختر السمسار —</option>
                        @foreach($brokers as $broker)
                            <option value="{{ $broker->id }}" {{ old('broker_id', $property->broker_id) == $broker->id ? 'selected' : '' }}>
                                {{ $broker->name }}{{ $broker->office_name ? ' — '.$broker->office_name : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('broker_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- تفاصيل العقار --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-5">
            <h3 class="text-sm font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100">تفاصيل العقار</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                <div>
                    <label for="type" class="block text-sm font-semibold text-slate-700 mb-1.5">نوع العقار <span class="text-red-500">*</span></label>
                    <select id="type" name="type" class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 bg-white {{ $errors->has('type') ? 'border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                        @foreach(\App\Models\Property::$types as $type)
                            <option value="{{ $type }}" {{ old('type', $property->type) === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="offer_type" class="block text-sm font-semibold text-slate-700 mb-1.5">نوع العرض <span class="text-red-500">*</span></label>
                    <select id="offer_type" name="offer_type" class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 bg-white {{ $errors->has('offer_type') ? 'border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                        @foreach(\App\Models\Property::$offerTypes as $ot)
                            <option value="{{ $ot }}" {{ old('offer_type', $property->offer_type) === $ot ? 'selected' : '' }}>{{ $ot }}</option>
                        @endforeach
                    </select>
                    @error('offer_type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700 mb-1.5">الحالة <span class="text-red-500">*</span></label>
                    <select id="status" name="status" class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 bg-white {{ $errors->has('status') ? 'border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                        @foreach(\App\Models\Property::$statuses as $s)
                            <option value="{{ $s }}" {{ old('status', $property->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="area_sqm" class="block text-sm font-semibold text-slate-700 mb-1.5">المساحة (م²) <span class="text-red-500">*</span></label>
                    <input type="number" id="area_sqm" name="area_sqm" value="{{ old('area_sqm', $property->area_sqm) }}" min="1" step="0.01"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 {{ $errors->has('area_sqm') ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                    @error('area_sqm')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-semibold text-slate-700 mb-1.5">السعر (ج.م) <span class="text-red-500">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price', $property->price) }}" min="0" step="0.01"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 {{ $errors->has('price') ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                    @error('price')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="floor" class="block text-sm font-semibold text-slate-700 mb-1.5">الطابق</label>
                    <input type="number" id="floor" name="floor" value="{{ old('floor', $property->floor) }}" min="0"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100">
                </div>

                <div>
                    <label for="bedrooms" class="block text-sm font-semibold text-slate-700 mb-1.5">غرف النوم</label>
                    <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100">
                </div>

                <div>
                    <label for="bathrooms" class="block text-sm font-semibold text-slate-700 mb-1.5">الحمامات</label>
                    <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100">
                </div>

            </div>
        </div>

        {{-- الموقع --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-5">
            <h3 class="text-sm font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100">الموقع</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label for="governorate" class="block text-sm font-semibold text-slate-700 mb-1.5">المحافظة <span class="text-red-500">*</span></label>
                    <input type="text" id="governorate" name="governorate" value="{{ old('governorate', $property->governorate) }}"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 {{ $errors->has('governorate') ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                    @error('governorate')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="district" class="block text-sm font-semibold text-slate-700 mb-1.5">الحي / المنطقة <span class="text-red-500">*</span></label>
                    <input type="text" id="district" name="district" value="{{ old('district', $property->district) }}"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 {{ $errors->has('district') ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                    @error('district')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="street" class="block text-sm font-semibold text-slate-700 mb-1.5">الشارع</label>
                    <input type="text" id="street" name="street" value="{{ old('street', $property->street) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100">
                </div>
            </div>
        </div>

            <textarea id="description" name="description" rows="4"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100 resize-none">{{ old('description', $property->description) }}</textarea>
        </div>

        {{-- ======= إدارة الميديا الحالية ======= --}}
        @if($property->media->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-5">
            <h3 class="text-sm font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100">الميديا الحالية</h3>
            <p class="text-xs text-slate-500 mb-4 italic">حدد الملفات التي ترغب في حذفها</p>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($property->media as $media)
                <div class="relative group aspect-square rounded-xl overflow-hidden border border-slate-100 bg-slate-50">
                    @if($media->type === 'image')
                        <img src="{{ asset('storage/' . $media->file_path) }}" class="w-full h-full object-cover" alt="Property Image">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-slate-800">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="delete_media[]" value="{{ $media->id }}" class="w-5 h-5 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                            <span class="mr-2 text-white text-xs font-bold">حذف</span>
                        </label>
                    </div>

                    @if($media->is_primary)
                    <div class="absolute top-2 right-2 bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                        أساسية
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ======= رفع ميديا جديدة ======= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-5">
            <h3 class="text-sm font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100">إضافة صور وفيديوهات جديدة</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">رفع صور جديدة</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                    @error('images.*')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">رفع فيديوهات جديدة</label>
                    <input type="file" name="videos[]" multiple accept="video/*"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    @error('videos.*')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                حفظ التعديلات
            </button>
            <a href="{{ route('properties.index') }}" class="text-sm text-slate-500 hover:text-slate-700 px-4 py-2.5 rounded-xl hover:bg-white transition-colors">إلغاء</a>
        </div>

    </form>
</div>
@endsection
