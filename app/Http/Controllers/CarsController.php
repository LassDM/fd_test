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

/**
 * @OA\Tag(
 *     name="Автомобили",
 *     description="API для работы с автомобилями"
 * )
 * @OA\PathItem(
 *      path="/cars",
 * )
 */
class CarsController extends Controller
{

    protected $model = Car::class;

    /**
     * @OA\Get(
     *      path="/cars",
     *      operationId="getCarsList",
     *      tags={"Автомобили"},
     *      summary="Получить список автомобилей",
     *      description="Возвращает список автомобилей",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CarsResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     security={
     *         {"api_key": {}}
     *     }
     *     )
     *
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
     * @OA\Get(
     *      path="/cars/{id}",
     *      operationId="getCarById",
     *      tags={"Автомобили"},
     *      summary="Получить информацию об автомобиле",
     *      description="Возвращает информацию об автомобиле по ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID автомобиля",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CarsResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     security={
     *         {"api_key": {}}
     *     }
     * )
     *
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
     * @OA\Post(
     *      path="/bookCar",
     *      operationId="bookCar",
     *      tags={"Автомобили"},
     *      summary="Бронируем автомобиль",
     *      description="Бронируем автомобиль для указанного пользователя",
     *      @OA\Parameter(
     *          name="car_id",
     *          description="ID автомобиля",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="driver_id",
     *          description="ID пользователя",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CarsResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     security={
     *         {"api_key": {}}
     *     }
     * )
     *
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
     * @OA\Post(
     *      path="/releaseCar",
     *      operationId="releaseCar",
     *      tags={"Автомобили"},
     *      summary="Освобождаем автомобиль",
     *      description="Освобождаем указанный автомобиль",
     *      @OA\Parameter(
     *          name="car_id",
     *          description="ID автомобиля",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CarsResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     security={
     *         {"api_key": {}}
     *     }
     * )
     *
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
