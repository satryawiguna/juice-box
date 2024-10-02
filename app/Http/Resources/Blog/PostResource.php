<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $resource = [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'publish_date' => $this->publish_date,
            'content' => $this->content,
            'status' => $this->status
        ];

        return $resource;
    }
}
