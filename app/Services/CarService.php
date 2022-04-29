<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Http\Response;
use App\Models\Car;

class CarService
{
    /**
     * Для генерации знака авто
     *
     * @return string
     */
    public static function generateRandomSign() {
        $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($charset), 0, 1).
                mt_rand(100, 999).
                substr(str_shuffle($charset), 0, 2);
    }

    /**
     * Возвращаем пустую машину
     *
     * @return Car
     */
    public static function getEmptyCar() {
        return Car::query()->where('occuped_by', null)->first();
    }

    /**
     * Проверяем, пуста ли машина
     *
     * @param int $id
     * @return bool
     */
    public static function isCarEmpty(int $id) {
        return (Car::query()->where(['id'=>$id, 'occuped_by'=>null])->first() === null) ? false : true;
    }

    /**
     * Возвращаем машину по ее ID
     *
     * @return Car
     */
    public static function getCarByID($id) {
        return Car::find($id);
    }

    /**
     * Бронируем машину
     *
     * @param int $driverId
     * @param int $carId
     * @return \Illuminate\Http\Response
     */
    public static function bookCar($driverId, $carId) {
        if (!DriverService::isDriverFree($driverId)) {
            return response()->json(
                [
                    'result' => false,
                    'message' => 'Указанный водитель ['.$driverId.'] уже занят'
                ]
            );
        }
        if (!CarService::isCarEmpty($carId)) {
            return response()->json(
                [
                    'result' => false,
                    'message' => 'Указанная машина ['.$carId.'] уже занята'
                ]
            );
        }
        Car::find($carId)->update(['occuped_by'=>$driverId]);
        $car = Car::find($carId);
        return response()->json(
            [
                'car' => $car
            ]
        );
    }
}
