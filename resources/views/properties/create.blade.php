@extends('layouts.app')

@section('title', 'إضافة عقار')
@section('page-title', 'إضافة عقار جديد')
@section('page-subtitle', 'أدخل تفاصيل العقار الجديد')

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
    <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        {{-- ======= الأطراف المعنية ======= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-5">
            <h3 class="text-sm font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100">الأطراف المعنية</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                {{-- المالك --}}
                <div>
                    <label for="owner_id" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        مالك العقار <span class="text-red-500">*</span>
                    </label>
                    <select id="owner_id" name="owner_id"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 bg-white
                               {{ $errors->has('owner_id') ? 'border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                        <option value="">— اختر المالك —</option>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                {{ $owner->name }} ({{ $owner->phone }})
                            </option>
                        @endforeach
                    </select>
                    @error('owner_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- السمسار --}}
                <div>
                    <label for="broker_id" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        السمسار المسؤول <span class="text-red-500">*</span>
                    </label>
                    <select id="broker_id" name="broker_id"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 bg-white
                               {{ $errors->has('broker_id') ? 'border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                        <option value="">— اختر السمسار —</option>
                        @foreach($brokers as $broker)
                            <option value="{{ $broker->id }}" {{ old('broker_id') == $broker->id ? 'selected' : '' }}>
                                {{ $broker->name }}{{ $broker->office_name ? ' — '.$broker->office_name : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('broker_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- ======= تفاصيل العقار ======= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-5">
            <h3 class="text-sm font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100">تفاصيل العقار</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                {{-- النوع --}}
                <div>
                    <label for="type" class="block text-sm font-semibold text-slate-700 mb-1.5">نوع العقار <span class="text-red-500">*</span></label>
                    <select id="type" name="type"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 bg-white
                               {{ $errors->has('type') ? 'border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                        <option value="">— اختر —</option>
                        @foreach(\App\Models\Property::$types as $type)
                            <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- نوع العرض --}}
                <div>
                    <label for="offer_type" class="block text-sm font-semibold text-slate-700 mb-1.5">نوع العرض <span class="text-red-500">*</span></label>
                    <select id="offer_type" name="offer_type"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 bg-white
                               {{ $errors->has('offer_type') ? 'border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                        <option value="">— اختر —</option>
                        @foreach(\App\Models\Property::$offerTypes as $ot)
                            <option value="{{ $ot }}" {{ old('offer_type') === $ot ? 'selected' : '' }}>{{ $ot }}</option>
                        @endforeach
                    </select>
                    @error('offer_type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- الحالة --}}
                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700 mb-1.5">الحالة <span class="text-red-500">*</span></label>
                    <select id="status" name="status"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 bg-white
                               {{ $errors->has('status') ? 'border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                        @foreach(\App\Models\Property::$statuses as $s)
                            <option value="{{ $s }}" {{ old('status', 'متاح') === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- المساحة --}}
                <div>
                    <label for="area_sqm" class="block text-sm font-semibold text-slate-700 mb-1.5">المساحة (م²) <span class="text-red-500">*</span></label>
                    <input type="number" id="area_sqm" name="area_sqm" value="{{ old('area_sqm') }}"
                        placeholder="120" min="1" step="0.01"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2
                               {{ $errors->has('area_sqm') ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                    @error('area_sqm')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- السعر --}}
                <div>
                    <label for="price" class="block text-sm font-semibold text-slate-700 mb-1.5">السعر (ج.م) <span class="text-red-500">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}"
                        placeholder="500000" min="0" step="0.01"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2
                               {{ $errors->has('price') ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                    @error('price')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- الطابق --}}
                <div>
                    <label for="floor" class="block text-sm font-semibold text-slate-700 mb-1.5">الطابق</label>
                    <input type="number" id="floor" name="floor" value="{{ old('floor') }}"
                        placeholder="3" min="0"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100">
                </div>

                {{-- غرف النوم --}}
                <div>
                    <label for="bedrooms" class="block text-sm font-semibold text-slate-700 mb-1.5">غرف النوم</label>
                    <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms') }}"
                        placeholder="3" min="0"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100">
                </div>

                {{-- الحمامات --}}
                <div>
                    <label for="bathrooms" class="block text-sm font-semibold text-slate-700 mb-1.5">الحمامات</label>
                    <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}"
                        placeholder="2" min="0"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100">
                </div>

            </div>
        </div>

        {{-- ======= الموقع ======= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-5">
            <h3 class="text-sm font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100">الموقع</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                <div>
                    <label for="governorate" class="block text-sm font-semibold text-slate-700 mb-1.5">المحافظة <span class="text-red-500">*</span></label>
                    <input type="text" id="governorate" name="governorate" value="{{ old('governorate') }}"
                        placeholder="القاهرة"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2
                               {{ $errors->has('governorate') ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                    @error('governorate')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="district" class="block text-sm font-semibold text-slate-700 mb-1.5">الحي / المنطقة <span class="text-red-500">*</span></label>
                    <input type="text" id="district" name="district" value="{{ old('district') }}"
                        placeholder="مدينة نصر"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2
                               {{ $errors->has('district') ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                    @error('district')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="street" class="block text-sm font-semibold text-slate-700 mb-1.5">الشارع</label>
                    <input type="text" id="street" name="street" value="{{ old('street') }}"
                        placeholder="شارع التسعين"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100">
                </div>

            </div>
        </div>

        {{-- ======= الوصف ======= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-5">
            <h3 class="text-sm font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100">الوصف</h3>
            <textarea id="description" name="description" rows="4"
                placeholder="وصف تفصيلي للعقار، المميزات، حالة التشطيب..."
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100 resize-none">{{ old('description') }}</textarea>
        </div>

        {{-- ======= الصور والفيديوهات ======= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-5">
            <h3 class="text-sm font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100">الصور والفيديوهات</h3>
            <div class="space-y-4">
                {{-- الصور --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">صور العقار</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="images" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="mb-2 text-sm text-slate-500"><span class="font-semibold">اضغط لرفع الصور</span> أو اسحب وأفلت</p>
                                <p class="text-xs text-slate-400">PNG, JPG أو JPEG</p>
                            </div>
                            <input id="images" name="images[]" type="file" class="hidden" multiple accept="image/*" />
                        </label>
                    </div>
                    @error('images.*')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- الفيديوهات --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">فيديوهات العقار</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="videos" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <p class="mb-2 text-sm text-slate-500"><span class="font-semibold">اضغط لرفع الفيديوهات</span> أو اسحب وأفلت</p>
                                <p class="text-xs text-slate-400">MP4, MOV أو AVI</p>
                            </div>
                            <input id="videos" name="videos[]" type="file" class="hidden" multiple accept="video/*" />
                        </label>
                    </div>
                    @error('videos.*')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- أزرار الإرسال --}}
        <div class="flex items-center gap-3">
            <button type="submit"
                class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                حفظ العقار
            </button>
            <a href="{{ route('properties.index') }}" class="text-sm text-slate-500 hover:text-slate-700 px-4 py-2.5 rounded-xl hover:bg-white transition-colors">إلغاء</a>
        </div>

    </form>
</div>
@endsection
