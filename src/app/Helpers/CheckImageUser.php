<?php
    if (!function_exists('checkImageUser')) {
        function checkImageUser()
        {
            if (Auth::user()->image)
            {
                echo "<img src='".Auth::user()->image."'/>";
            }
            else{
                echo "<img src='/storage/photos/2/avatar/thumbs/user.jpg'/>";
            }
        }
    }

