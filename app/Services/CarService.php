<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Model;

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
        return \App\Models\Car::query()->whereNot('occuped_by', null)->first();
    }
}
