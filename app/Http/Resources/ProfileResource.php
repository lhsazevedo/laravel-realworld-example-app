<?php

namespace App\Http\Resources;

use App\Http\Resources\Json\JsonResource as JsonResource;
use Illuminate\Support\Arr;

class ProfileResource extends JsonResource
{
    public static $wrap = 'profile';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'username' => $this->username,
            'bio' => $this->bio,
            'image' => $this->image,
            'following' => $this->following
        ];

        // return Arr::only(parent::toArray($request), [
            // 'username', 'bio', 'image', 'following'
        // ]);
    }
}
