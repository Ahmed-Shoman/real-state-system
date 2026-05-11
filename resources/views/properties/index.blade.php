@extends('layouts.app')

@section('title', 'العقارات')
@section('page-title', 'إدارة العقارات')
@section('page-subtitle', 'عرض وتصفية جميع العقارات المسجلة')

@section('header-actions')
    <a href="{{ route('properties.create') }}"
       class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        إضافة عقار
    </a>
@endsection

@section('content')

{{-- شريط الفلترة --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-5">
    <form method="GET" action="{{ route('properties.index') }}" class="flex flex-wrap items-end gap-3">

        <div class="flex-1 min-w-36">
            <label class="block text-xs font-semibold text-slate-600 mb-1">نوع العقار</label>
            <select name="type" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-100 focus:border-amber-400 bg-white">
                <option value="">الكل</option>
                @foreach(\App\Models\Property::$types as $type)
                    <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1 min-w-36">
            <label class="block text-xs font-semibold text-slate-600 mb-1">الحالة</label>
            <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-100 focus:border-amber-400 bg-white">
                <option value="">الكل</option>
                @foreach(\App\Models\Property::$statuses as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1 min-w-36">
            <label class="block text-xs font-semibold text-slate-600 mb-1">نوع العرض</label>
            <select name="offer_type" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-100 focus:border-amber-400 bg-white">
                <option value="">الكل</option>
                @foreach(\App\Models\Property::$offerTypes as $type)
                    <option value="{{ $type }}" {{ request('offer_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1 min-w-36">
            <label class="block text-xs font-semibold text-slate-600 mb-1">المحافظة</label>
            <input type="text" name="governorate" value="{{ request('governorate') }}" placeholder="ابحث..."
                class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-100 focus:border-amber-400">
        </div>

        <div class="flex gap-2">
            <button type="submit"
                class="inline-flex items-center gap-1.5 bg-slate-800 hover:bg-slate-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                بحث
            </button>
            @if(request()->hasAny(['type','status','offer_type','governorate']))
                <a href="{{ route('properties.index') }}"
                   class="inline-flex items-center text-sm text-slate-500 bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-xl transition-colors">
                    مسح
                </a>
            @endif
        </div>
    </form>
</div>

{{-- جدول العقارات --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs border-b border-slate-200">
                    <th class="px-5 py-3 text-right font-semibold">العقار</th>
                    <th class="px-5 py-3 text-right font-semibold">الموقع</th>
                    <th class="px-5 py-3 text-right font-semibold">المالك</th>
                    <th class="px-5 py-3 text-right font-semibold">المساحة</th>
                    <th class="px-5 py-3 text-right font-semibold">السعر</th>
                    <th class="px-5 py-3 text-right font-semibold">العرض</th>
                    <th class="px-5 py-3 text-right font-semibold">الحالة</th>
                    <th class="px-5 py-3 text-right font-semibold">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($properties as $property)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg overflow-hidden bg-slate-100 shrink-0 border border-slate-100">
                                    <img src="{{ $property->primary_image_url }}" class="w-full h-full object-cover" alt="Property">
                                </div>
                                <div>
                                    <a href="{{ route('properties.show', $property) }}" class="font-semibold text-slate-800 hover:text-amber-600 transition-colors">{{ $property->type }}</a>
                                    @if($property->bedrooms)
                                        <div class="text-xs text-slate-400">{{ $property->bedrooms }} غرف — طابق {{ $property->floor ?? '—' }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="text-slate-700">{{ $property->district }}</div>
                            <div class="text-xs text-slate-400">{{ $property->governorate }}</div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $property->owner->name }}</td>
                        <td class="px-5 py-3.5 text-slate-600">{{ number_format($property->area_sqm, 0) }} م²</td>
                        <td class="px-5 py-3.5 font-semibold text-slate-800">{{ number_format($property->price, 0) }} ج.م</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $property->offer_type === 'بيع' ? 'bg-slate-100 text-slate-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $property->offer_type }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            @php $colors = ['متاح'=>'emerald','مباع'=>'red','مؤجر'=>'blue']; $c = $colors[$property->status]??'gray'; @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $c }}-100 text-{{ $c }}-700">
                                {{ $property->status }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('properties.show', $property) }}"
                                   class="inline-flex items-center gap-1 text-xs text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 px-2.5 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    عرض
                                </a>
                                <a href="{{ route('properties.edit', $property) }}"
                                   class="inline-flex items-center gap-1 text-xs text-slate-600 hover:text-amber-600 bg-slate-100 hover:bg-amber-50 px-2.5 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    تعديل
                                </a>
                                <form action="{{ route('properties.destroy', $property) }}" method="POST"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا العقار؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 text-xs text-red-600 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400">
                                <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="text-sm">لا توجد عقارات مطابقة للبحث.</p>
                                <a href="{{ route('properties.create') }}" class="text-sm text-amber-500 hover:underline font-medium">إضافة عقار جديد</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($properties->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $properties->links() }}</div>
    @endif
</div>
@endsection
