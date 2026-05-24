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
header('Content-Type: application/json');
$pidfile = "/var/run/dwpar2cron.pid";

$running = false;
$pidfile_exists = false;

if (file_exists($pidfile)) {
    $pidfile_exists = true;

    $pid = trim(file_get_contents($pidfile));
    if ($pid && file_exists("/proc/$pid")) {
        $running = true;
    }
}

if (!$running) {
    $status = shell_exec("pgrep -x par2cron 2>/dev/null || pgrep -x par2cron-cron 2>/dev/null || pgrep -x cmd_info 2>/dev/null || pgrep -x cmd_other 2>/dev/null");
    $running = !empty($status);
}

if ($pidfile_exists && !$running) {
    @unlink($pidfile);
}

$progress = '';
if ($running) {
    $last = shell_exec("tail -c 4096 /var/log/dwpar2cron/log/current 2>/dev/null | tr '\\r' '\\n' | grep '%' | tail -1");
    if (!empty($last)) {
        $progress = trim($last);
    }
}

echo json_encode(['running' => $running, 'progress' => $progress]);
?>
