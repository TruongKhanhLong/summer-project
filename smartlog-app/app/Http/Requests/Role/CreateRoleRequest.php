<?php

namespace App\Http\Requests\Role;

use App\Enums\Role_ID;
use App\Enums\Role_level;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'string', 'max:255', Rule::in(Role_ID::values())],
            'name' => 'required|string',
            'role_level' => ['required', 'string', 'max:255', Rule::in(Role_level::values())],
            'description' => 'required|string',
            'options' => 'required|string',
        ];
    }
}