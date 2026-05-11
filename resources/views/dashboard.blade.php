@extends('layouts.app')

@section('title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')
@section('page-subtitle', 'نظرة عامة على أداء المكتب العقاري')

@section('header-actions')
    <a href="{{ route('properties.create') }}"
       class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        إضافة عقار جديد
    </a>
@endsection

@section('content')

{{-- ========== بطاقات الإحصائيات ========== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    {{-- إجمالي العقارات --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['total_properties'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">إجمالي العقارات</p>
        </div>
    </div>

    {{-- عقارات متاحة --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['available'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">عقار متاح</p>
        </div>
    </div>

    {{-- الملاك --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-violet-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['total_owners'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">مالك مسجل</p>
        </div>
    </div>

    {{-- السماسرة --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['total_brokers'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">سمسار مسجل</p>
        </div>
    </div>
</div>

{{-- ========== صف ثاني: إحصائيات تفصيلية ========== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">

    {{-- توزيع الحالة --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
        <h3 class="text-sm font-bold text-slate-700 mb-4">توزيع حالة العقارات</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
                    <span class="text-sm text-slate-600">متاح</span>
                </div>
                <span class="text-sm font-bold text-slate-800">{{ $stats['available'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500 flex-shrink-0"></span>
                    <span class="text-sm text-slate-600">مباع</span>
                </div>
                <span class="text-sm font-bold text-slate-800">{{ $stats['sold'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500 flex-shrink-0"></span>
                    <span class="text-sm text-slate-600">مؤجر</span>
                </div>
                <span class="text-sm font-bold text-slate-800">{{ $stats['rented'] }}</span>
            </div>
        </div>
    </div>

    {{-- توزيع نوع العرض --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
        <h3 class="text-sm font-bold text-slate-700 mb-4">نوع العرض</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-600 flex-shrink-0"></span>
                    <span class="text-sm text-slate-600">للبيع</span>
                </div>
                <span class="text-sm font-bold text-slate-800">{{ $stats['for_sale'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 flex-shrink-0"></span>
                    <span class="text-sm text-slate-600">للإيجار</span>
                </div>
                <span class="text-sm font-bold text-slate-800">{{ $stats['for_rent'] }}</span>
            </div>
        </div>
    </div>

    {{-- روابط سريعة --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
        <h3 class="text-sm font-bold text-slate-700 mb-4">إجراءات سريعة</h3>
        <div class="space-y-2">
            <a href="{{ route('properties.create') }}"
               class="flex items-center gap-2 text-sm text-slate-600 hover:text-amber-600 py-1.5 transition-colors">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة عقار جديد
            </a>
            <a href="{{ route('owners.create') }}"
               class="flex items-center gap-2 text-sm text-slate-600 hover:text-amber-600 py-1.5 transition-colors">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة مالك جديد
            </a>
            <a href="{{ route('brokers.create') }}"
               class="flex items-center gap-2 text-sm text-slate-600 hover:text-amber-600 py-1.5 transition-colors">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة سمسار جديد
            </a>
        </div>
    </div>
</div>

{{-- ========== آخر العقارات المضافة ========== --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100">
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
        <h3 class="text-sm font-bold text-slate-700">آخر العقارات المضافة</h3>
        <a href="{{ route('properties.index') }}" class="text-xs text-amber-500 hover:underline font-medium">عرض الكل</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs">
                    <th class="px-6 py-3 text-right font-semibold">العقار</th>
                    <th class="px-6 py-3 text-right font-semibold">المالك</th>
                    <th class="px-6 py-3 text-right font-semibold">السعر</th>
                    <th class="px-6 py-3 text-right font-semibold">الحالة</th>
                    <th class="px-6 py-3 text-right font-semibold">النوع</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($latestProperties as $property)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3">
                            <div class="font-medium text-slate-800">{{ $property->type }} — {{ $property->district }}</div>
                            <div class="text-xs text-slate-400">{{ $property->governorate }}</div>
                        </td>
                        <td class="px-6 py-3 text-slate-600">{{ $property->owner->name }}</td>
                        <td class="px-6 py-3 font-semibold text-slate-800">
                            {{ number_format($property->price, 0) }} ج.م
                        </td>
                        <td class="px-6 py-3">
                            @php
                                $colors = ['متاح' => 'emerald', 'مباع' => 'red', 'مؤجر' => 'blue'];
                                $color  = $colors[$property->status] ?? 'gray';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                bg-{{ $color }}-100 text-{{ $color }}-700">
                                {{ $property->status }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-slate-600">{{ $property->offer_type }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm">
                            لا توجد عقارات مضافة حتى الآن.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
