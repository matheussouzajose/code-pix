<?php

namespace App\Http\Requests;

use Core\Domain\PixKey\Enum\KindType;
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
            'account_id' => 'required|exists:accounts,id',
            'kind' => ['required', new Enum(KindType::class)],
            'key' => 'required',
        ];
    }
}
