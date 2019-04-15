<?php

namespace App\Http\Resources;


use App\Photo;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed about
 * @property mixed carousel
 * @property mixed created_at
 * @property mixed photo
 * @property mixed title
 * @property mixed description
 */
class LayoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if(!isset($this->created_at)){
            return parent::toArray($request);
        }
        return [
            'about' => $this->about,
            'carousel' => $this->cover,
            'description' => $this->when(!is_null($this->description), $this->description),
            'created_at' => $this->created_at,
            // 'photo' => $this->when(!is_null($this->photo), $this->photo->name),
            'photo' => $this->when($this->photo, function () {
                        return $this->photo->name;
            }, function(){
                return Photo::withTrashed()->find($this->photo_id)->name;
            }),
            'title' => $this->title,
        ];
    }
}
