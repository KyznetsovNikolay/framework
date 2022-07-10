<?php

declare(strict_types=1);

namespace Framework\Utils;

use Throwable;

class Utils
{
    /**
     * @param Throwable $e
     * @return int
     */
    public static function getStatusCode(Throwable $e): int
    {
        $code = $e->getCode();
        if ($code >= 400 && $code < 600) {
            return $code;
        }
        return 500;
    }
}
