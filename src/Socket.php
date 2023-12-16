<?php

declare(strict_types=1);

namespace Yggverse\Net;

class Socket
{
    public static function isHost(mixed $value): bool
    {
        return
        (
            is_string($value) &&
            (
                false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ||
                false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ||
                false !== filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)
            )
        );
    }

    public static function isPort(mixed $value): bool
    {
        $length = strlen(
            $value
        );

        return false !== filter_var($value, FILTER_VALIDATE_INT) && 0 < $length && 65536 > $length;
    }

    public static function isOpen(string $host, int $port = -1, ?float $timeout = null, int &$error_code = null, string &$error_message = null): bool
    {
        if (self::isHost($host) && self::isPort($port))
        {
            return is_resource(
                @fsockopen(
                    $host,
                    $port,
                    $error_code,
                    $error_message,
                    $timeout
                )
            );
        }

        return false;
    }
}