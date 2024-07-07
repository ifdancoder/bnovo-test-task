<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CreateGuestRequest extends FormRequest
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
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email|unique:guests',
            'phone' => 'string|required|unique:guests|regex:/^\+?[0-9]{10,15}$/',
            'country_id' => 'integer|exists:countries,id',
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Неверный формат адреса электронной почты',
            'email.unique' => 'Адрес электронной почты уже используется',
            'country_id.integer' => 'Неверный формат страны',
            'phone.string' => 'Неверный формат номера телефона',
            'phone.unique' => 'Номер телефона уже используется',
            'phone.regex' => 'Неверный формат телефона. Номер должен содержать от 10 до 15 цифр. Может содержать +',
            'country_id.exists' => 'Страна не найдена в справочнике стран',
            'first_name.string' => 'Неверный формат имени',
            'last_name.string' => 'Неверный формат фамилии',
            'required' => 'Поле :attribute обязательно для заполнения',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(
            new JsonResponse([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400));
    }
}
