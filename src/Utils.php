<?php

class Utils
{
    public static function verifyParams(array $params, bool $inPost = true): bool
    {
        return self::arrayReduce($params, $inPost ? $_POST : $_GET);
    }
    
    public static function arrayReduce(array $needles, array $haystack): bool
    {
        return array_reduce(
            $needles, 
            fn (bool $carry, string $item): bool =>
                !$carry ? $carry : (array_key_exists($item, $haystack) && !empty($haystack[$item])),
            true
        );
    }
}