<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'broker_id'   => ['required', 'exists:brokers,id'],
            'owner_id'    => ['required', 'exists:owners,id'],
            'type'        => ['required', Rule::in(['شقة', 'فيلا', 'محل', 'مكتب', 'أرض'])],
            'governorate' => ['required', 'string', 'max:255'],
            'district'    => ['required', 'string', 'max:255'],
            'street'      => ['nullable', 'string', 'max:255'],
            'area_sqm'    => ['required', 'numeric', 'min:1'],
            'floor'       => ['nullable', 'integer', 'min:0'],
            'bedrooms'    => ['nullable', 'integer', 'min:0'],
            'bathrooms'   => ['nullable', 'integer', 'min:0'],
            'price'       => ['required', 'numeric', 'min:0'],
            'offer_type'  => ['required', Rule::in(['بيع', 'إيجار'])],
            'status'      => ['required', Rule::in(['متاح', 'مباع', 'مؤجر'])],
            'description' => ['nullable', 'string'],
            'images'      => ['nullable', 'array'],
            'images.*'    => ['image', 'mimes:jpeg,png,jpg,gif'],
            'videos'      => ['nullable', 'array'],
            'videos.*'    => ['file', 'mimetypes:video/mp4,video/quicktime,video/x-msvideo'],
            'delete_media' => ['nullable', 'array'],
            'delete_media.*' => ['exists:property_media,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'broker_id.required'   => 'يرجى اختيار السمسار المسؤول.',
            'broker_id.exists'     => 'السمسار المختار غير موجود.',
            'owner_id.required'    => 'يرجى اختيار مالك العقار.',
            'owner_id.exists'      => 'المالك المختار غير موجود.',
            'type.required'        => 'نوع العقار مطلوب.',
            'type.in'              => 'نوع العقار غير صحيح.',
            'governorate.required' => 'المحافظة مطلوبة.',
            'district.required'    => 'الحي / المنطقة مطلوب.',
            'area_sqm.required'    => 'المساحة بالمتر المربع مطلوبة.',
            'area_sqm.numeric'     => 'المساحة يجب أن تكون رقماً.',
            'area_sqm.min'         => 'المساحة يجب أن تكون أكبر من صفر.',
            'price.required'       => 'السعر مطلوب.',
            'price.numeric'        => 'السعر يجب أن يكون رقماً.',
            'offer_type.required'  => 'نوع العرض (بيع/إيجار) مطلوب.',
            'status.required'      => 'حالة العقار مطلوبة.',
        ];
    }
}
