<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Документация к тестовому заданию",
 *      description="<b>Ключ для авторизации:</b> d2h738dh2ud9j27d829deu29e8dyj2j<br/><br/><b>Примечание:</b> ради скорости разработки опущены методы добавления/изменения/удаления сущностей. Таблицы БД заполняются сидерами.",
 *      @OA\Contact(
 *          email="dmitriylasarev@gmail.com"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     securityScheme="api_key",
 *     name="api_key"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
