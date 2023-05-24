<?php

namespace App\Helpers;

class PrimitiveData
{
    /**
     * function repeater
     *
     * @param mixed $content, int $repeatCount
     * @return array
     */
    public static function repeater(
        mixed $content,
        int $repeatCount
    ): array {
        try {
            $repeatCount = $repeatCount > 0 ? $repeatCount : 1;
            $json = json_encode($content);

            return json_decode(
                sprintf('[%s]', trim(str_repeat("{$json}, ", $repeatCount), '\ \,')),
                true
            ) ?: [];
        } catch (\Throwable $th) {
            return [];
        }
    }
}
