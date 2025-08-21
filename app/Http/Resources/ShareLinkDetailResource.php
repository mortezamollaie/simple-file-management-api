<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShareLinkDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_email' => $this->user->email,
            'file_name' => $this->file->name,
            'url' => $this->full_path,
            'expires_time' => $this->expires_time,
            'is_active' => $this->valid_link,
            'admin_url' => $this->admin_path,
            'time_to_expire' => $this->expires_time,
        ];
    }
}
