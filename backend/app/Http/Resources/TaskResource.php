<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array|Arrayable|\JsonSerializable
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'completed' => $this->completed,
            'user' => $this->user,
            'created_at' => [
                'date' => $this->created_at,
                'diffForHumans' => $this->created_at->diffForHumans()
            ],
        ];
    }
}
