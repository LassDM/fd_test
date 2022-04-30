<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="DriversResource",
 *     description="Drivers resource",
 *     @OA\Xml(
 *         name="DriversResource"
 *     )
 * )
 */
class DriversResource extends JsonResource
{

    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\Driver[]
     */
    private $data;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'type' => 'Drivers',
            'attributes' => [
                'name' => $this->name,
                'free' => $this->free
            ]
        ];
    }
}
