<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Car",
 *     description="Модель автомобиля",
 *     @OA\Xml(
 *         name="Car"
 *     )
 * )
 */
class Car extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example="1"
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *     title="model",
     *     description="Модель автомобиля",
     *     example="Mersedes Benz"
     * )
     *
     * @var string
     */
    protected $model;

    /**
     * @OA\Property(
     *     title="sign",
     *     description="Номерной знак автомобиля",
     *     example="S123ZX"
     * )
     *
     * @var string
     */
    protected $sign;

    /**
     * @OA\Property(
     *     title="occuped_by",
     *     description="ID пользователя, забронировавшего авто",
     *     format="int64",
     *     example="1"
     * )
     *
     * @var integer
     */
    protected $occuped_by;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'model',
        'sign',
        'occuped_by',
    ];
}
