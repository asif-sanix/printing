<?php

namespace App\Http\Resources\Admin\MaterialOrder;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
class MaterialOrderResource extends JsonResource
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
            'sn'=>++$request->start,
            'id'=>$this->id,
            'mo_no'=>@$this->order_no, 
            'vendor'=>@$this->vendor->name, 
            'mo_date'=>@$this->mo_date->format('d F, Y'), 
            'subtotal'=>@$this->subtotal, 
            'total_gst'=>@$this->total_gst, 
            'total'=>@$this->total, 
            'created_at' => @$this->created_at->format('d F, Y'),
        ];
    }
}
