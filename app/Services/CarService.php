<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Http\Response;
use App\Models\Car;
use App\Models\Driver;
use App\Http\Resources\CarsResource;

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
     * Возвращает пустую машину
     *
     * @return Car
     */
    public static function getEmptyCar() {
        return Car::query()->where('occuped_by', null)->first();
    }

    /**
     * Проверяет, пуста ли машина
     *
     * @param int $id
     * @return bool
     */
    public static function isCarEmpty(int $id) {
        return (Car::query()->where(['id'=>$id, 'occuped_by'=>null])->first() === null) ? false : true;
    }

    /**
     * Возвращает машину по ее ID
     *
     * @param int $id
     * @return Car
     */
    public static function getCarByID(int $id) {
        return Car::find($id);
    }

    /**
     * Бронирует машину
     *
     * @param int $driverId
     * @param int $carId
     * @return \Illuminate\Http\Response
     */
    public static function bookCar($driverId, $carId) {
        if (!Driver::find($driverId))
            return ApiMessageService::resultMessage('Пользователь с указанным ID не найден', false, 403);
        if (!$car = Car::find($carId))
            return ApiMessageService::resultMessage('Автомобиль с указанным ID не найден', false, 403);
        if (!DriverService::isDriverFree($driverId)) {
            return ApiMessageService::resultMessage('Указанный водитель ['.$driverId.'] уже занят');
        }
        if (!CarService::isCarEmpty($carId)) {
            return ApiMessageService::resultMessage('Указанная машина ['.$carId.'] уже занята');
        }
        $car->update(['occuped_by'=>$driverId]);
        return new CarsResource($car);
    }

    /**
     * Освобождает машину
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public static function releaseCar(int $id) {
        if (!$car = Car::find($id))
            return ApiMessageService::resultMessage('Автомобиль с указанным ID не найден', false, 403);
            $car->update(['occuped_by'=>null]);
        return new CarsResource($car);
    }
}
