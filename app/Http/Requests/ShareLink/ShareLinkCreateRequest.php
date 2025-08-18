<?php

namespace App\Http\Requests\ShareLink;

use App\Http\Responses\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShareLinkCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file_id' => 'required|integer|exists:files,id',
            'user_id' => 'required|integer|exists:users,id',
            'expires_at' => 'required|date_format:H:i:s',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponse::validationError('Validation errors', $validator->errors())
        );
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            ApiResponse::validationError('Unauthorized')
        );
    }
}
