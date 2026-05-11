<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOwnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $ownerId = $this->route('owner')?->id ?? $this->route('owner');

        return [
            'name'        => ['required', 'string', 'max:255'],
            'phone'       => ['required', 'string', 'max:20'],
            'whatsapp'    => ['nullable', 'string', 'max:20'],
            'email'       => ['nullable', 'email', 'max:255', "unique:owners,email,{$ownerId}"],
            'national_id' => ['nullable', 'string', 'max:20', "unique:owners,national_id,{$ownerId}"],
            'notes'       => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'اسم المالك مطلوب.',
            'phone.required'     => 'رقم الهاتف مطلوب.',
            'email.unique'       => 'هذا البريد الإلكتروني مستخدم بالفعل.',
            'email.email'        => 'صيغة البريد الإلكتروني غير صحيحة.',
            'national_id.unique' => 'رقم الهوية الوطنية مستخدم بالفعل.',
        ];
    }
}
