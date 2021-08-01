<?php
    if (!function_exists('checkLanguage')) {
        function checkLanguage($result1, $result2)
        {
            if (session('website_language') == 'en')
            {
                return $result1;
            }
            return $result2;
        }
    }

