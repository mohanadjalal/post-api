<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'body' => $this->body,
            'userId' => $this->userId,
            'created_at'=> Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
            'updated_at'=> Carbon::parse($this->updated_at)->format('d-m-Y H:i:s'),
            


        ];
    }
}
