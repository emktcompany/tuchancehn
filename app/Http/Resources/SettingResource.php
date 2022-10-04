<?php

namespace App\Http\Resources;

class SettingResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'value'      => $this->value,
            'type'       => $this->type,
            'cast'       => $this->cast,
            'label'      => $this->label,
            'key'        => $this->key,
            'options'    => $this->options,
            'created_at' => $this->asDate('created_at'),
        ];
    }
}
