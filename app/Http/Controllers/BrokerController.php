<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use App\Http\Requests\StoreBrokerRequest;
use App\Http\Requests\UpdateBrokerRequest;

class BrokerController extends Controller
{
    /**
     * عرض قائمة السماسرة
     */
    public function index()
    {
        $brokers = Broker::withCount('properties')->latest()->paginate(15);
        return view('brokers.index', compact('brokers'));
    }

    /**
     * عرض نموذج إضافة سمسار
     */
    public function create()
    {
        return view('brokers.create');
    }

    /**
     * حفظ سمسار جديد
     */
    public function store(StoreBrokerRequest $request)
    {
        Broker::create($request->validated());

        return redirect()
            ->route('brokers.index')
            ->with('success', 'تم إضافة السمسار بنجاح.');
    }

    /**
     * عرض تفاصيل سمسار
     */
    public function show(Broker $broker)
    {
        $broker->load(['properties.owner']);
        return view('brokers.show', compact('broker'));
    }

    /**
     * عرض نموذج تعديل سمسار
     */
    public function edit(Broker $broker)
    {
        return view('brokers.edit', compact('broker'));
    }

    /**
     * تحديث بيانات السمسار
     */
    public function update(UpdateBrokerRequest $request, Broker $broker)
    {
        $broker->update($request->validated());

        return redirect()
            ->route('brokers.index')
            ->with('success', 'تم تحديث بيانات السمسار بنجاح.');
    }

    /**
     * حذف سمسار
     */
    public function destroy(Broker $broker)
    {
        // التحقق من عدم وجود عقارات مرتبطة
        if ($broker->properties()->exists()) {
            return back()->with('error', 'لا يمكن حذف هذا السمسار لأنه مرتبط بعقارات. قم بحذف أو تحويل العقارات أولاً.');
        }

        $broker->delete();

        return redirect()
            ->route('brokers.index')
            ->with('success', 'تم حذف السمسار بنجاح.');
    }
}
