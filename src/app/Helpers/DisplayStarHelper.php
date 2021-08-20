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

if (!function_exists('displayStatusOrder')) {
    function displayStatusOrder($status)
    {
        if ($status === \App\Enums\Status::BLOCK) {
            return "<span class='label label-warning'>" . __('custom.message_order_processing') . "</span>";
        }
        return "<span class='label label-success'>" . __('custom.message_order_success') . "</span>";
    }
}
