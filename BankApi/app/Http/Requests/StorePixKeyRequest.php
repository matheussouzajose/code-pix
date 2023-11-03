<?php

namespace App\Http\Requests;

use Core\Domain\PixKey\Enum\PixKeyKind;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StorePixKeyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kind' => ['required', new Enum(PixKeyKind::class)],
            'key' => 'required|unique:pix_keys,key',
        ];
    }
}
