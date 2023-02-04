<?php

namespace App\Http\Requests\V1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'name' => ['required'],
                'type' => ['required', Rule::in(['individual', 'business'])],
                'email' => ['required', 'email', Rule::unique('customers', 'email')],
                'address' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
                'postal_code' => ['required'],
            ];
        }

        return [
            'name' => ['sometimes', 'required'],
            'type' => ['sometimes', 'required', Rule::in(['individual', 'business'])],
            'email' => ['sometimes', 'required', 'email', Rule::unique('customers', 'email')],
            'address' => ['sometimes', 'required'],
            'city' => ['sometimes', 'required'],
            'state' => ['sometimes', 'required'],
            'postal_code' => ['sometimes', 'required'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->postalCode) {
            $this->merge([
                'postal_code' => $this->postalCode,
            ]);
        }
    }
}
