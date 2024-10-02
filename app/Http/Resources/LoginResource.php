<?php

namespace App\Http\Resources;

use App\Http\Resources\PermissionCollectionResource;
use App\Http\Resources\PolicyCollectionResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $user = User::find($this->id);

        $resource = [
            'id' => $this->id,
            'email' => $this->email,
            'access_token' => $this->access_token,
            'token_type' => $this->token_type,
            'permissions' => new PermissionCollectionResource($user->permissions) ?? null,
            'policies' => new PolicyCollectionResource($user->policies) ?? null
        ];

        return $resource;
    }
}
