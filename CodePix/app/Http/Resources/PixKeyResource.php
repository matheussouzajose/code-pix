<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PixKeyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'kind' => $this->kind,
            'key' => $this->key,
            'status' => $this->status,
            'created_at' => Carbon::make($this->createdAt)->format('Y-m-d H:i:s'),
            'account' => new AccountResource($this->account),
        ];
    }
}
