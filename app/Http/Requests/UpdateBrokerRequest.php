<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrokerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $brokerId = $this->route('broker')?->id ?? $this->route('broker');

        return [
            'name'            => ['required', 'string', 'max:255'],
            'phone'           => ['required', 'string', 'max:20'],
            'office_name'     => ['nullable', 'string', 'max:255'],
            'area'            => ['nullable', 'string', 'max:255'],
            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'email'           => ['nullable', 'email', 'max:255', "unique:brokers,email,{$brokerId}"],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'اسم السمسار مطلوب.',
            'phone.required' => 'رقم الهاتف مطلوب.',
            'email.unique'   => 'هذا البريد الإلكتروني مستخدم بالفعل.',
            'email.email'    => 'صيغة البريد الإلكتروني غير صحيحة.',
            'commission_rate.numeric' => 'نسبة العمولة يجب أن تكون رقماً.',
            'commission_rate.max'     => 'نسبة العمولة لا يمكن أن تتجاوز 100%.',
        ];
    }
}
