<?php
    if (!function_exists('checkGenderUser')) {
        function checkGenderUser()
        {
            if (Auth::user()->gender == 1)
            {
                echo "<option value='1' selected>".__('custom.Male')."</option><option value='0'>".__('custom.Female')."</option>";
            }
            else{
                echo "<option value='1'>".__('custom.Male')."</option><option value='0' selected>".__('custom.Female')."</option>";
            }
        }
    }

