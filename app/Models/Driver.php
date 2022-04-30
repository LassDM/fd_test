<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Driver",
 *     description="Модель пользователя",
 *     @OA\Xml(
 *         name="Driver"
 *     )
 * )
 */
class Driver extends Model
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
     *     title="name",
     *     description="Имя пользователя",
     *     example="Иван Иванов"
     * )
     *
     * @var string
     */
    protected $name;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];
}
