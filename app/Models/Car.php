<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public $timestamps = false;

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

    /**
     * For car sign generetion
     *
     * @return string
     */
    public static function generateRandomSign() {
        $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($charset), 0, 1).
                mt_rand(100, 999).
                substr(str_shuffle($charset), 0, 2);
    }
}
