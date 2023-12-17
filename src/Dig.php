<?php

declare(strict_types=1);

namespace Yggverse\Net;

class Dig
{
    private static function _records(): array
    {
        return
        [
            'A'    => function(string $value): bool {return false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);},
            'AAAA' => function(string $value): bool {return false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);},
            'SRV'  => function(string $value): bool {return (bool) preg_match('/^[\d]+\s[\d]+\s[\d]+\s[A-z0-9-\._]+$/', $value);},
            // ...
        ];
    }

    public static function isHostName(mixed $value, array $find = ['_'], array $replace = []): bool
    {
        return is_string($value) && false !== filter_var(str_replace($find, $replace, $value), FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);
    }

    public static function isRecord(mixed $value): bool
    {
        return is_string($value) && isset(self::_records()[$value]);
    }

    public static function isRecordValue(mixed $record, mixed $value): bool
    {
        return is_string($record) &&
               is_string($value)  &&
               isset(self::_records()[$record]) && self::_records()[$record]($value);
    }

    public static function records(string $hostname, array $records, array &$result = [], array &$error = []): array
    {
        if (self::isHostName($hostname))
        {
            foreach ($records as $record)
            {
                if (self::isRecord($record))
                {
                    if ($values = exec(sprintf('dig %s %s +short', $record, $hostname)))
                    {
                        foreach (explode(PHP_EOL, $values) as $value)
                        {
                            if (self::isRecordValue($record, $value))
                            {
                                $result[$record][] = $value;
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }
}