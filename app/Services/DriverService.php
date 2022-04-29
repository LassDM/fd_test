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

    /**
     * Возвращает водителей с добавлением их занятости
     *
     * @return Driver
     */
    public static function getDrivers() {
        $drivers = Driver::all();
        $cars = Car::query()->whereNot('occuped_by', null)->get();
        $workDrivers = [];
        foreach ($cars as $car) {
            $workDrivers[] = $car->occuped_by;
        }
        foreach ($drivers as $driver) {
            if (in_array($driver->id, $workDrivers)) {
                $driver->setAttribute('free', false);
            } else {
                $driver->setAttribute('free', true);
            }
        }
        return $drivers;
    }
}
