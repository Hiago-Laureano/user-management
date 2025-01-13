<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUpdateUsuarioRequest extends FormRequest
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
        // Regras
        $rules = [
            "nome" => ["required", "max:150", "min:2"],
            "email" => ["required", "email", "max:150", "unique:usuarios"],
            "senha" => ["required", "max:100", Password::min(6)->letters()->mixedCase()->numbers()->symbols()]
        ];

        // Regras para PUT
        if($this->method() === "PATCH"){
            $rules["email"] = ["required", "email", "max:150", Rule::unique("usuarios")->ignore($this->route("usuario"))];
        }

        // Regras para PATCH (removendo required)
        if($this->method() === "PATCH"){
            $rules["nome"] = ["nullable", "max:150", "min:2"];
            $rules["email"] = ["nullable", "email", "max:150", Rule::unique("usuarios")->ignore($this->route("usuario"))];
            $rules["senha"] = ["nullable", "max:100", Password::min(6)->letters()->mixedCase()->numbers()->symbols()];
        }

        return $rules;
    }
}
