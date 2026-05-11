@extends('layouts.app')

@section('title', 'تعديل بيانات المالك')
@section('page-title', 'تعديل بيانات المالك')

@section('header-actions')
    <a href="{{ route('owners.index') }}"
       class="inline-flex items-center gap-2 text-sm text-slate-600 bg-white border border-slate-200 px-4 py-2 rounded-xl hover:bg-slate-50 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        رجوع
    </a>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form action="{{ route('owners.update', $owner) }}" method="POST" novalidate>
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">الاسم <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $owner->name) }}"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">رقم الهاتف <span class="text-red-500">*</span></label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $owner->phone) }}"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 {{ $errors->has('phone') ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                    @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="whatsapp" class="block text-sm font-semibold text-slate-700 mb-1.5">رقم واتساب</label>
                    <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $owner->whatsapp) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $owner->email) }}"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 {{ $errors->has('email') ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="national_id" class="block text-sm font-semibold text-slate-700 mb-1.5">رقم الهوية الوطنية</label>
                    <input type="text" id="national_id" name="national_id" value="{{ old('national_id', $owner->national_id) }}"
                        class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 {{ $errors->has('national_id') ? 'border-red-400 bg-red-50 focus:ring-red-200' : 'border-slate-200 focus:border-amber-400 focus:ring-amber-100' }}">
                    @error('national_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1.5">ملاحظات</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100 resize-none">{{ old('notes', $owner->notes) }}</textarea>
                </div>

            </div>
            <div class="flex items-center gap-3 mt-7 pt-5 border-t border-slate-100">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    حفظ التعديلات
                </button>
                <a href="{{ route('owners.index') }}" class="text-sm text-slate-500 hover:text-slate-700 px-4 py-2.5 rounded-xl hover:bg-slate-100 transition-colors">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
