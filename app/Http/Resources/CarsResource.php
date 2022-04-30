<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="CarsResource",
 *     description="Cars resource",
 *     @OA\Xml(
 *         name="CarsResource"
 *     )
 * )
 */
class CarsResource extends JsonResource
{

    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\Car[]
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
            'type' => 'Cars',
            'attributes' => [
                'model' => $this->model,
                'sign' => $this->sign,
                'occuped_by' => (string)$this->occuped_by
            ]
        ];
    }
}
