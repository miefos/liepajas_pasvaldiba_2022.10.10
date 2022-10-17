<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoalsResource extends JsonResource
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
        return [
            'id' => $this->id,
            'key' => $this->id,
            'data' => [
                'name' => $this->name,
                'description' => $this->description,
                'completeLevel' => $this->completeLevel->name,
                'entity' => $this->entity,
            ],
            'children' => GoalsResource::collection($this->subGoals)
        ];
    }
}