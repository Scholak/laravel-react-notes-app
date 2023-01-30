<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request)
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
