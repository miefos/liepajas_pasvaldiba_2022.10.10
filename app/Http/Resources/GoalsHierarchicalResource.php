<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoalsHierarchicalResource extends JsonResource
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
                'entity' => $this->entity ?? $this->user,
                'comment' => $this->comment,
                'editable' => $this->editableByCurrentUser() // indicates if the user can edit the specific goal
            ],
            'children' => GoalsHierarchicalResource::collection($this->subGoals)
        ];
    }
}
