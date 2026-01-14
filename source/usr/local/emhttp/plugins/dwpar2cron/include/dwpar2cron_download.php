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
$logFile = "/tmp/dwpar2cron.log";
if(file_exists($logFile)) {
    header("Content-Disposition: attachment; filename=\"" . basename($logFile) . ".txt\"");
    header("Content-Type: application/octet-stream");
    header("Content-Length: " . filesize($logFile));
    header("Connection: close");
    readfile($logFile);
    exit;
} else {
    echo("There is no log file to download at: <code>/tmp/dwpar2cron.log</code>");
}
?>
