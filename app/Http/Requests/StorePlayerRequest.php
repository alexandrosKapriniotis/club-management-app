<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePlayerRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:5',
            'photo' => 'nullable|image|max:10240',
            'description' => 'nullable|string|max:255',
            'team_id'   =>  'required|int|exists:teams,id',
            'user'         => 'required|array',
            'user.email'   => 'required|string|email|max:255|unique:users,email',
            'user.password' =>  'required|string|min:6|confirmed'
        ];
    }
}
