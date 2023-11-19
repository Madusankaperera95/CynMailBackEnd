<?php

namespace App\Http\Requests;

use App\Rules\CheckDuplicatesAttributes;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => ['required'],
            'lastName' => ['required'],
            'phone' => ['required','numeric','min:9',new CheckDuplicatesAttributes($this->route('contactGroupId'))],
            'email' => ['required', new CheckDuplicatesAttributes($this->route('contactGroupId'))],
            'photo' => 'nullable|image|mimetypes:image/jpeg,image/png,image/jpg',
            'address' => 'required'
        ];
    }
}
