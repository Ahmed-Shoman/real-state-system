@extends('layouts.app')

@section('title', 'تفاصيل العقار')
@section('page-title', 'تفاصيل العقار')
@section('page-subtitle', $property->type . ' — ' . $property->district)

@section('header-actions')
    <div class="flex items-center gap-3">
        <a href="{{ route('properties.edit', $property) }}"
           class="inline-flex items-center gap-2 text-sm text-amber-600 bg-amber-50 border border-amber-100 px-4 py-2 rounded-xl hover:bg-amber-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            تعديل
        </a>
        <a href="{{ route('properties.index') }}"
           class="inline-flex items-center gap-2 text-sm text-slate-600 bg-white border border-slate-200 px-4 py-2 rounded-xl hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            رجوع
        </a>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    {{-- الجانب الأيمن: الميديا والتفاصيل --}}
    <div class="lg:col-span-2 space-y-6">
        
        {{-- معرض الصور --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">معرض الصور</h3>
                
                @php
                    $images = $property->media->where('type', 'image');
                    $videos = $property->media->where('type', 'video');
                @endphp

                @if($images->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- الصورة الرئيسية --}}
                        <div class="md:col-span-2 aspect-video rounded-2xl overflow-hidden bg-slate-100 border border-slate-100">
                            <img src="{{ $property->primary_image_url }}" class="w-full h-full object-cover" alt="Main Property Image">
                        </div>
                        
                        {{-- باقي الصور --}}
                        @foreach($images as $image)
                            @if(!$image->is_primary)
                            <div class="aspect-square rounded-2xl overflow-hidden bg-slate-100 border border-slate-100">
                                <img src="{{ asset('storage/' . $image->file_path) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" alt="Property Image">
                            </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="aspect-video rounded-2xl bg-slate-50 flex flex-col items-center justify-center text-slate-400 border-2 border-dashed border-slate-200">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="font-medium">لا توجد صور لهذا العقار</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- الفيديوهات --}}
        @if($videos->count() > 0)
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">فيديوهات العقار</h3>
                <div class="grid grid-cols-1 gap-6">
                    @foreach($videos as $video)
                    <div class="rounded-2xl overflow-hidden bg-slate-900 shadow-lg">
                        <video controls class="w-full aspect-video">
                            <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                            متصفحك لا يدعم مشغل الفيديو.
                        </video>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- تفاصيل العقار --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-6 border-b border-slate-50 pb-4">معلومات العقار</h3>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-8">
                <div class="text-center p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="block text-xs text-slate-500 mb-1">المساحة</span>
                    <span class="block font-bold text-slate-800">{{ $property->area_sqm }} م²</span>
                </div>
                <div class="text-center p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="block text-xs text-slate-500 mb-1">الغرف</span>
                    <span class="block font-bold text-slate-800">{{ $property->bedrooms ?? '-' }}</span>
                </div>
                <div class="text-center p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="block text-xs text-slate-500 mb-1">الحمامات</span>
                    <span class="block font-bold text-slate-800">{{ $property->bathrooms ?? '-' }}</span>
                </div>
                <div class="text-center p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="block text-xs text-slate-500 mb-1">الطابق</span>
                    <span class="block font-bold text-slate-800">{{ $property->floor ?? 'الأرضي' }}</span>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h4 class="text-sm font-bold text-slate-700 mb-2">الوصف</h4>
                    <p class="text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $property->description ?: 'لا يوجد وصف متاح لهذا العقار.' }}
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-50">
                    <div>
                        <h4 class="text-sm font-bold text-slate-700 mb-2">الموقع بالتفصيل</h4>
                        <div class="flex items-start gap-2 text-slate-600">
                            <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $property->governorate }}، {{ $property->district }}{{ $property->street ? '، ' . $property->street : '' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- الجانب الأيسر: معلومات التواصل والمالك --}}
    <div class="space-y-6">
        
        {{-- السعر والحالة --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <div class="flex justify-between items-start mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-{{ $property->status_color }}-100 text-{{ $property->status_color }}-700">
                    {{ $property->status }}
                </span>
                <span class="text-xs font-bold text-slate-400">{{ $property->offer_type }}</span>
            </div>
            <div class="mb-6">
                <span class="text-3xl font-black text-amber-600">{{ number_format($property->price) }}</span>
                <span class="text-sm font-bold text-slate-400 mr-1">ج.م</span>
            </div>
            <a href="{{ route('properties.edit', $property) }}" class="block w-full text-center bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 rounded-2xl transition-colors">
                تعديل بيانات العقار
            </a>
        </div>

        {{-- المالك --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">بيانات المالك</h4>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 font-bold text-lg">
                    {{ mb_substr($property->owner->name, 0, 1) }}
                </div>
                <div>
                    <h5 class="font-bold text-slate-800">{{ $property->owner->name }}</h5>
                    <p class="text-xs text-slate-500">{{ $property->owner->phone }}</p>
                </div>
            </div>
            <div class="space-y-2">
                <a href="tel:{{ $property->owner->phone }}" class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    اتصال هاتفي
                </a>
            </div>
        </div>

        {{-- السمسار --}}
        <div class="bg-slate-900 rounded-3xl shadow-lg p-6 text-white">
            <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">السمسار المسؤول</h4>
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-amber-400 font-bold text-lg">
                    {{ mb_substr($property->broker->name, 0, 1) }}
                </div>
                <div>
                    <h5 class="font-bold text-white">{{ $property->broker->name }}</h5>
                    <p class="text-xs text-slate-400">{{ $property->broker->office_name ?: 'مكتب خاص' }}</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center gap-3 text-sm text-slate-300">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    {{ $property->broker->phone }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
