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

    /**
     * Возвращает водителя по его ID
     *
     * @param int $id
     * @return Driver
     */
    public static function getDriverByID(int $id) {
        return Driver::find($id);
    }
}
