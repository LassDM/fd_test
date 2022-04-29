<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Model;
use App\Models\Driver;
use App\Models\Car;

class DriverService
{
    /**
     * Проверяет, свободен ли водитель
     *
     * @param int $id
     * @return bool
     */
    public static function isDriverFree(int $id) {
        return (Car::query()->where('occuped_by', $id)->first() === null) ? true : false;
    }

}
