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
function dwpar2cron_share_options($selected = '') {
    if (is_string($selected)) {
        $selected_values = explode("|", $selected);
    } elseif (is_array($selected)) {
        $selected_values = $selected;
    } else {
        $selected_values = [];
    }

    $shares = parse_ini_file('state/shares.ini', true);
    if (!$shares) $shares = [];

    uksort($shares, 'strnatcasecmp');

    $out = '';

    $array_val = '/mnt/user';
    $is_array_sel = in_array($array_val, $selected_values) ? ' selected' : '';
    $out .= "<option value=\"$array_val\"$is_array_sel>-- Array --</option>\n";

    foreach ($shares as $share) {
        $name = $share["name"];
        $value = '/mnt/user/' . $name;

        $sel = in_array($value, $selected_values) ? ' selected' : '';

        $out .= "<option value=\"$value\"$sel>$name</option>\n";
    }

    return $out;
}

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
