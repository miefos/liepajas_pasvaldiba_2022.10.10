<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoalsSimpleResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'comment' => $this->comment,
            'user_id' => $this->user_id,
            'entity_id' => $this->entity_id,
            'parent_goal_id' => $this->parent_goal_id,
            'complete_level_id' => $this->complete_level_id,
            'editable' => $this->editableByCurrentUser(),
            'audits' => $this->audits,
            'approved' => $this->approved,
            'should_be_bold' => $this->shouldBeBold(),
        ];
    }
}
