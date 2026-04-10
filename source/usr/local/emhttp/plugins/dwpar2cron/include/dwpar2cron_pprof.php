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
$files = glob("/tmp/par2cron-pprof-*.pb.gz");
if (!empty($files)) {
    usort($files, function($a, $b) { return filemtime($b) - filemtime($a); });
    $file = $files[0];
    header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
    header("Content-Type: application/octet-stream");
    header("Content-Length: " . filesize($file));
    header("Connection: close");
    readfile($file);
    exit;
} else {
    echo("<h3>No diagnostic profile was found!</h3>");
}
?>
