<?php

if ( ! function_exists('array_except_assoc') ) {
    /**
     * Strips out elements with given nested keys in an array of associative arrays
     * 
     * @param array $arr
     * @param array|String $keys
     * @return mixed
     */
    function array_except_assoc($arr, $keys)
    {
        $keys = (array) $keys;

        foreach ($arr as &$i) {
            foreach ($keys as $key) {
                // Spin through every element in the array, looking recursively for the element
                // that matches the given key
                $segments = explode('.', $key, 2);

                if (count($segments) === 1) {
                    array_forget($i, $key);
                } else {
                    if (array_key_exists($segments[0], $i)) {
                        $i[$segments[0]] = array_except_assoc($i[$segments[0]], $segments[1]);
                    }
                }
            }
        }

        return $arr;
    }
}

if ( ! function_exists('array_filter_recursive') ) {
    function array_filter_recursive($arr, $callable, $flags = 0)
    {
        $ret = [];

        foreach ($arr as $i => $e) {
            if (is_array($e)) {
                $r = array_filter_recursive($e, $callable, $flags);
                if (count($r))
                    $ret[$i] = $r;
            } elseif (call_user_func($callable, $e)) {
                switch ($flags) {
                    case ARRAY_FILTER_USE_KEY:
                        $params = [$i];
                        break;
                    case ARRAY_FILTER_USE_BOTH:
                        $params = [$e, $i];
                        break;
                    default:
                        $params = [$e];
                }

                if (call_user_func_array($callable, $params))
                    $ret[$i] = $e;
            }
        }

        return $ret; 
    }
}