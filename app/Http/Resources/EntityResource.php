<?php

namespace App\Http\Resources;

use App\Models\Entity;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->resource instanceof Entity) {
            $children = [...$this->subEntities, ...$this->employees];
        } else {
            $children = [];
        }


        return [
            'id' => $this->id,
            'data' => [
                'name' => $this->name,
                'supervisor' => $this->supervisor ?? "",
            ],
            'children' => EntityResource::collection($children)
        ];
    }
}
