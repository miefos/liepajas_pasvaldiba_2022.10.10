<?php

namespace App\Http\Resources;

use App\Models\Entity;
use App\Models\EntityLevel;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class EntitiesForTableResource extends JsonResource
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
        if ($this->resource instanceof User) {
            $entity = Entity::findOrFail($this->entity_id);

            return [
                'id' => $this->id,
                'name' => $this->name,
                'parent_entity_id' => $this->entity_id,
                'entity_level_id' => EntityLevel::where('employee_level', '=', 1)->firstOrFail()->id ?? null,
                'supervisor_id' => $entity->supervisor_id,
            ];
        } else { // Entity
            return [
                'id' => $this->id,
                'name' => $this->name,
                'parent_entity_id' => $this->parent_entity_id,
                'entity_level_id' => $this->entity_level_id,
                'supervisor_id' => $this->supervisor_id
            ];
        }
    }
}
