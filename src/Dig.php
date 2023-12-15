<?php

declare(strict_types=1);

namespace Yggverse\Dns;

class Dig
{
    private static function _records(): array
    {
        return
        [
            'A'    => function(string $value): bool {return false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);},
            'AAAA' => function(string $value): bool {return false !== filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);},
            // ...
        ];
    }

    public static function isHostName(string $hostname): bool
    {
        return false !== filter_var($hostname, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);
    }

    public static function isRecord(string $record): bool
    {
        return isset(self::_records()[$record]);
    }

    public static function isRecordValue(string $record, string $value): bool
    {
        return isset(self::_records()[$record]) && self::_records()[$record]($value);
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