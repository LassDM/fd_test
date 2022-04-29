<?php

namespace App\Services;

class ApiJsonService
{
    /**
     * Вернуть ответ по апи
     *
     * @return json
     */
    public static function answer($status, $data, $attributes) {
        return json_decode('dsd', JSON_UNESCAPED_UNICODE);
    }

}
