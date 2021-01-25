<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'created_at' => $this->created_at->format('d M Y, h:i a'),
            'url' => route('show-post.api', $this->slug),
            'user'  =>  new UserResource($this->user),
            'category' => $this->category->name,
            'media' => $this->media
        ];
    }
}
