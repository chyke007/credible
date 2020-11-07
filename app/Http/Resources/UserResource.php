<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
        'id' => $this->id,   
        'first_name' => $this->first_name,
        'last_name' => $this->last_name,
        'email' => $this->email,
        'last_login' => $this->last_login,
        'date_added' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s'): null,
        ];
    }
    public function with($request){
        return [
            'version' => '1.0.0',
            'author_url' => url('http://chibuikenwa.com')
        ];
    }
}
