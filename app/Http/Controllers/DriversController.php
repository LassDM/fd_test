<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Driver;
use App\Models\Car;
use App\Services\DriverService;
use App\Http\Resources\DriversResource;
use App\Services\ApiMessageService;
use \Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Пользователи",
 *     description="API для работы с пользователями"
 * )
 * @OA\PathItem(
 *      path="/drivers",
 * )
 */
class DriversController extends Controller
{

    protected $model = Driver::class;

    /**
     * @OA\Get(
     *      path="/drivers",
     *      operationId="getDriversList",
     *      tags={"Пользователи"},
     *      summary="Получить список пользователей",
     *      description="Возвращает список пользователей",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/DriversResource")
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
        return DriversResource::collection(DriverService::getDrivers());
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
     * @param  \App\Http\Requests\StoreDriverRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDriverRequest $request)
    {
        $driver = Driver::create([
            'name' => $request->input('name')
        ]);
        return new DriversResource($driver);
    }

    /**
     * @OA\Get(
     *      path="/drivers/{id}",
     *      operationId="getDriverById",
     *      tags={"Пользователи"},
     *      summary="Получить информацию о пользователе",
     *      description="Возвращает информацию об указанном пользователе",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID пользователя",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/DriversResource")
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
        $driver = DriverService::getDriverByID($id);
        if (!$driver)
            return ApiMessageService::resultMessage('Водителя с таким id не существует');
        $driver->setAttribute('free', DriverService::isDriverFree($id));
        return new DriversResource($driver);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDriverRequest  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDriverRequest $request, int $id)
    {
        $driver = Driver::find($id);
        if (!$driver)
            return ApiMessageService::resultMessage('Водителя с таким id не существует');
        $driver->update([
            'name' => $request->input('name')
        ]);
        return new DriversResource($driver);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (Car::query()->where('occuped_by', $id)->first() !== null) {
            return ApiMessageService::resultMessage('Невозможно удалить водителя ['.$id.'], он сейчас за рулем');
        }
        $driver = Driver::find($id);
        if ($driver) {
            $driver->delete();
            return ApiMessageService::resultMessage('Водитель удален', true);
        }
        return ApiMessageService::resultMessage('Водителя с id ['.$id.'] не существует');
    }
}
