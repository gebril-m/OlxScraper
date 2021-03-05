<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdsResource extends JsonResource
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

            'id'=>$this->id,
            'title'=>$this->title,
            'phone'=>$this->phone,
            'details'=>$this->details,
            'price'=>$this->price,
            'address'=>$this->address,
            'supplier_name'=>$this->supplier_name,
            'advertisings_date'=>$this->advertisings_date,
            'supplier_count_ads'=>$this->supplier_count_ads,
            'rooms'=>$this->rooms,
            'area'=>$this->area,
            'floor'=>$this->floor,
            'type'=>$this->type,
            'aqar_type'=>$this->aqar_type,
            'images'=>json_decode($this->images),

        ];
    }
}
