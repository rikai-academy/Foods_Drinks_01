<?php
if (!function_exists('displayStar')) {
    function displayStar()
    {
        $htmlStar = '';
        for($i = 1; $i < 6; $i++) {
            $htmlStar .= "<i class=\"fa fa-star product-star-rating\" id=\"starRating$i\" aria-hidden=\"true\"></i>&nbsp;";
        }
        return $htmlStar;
    }
}
