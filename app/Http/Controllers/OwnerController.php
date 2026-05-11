<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\UpdateOwnerRequest;

class OwnerController extends Controller
{
    /**
     * عرض قائمة الملاك
     */
    public function index()
    {
        $owners = Owner::withCount('properties')->latest()->paginate(15);
        return view('owners.index', compact('owners'));
    }

    /**
     * عرض نموذج إضافة مالك
     */
    public function create()
    {
        return view('owners.create');
    }

    /**
     * حفظ مالك جديد
     */
    public function store(StoreOwnerRequest $request)
    {
        Owner::create($request->validated());

        return redirect()
            ->route('owners.index')
            ->with('success', 'تم إضافة المالك بنجاح.');
    }

    /**
     * عرض تفاصيل مالك
     */
    public function show(Owner $owner)
    {
        $owner->load(['properties.broker']);
        return view('owners.show', compact('owner'));
    }

    /**
     * عرض نموذج تعديل مالك
     */
    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    /**
     * تحديث بيانات المالك
     */
    public function update(UpdateOwnerRequest $request, Owner $owner)
    {
        $owner->update($request->validated());

        return redirect()
            ->route('owners.index')
            ->with('success', 'تم تحديث بيانات المالك بنجاح.');
    }

    /**
     * حذف مالك
     */
    public function destroy(Owner $owner)
    {
        if ($owner->properties()->exists()) {
            return back()->with('error', 'لا يمكن حذف هذا المالك لأنه مرتبط بعقارات.');
        }

        $owner->delete();

        return redirect()
            ->route('owners.index')
            ->with('success', 'تم حذف المالك بنجاح.');
    }
}
