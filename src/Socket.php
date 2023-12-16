<?php

declare(strict_types=1);

namespace Yggverse\Net;

class Socket
{
    public static function isIPv4(mixed $value): bool
    {
        return false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    public static function isIPv6(mixed $value): bool
    {
        return false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }

    public static function isHostName(mixed $value): bool
    {
        return false !== filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);
    }

    public static function isHost(mixed $value): bool
    {
        return
        (
            is_string($value) &&
            (
                false !== self::isIPv4($value) ||
                false !== self::isIPv6($value) ||
                false !== self::isHostName($value)
            )
        );
    }

    public static function isPort(mixed $value): bool
    {
        if (false === filter_var($value, FILTER_VALIDATE_INT))
        {
            return false;
        }

        return
        (
            0 < $value && 65536 > $value
        );
    }

    public static function isOpen(string $host, int $port = -1, ?float $timeout = null, int &$error_code = null, string &$error_message = null): bool
    {
        if (self::isHost($host) && self::isPort($port))
        {
            $connection = @fsockopen(
                self::isIPv6($host) ? "[$host]" : $host, // PHP is shit 💩.
                $port,
                $error_code,
                $error_message,
                $timeout
            );

            if (is_resource($connection))
            {
                return fclose(
                    $connection
                );
            }
        }

        return false;
    }
}