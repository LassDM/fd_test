<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Services\CarService;
use App\Services\DriverService;
use Illuminate\Http\Request;
use App\Http\Resources\CarsResource;
use App\Services\ApiMessageService;

class CarsController extends Controller
{

    protected $model = Car::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CarsResource::collection(Car::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarRequest $request)
    {
        $car = Car::create([
            'model' => $request->input('model'),
            'sign' => $request->input('sign'),
            'occuped_by' => null,
        ]);
        return new CarsResource($car);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $car = CarService::getCarByID($id);
        if (!$car)
            return ApiMessageService::resultMessage('Машины с таким id не существует');
        return new CarsResource($car);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarRequest  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarRequest $request, int $id)
    {
        $car = Car::find($id);
        if (!$car)
            return ApiMessageService::resultMessage('Машины с таким id не существует');
        $car->update([
            'model' => $request->input('model'),
            'sign' => $request->input('sign'),
            'occuped_by' => null,
        ]);
        return new CarsResource($car);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $car = Car::find($id);
        if ($car && $car->occuped_by === null) {
            $car->delete();
            return ApiMessageService::resultMessage('Машина удалена', true);
        } elseif($car && $car->occuped_by !== null) {
            return ApiMessageService::resultMessage('Машина ['.$id.'] сейчас используется');
        }
        return ApiMessageService::resultMessage('Машины с id ['.$id.'] не существует');
    }

    /**
     * Бронируем свободную машину
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bookCar(Request $request)
    {
        return CarService::bookCar($request->input('driver_id'), $request->input('car_id'));
    }

    /**
     * Освобождаем занятую машину
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function releaseCar(Request $request)
    {
        return CarService::releaseCar($request->input('car_id'));
    }
}
