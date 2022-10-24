<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "first_name" => $this->name,
            "last_name" => $this->salary,
            "email" => $this->email,
            "photo" => $this->photo,
            "acount_role" => $this->acount_role,
            "address" => $this->address,
            "last_login" => $this->last_login,
            "account_status" => $this->account_status,
        ];
    }
}
