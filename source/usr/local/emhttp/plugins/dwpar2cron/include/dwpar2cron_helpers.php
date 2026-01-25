<?
/* Copyright Derek Macias (parts of code from NUT package)
 * Copyright macester (parts of code from NUT package)
 * Copyright gfjardim (parts of code from NUT package)
 * Copyright SimonF (parts of code from NUT package)
 * Copyright Dan Landon (parts of code from Web GUI)
 * Copyright Bergware International (parts of code from Web GUI)
 * Copyright Lime Technology (any and all other parts of Unraid)
 *
 * Copyright desertwitch (as author and maintainer of this file)
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 */
function dwpar2cron_hour_options($time){
    $dwpar2cron_options = '';
        for($i = 0; $i <= 23; $i++){
            $dwpar2cron_options .= '<option value="'.$i.'"';
            if(intval($time) === $i)
                $dwpar2cron_options .= ' selected';

            $dwpar2cron_options .= '>'.$i.':00</option>';
        }
    return $dwpar2cron_options;
}

function dwpar2cron_dom_options($time){
    $dwpar2cron_options = '';
        for($i = 1; $i <= 31; $i++){
            $dwpar2cron_options .= '<option value="'.$i.'"';
            if(intval($time) === $i)
                $dwpar2cron_options .= ' selected';

            $dwpar2cron_options .= '>'.$i.'</option>';
        }
    return $dwpar2cron_options;
}
?>
