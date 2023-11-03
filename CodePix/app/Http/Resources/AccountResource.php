<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'owner_name' => $this->ownerName,
            'number' => $this->number,
            'created_at' => Carbon::make($this->createdAt)->format('Y-m-d H:i:s'),
        ];
    }
}
