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
$dwpar2cron_cfg = file_exists("/boot/config/plugins/dwpar2cron/dwpar2cron.cfg") ? parse_ini_file("/boot/config/plugins/dwpar2cron/dwpar2cron.cfg") : [];

$dwpar2cron_cron = trim(isset($dwpar2cron_cfg['CRON']) ? htmlspecialchars($dwpar2cron_cfg['CRON']) : 'disable');
$dwpar2cron_cronhour = trim(isset($dwpar2cron_cfg['CRONHOUR']) ? htmlspecialchars($dwpar2cron_cfg['CRONHOUR']) : '1');
$dwpar2cron_crondow = trim(isset($dwpar2cron_cfg['CRONDOW']) ? htmlspecialchars($dwpar2cron_cfg['CRONDOW']) : '0');
$dwpar2cron_crondom = trim(isset($dwpar2cron_cfg['CRONDOM']) ? htmlspecialchars($dwpar2cron_cfg['CRONDOM']) : '1');

$dwpar2cron_moverstart = trim(isset($dwpar2cron_cfg['MOVERSTART']) ? htmlspecialchars($dwpar2cron_cfg['MOVERSTART']) : 'disable');
$dwpar2cron_paritystart = trim(isset($dwpar2cron_cfg['PARITYSTART']) ? htmlspecialchars($dwpar2cron_cfg['PARITYSTART']) : 'disable');
$dwpar2cron_croncreate = trim(isset($dwpar2cron_cfg['CRONCREATE']) ? htmlspecialchars($dwpar2cron_cfg['CRONCREATE']) : 'enable');

$dwpar2cron_startnotify = trim(isset($dwpar2cron_cfg['STARTNOTIFY']) ? htmlspecialchars($dwpar2cron_cfg['STARTNOTIFY']) : 'disable');
$dwpar2cron_finishnotify = trim(isset($dwpar2cron_cfg['FINISHNOTIFY']) ? htmlspecialchars($dwpar2cron_cfg['FINISHNOTIFY']) : 'disable');
$dwpar2cron_errornotify = trim(isset($dwpar2cron_cfg['ERRORNOTIFY']) ? htmlspecialchars($dwpar2cron_cfg['ERRORNOTIFY']) : 'enable');

$dwpar2cron_running = !empty(shell_exec("pgrep -x par2cron 2>/dev/null"));
$dwpar2cron_par2_version = htmlspecialchars(trim(shell_exec("par2 -V 2> /dev/null") ?? "n/a"));
$dwpar2cron_par2_backend = htmlspecialchars(trim(shell_exec("find /var/log/packages/ -type f -iname 'par2cmdline-*' -printf '%f\n' 2> /dev/null") ?? "n/a"));
$dwpar2cron_par2cron_version = htmlspecialchars(trim(shell_exec("par2cron -v 2> /dev/null") ?? "n/a"));
$dwpar2cron_par2cron_backend = htmlspecialchars(trim(shell_exec("find /var/log/packages/ -type f -iname 'par2cron-*' -printf '%f\n' 2> /dev/null") ?? "n/a"));
?>
