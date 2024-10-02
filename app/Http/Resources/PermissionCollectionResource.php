<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollectionResource extends ResourceCollection
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
                'slug' => $value->slug
            ];
        });

        return $resources->toArray();
    }
}
