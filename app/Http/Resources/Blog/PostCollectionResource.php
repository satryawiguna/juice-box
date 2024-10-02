<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resources = $this->collection->map(function ($value, $key) {
            return [
                'id' => $value->id,
                'title' => $value->title,
                'slug' => $value->slug,
                'publish_date' => $value->publish_date,
                'content' => $value->content,
                'status' => $value->status
            ];
        });

        return $resources->toArray();
    }
}
