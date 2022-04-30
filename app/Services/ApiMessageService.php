<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class ApiMessageService
{
    /**
     * Для вывода сообщения
     *
     * @param string $message
     * @param bool $result
     * @return string
     */
    public static function resultMessage(string $message, bool $result = false) {
        return Response()->json([
            'data' => [
                'result' => $result,
                'message' => $message
            ]
        ]);
    }
}
