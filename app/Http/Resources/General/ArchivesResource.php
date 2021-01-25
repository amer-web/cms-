<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Resources\Json\JsonResource;

class ArchivesResource extends JsonResource
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
            'date' => date('M Y', mktime(0,0,0,$this->month, 1,$this->year)),
            'url' => route('archives.api',['date' =>$this->month, 'year'=>$this->year]),

        ];
    }
}
