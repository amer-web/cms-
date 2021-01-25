<?php

namespace App\Http\Resources\UserDash;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentsEditResource extends JsonResource
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
            'comment' => $this->comment,
            'status' => ($this->status == 1)? 'Active' : 'InActive'
        ];
    }
}
