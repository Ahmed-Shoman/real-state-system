@extends('layouts.app')

@section('title', 'السماسرة')
@section('page-title', 'إدارة السماسرة')
@section('page-subtitle', 'عرض وإدارة جميع السماسرة المسجلين في النظام')

@section('header-actions')
    <a href="{{ route('brokers.create') }}"
       class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        إضافة سمسار
    </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs border-b border-slate-200">
                    <th class="px-6 py-3 text-right font-semibold">#</th>
                    <th class="px-6 py-3 text-right font-semibold">الاسم</th>
                    <th class="px-6 py-3 text-right font-semibold">الهاتف</th>
                    <th class="px-6 py-3 text-right font-semibold">المكتب</th>
                    <th class="px-6 py-3 text-right font-semibold">المنطقة</th>
                    <th class="px-6 py-3 text-right font-semibold">العمولة %</th>
                    <th class="px-6 py-3 text-right font-semibold">العقارات</th>
                    <th class="px-6 py-3 text-right font-semibold">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($brokers as $broker)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-400 text-xs">{{ $broker->id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-800">{{ $broker->name }}</div>
                            @if($broker->email)
                                <div class="text-xs text-slate-400">{{ $broker->email }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $broker->phone }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $broker->office_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $broker->area ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if($broker->commission_rate)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    {{ $broker->commission_rate }}%
                                </span>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                {{ $broker->properties_count }} عقار
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('brokers.edit', $broker) }}"
                                   class="inline-flex items-center gap-1 text-xs text-slate-600 hover:text-amber-600 bg-slate-100 hover:bg-amber-50 px-3 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    تعديل
                                </a>
                                <form action="{{ route('brokers.destroy', $broker) }}" method="POST"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا السمسار؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 text-xs text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <p class="text-sm">لا يوجد سماسرة مسجلون حتى الآن.</p>
                                <a href="{{ route('brokers.create') }}"
                                   class="text-sm text-amber-500 hover:underline font-medium">إضافة سمسار جديد</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($brokers->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $brokers->links() }}
        </div>
    @endif
</div>
@endsection
