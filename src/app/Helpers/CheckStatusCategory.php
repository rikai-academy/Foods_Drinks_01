<?php
use App\Enums\Status;
    if (!function_exists('checkStatusCategory')) {
        function checkStatusCategory($status)
        {
            $options_status = ($status == Status::getValue('ACTIVE')) ?
            "<option value='1' selected>".__('custom.Show')."</option><option value='0'>".__('custom.Hidden')."</option>" :
            "<option value='0' selected>".__('custom.Hidden')."</option><option value='1'>".__('custom.Show')."</option>";
            return $options_status;
        }
    }

