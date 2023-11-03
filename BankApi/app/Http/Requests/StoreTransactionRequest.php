<?php

namespace App\Http\Requests;

use Core\Domain\PixKey\Enum\PixKeyKind;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pix_kind_to' => ['required', new Enum(PixKeyKind::class)],
            'pix_key_to' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required|min:0|max:255',
        ];
    }
}
