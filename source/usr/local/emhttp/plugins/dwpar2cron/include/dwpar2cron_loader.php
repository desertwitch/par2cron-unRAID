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
$return = "";
$logFile = $_GET['file'] ?? '/tmp/test.json';
$limit = intval($_GET['limit'] ?? 1000);
$levels = isset($_GET['levels']) ? explode(',', $_GET['levels']) : null;
$search = isset($_GET['search']) ? strtolower($_GET['search']) : null;

function passesFilter($log, $levels, $search) {
    if ($levels) {
        $level = strtolower($log['level'] ?? 'other');
        if (!in_array($level, $levels)) return false;
    }
    if ($search) {
        $text = strtolower(json_encode($log));
        if (strpos($text, $search) === false) return false;
    }
    return true;
}

function getLevelClass($level) {
    switch (strtolower($level)) {
        case 'error': return 'ms-level-error';
        case 'warn': case 'warning': return 'ms-level-warn';
        case 'info': return 'ms-level-info';
        case 'debug': return 'ms-level-debug';
        default: return 'ms-level-default';
    }
}

function getRowClass($level) {
    switch (strtolower($level)) {
        case 'error': return 'ms-row-error';
        case 'warn': case 'warning': return 'ms-row-warn';
        default: return '';
    }
}

function formatTime($time) {
    if (is_numeric($time)) return date('D, d M Y H:i:s T', $time);
    if (strtotime($time) !== false) return date('D, d M Y H:i:s T', strtotime($time));
    return htmlspecialchars($time);
}

function formatValue($value) {
    if (is_bool($value)) return $value ? 'true' : 'false';
    if (is_array($value)) return htmlspecialchars(json_encode($value));
    return htmlspecialchars((string) $value);
}

function generateLogRow($log) {
    $timestamp = formatTime($log['time'] ?? '');
    $level = $log['level'] ?? 'info';
    $message = htmlspecialchars($log['msg'] ?? $log['message'] ?? '');

    $details = '';
    foreach ($log as $k => $v) {
        if (!in_array($k, ['time', 'level', 'msg', 'message'])) {
            $details .= '<div class="ms-detail-item">
                <span class="ms-detail-key">' . htmlspecialchars($k) . ':</span>
                <span class="ms-detail-value">' . formatValue($v) . '</span>
            </div>';
        }
    }

    $rowClass = getRowClass($level);
    $levelClass = getLevelClass($level);
    $rowClassAttr = $rowClass ? $rowClass . ' ' : '';

    return '<tr class="ms-log-row ms-virtual-row ' . $rowClassAttr . '" data-level="' . strtolower($level) . '">
        <td class="ms-log-cell ms-timestamp">' . $timestamp . '</td>
        <td class="ms-log-cell"><span class="ms-level ' . $levelClass . '">' . strtoupper(htmlspecialchars($level)) . '</span></td>
        <td class="ms-log-cell">
            <div class="ms-message">' . $message . '</div>
            <div class="ms-details">' . $details . '</div>
        </td>
    </tr>';
}

function generateRawFileRow($rawContent) {
    $safe = htmlspecialchars($rawContent);
    return '<tr class="ms-log-row ms-virtual-row ms-row-error" data-level="error">
        <td class="ms-log-cell ms-timestamp">' . formatTime(time()) . '</td>
        <td class="ms-log-cell"><span class="ms-level ms-level-error">ERROR</span></td>
        <td class="ms-log-cell">
            <div class="ms-message">Unable to parse response as JSON.</div>
            <div class="ms-details"><pre style="white-space: pre-wrap; font-family: monospace;">' . $safe . '</pre></div>
        </td>
    </tr>';
}

try {
    $logs = [];
    $lines = [];

    if (file_exists($logFile)) {
        $fp = fopen($logFile, 'r');
        fseek($fp, 0, SEEK_END);
        $pos = ftell($fp);
        $buffer = '';

        while ($pos > 0 && count($lines) < $limit * 2) {
            $readSize = min(8192, $pos);
            $pos -= $readSize;
            fseek($fp, $pos);
            $buffer = fread($fp, $readSize) . $buffer;

            $chunks = explode("\n", $buffer);
            $buffer = array_pop($chunks); // last partial
            $lines = array_merge($chunks, $lines);
        }

        fclose($fp);

        $validJsonFound = false;
        $hasFilteredMatches = false;

        foreach (array_reverse($lines) as $line) {
            $line = trim($line);
            if ($line === '') continue;

            $entry = json_decode($line, true);
            if (json_last_error() !== JSON_ERROR_NONE) continue;

            $validJsonFound = true;

            if (passesFilter($entry, $levels, $search)) {
                $logs[] = generateLogRow($entry);
                $hasFilteredMatches = true;
                if (count($logs) >= $limit) break;
            }
        }

        if (!$validJsonFound) {
            // No parseable JSON at all
            $raw = file_get_contents($logFile);
            $logs[] = generateRawFileRow($raw);
            $logCount = 1;
        } else {
            // Parseable JSON found - whether or not it matched filter
            $logCount = $hasFilteredMatches ? count($logs) : 0;
        }

        $return = json_encode([
            'success' => true,
            'rows' => $logs,
            'logCount' => $logCount,
            'fileExists' => true
        ]);
    } else {
        $return = json_encode([
            'success' => false,
            'error' => 'There is no log file (yet)',
            'rows' => [],
            'logCount' => 0,
            'fileExists' => false
        ]);
    }
} catch (\Thorwable $t) {
        $return = json_encode([
            'success' => false,
            'error' => htmlspecialchars($t->getMessage()),
            'rows' => [],
            'logCount' => 0,
            'fileExists' => false
        ]);
} finally {
    header('Content-Type: application/json');
    echo $return;
}
?>
