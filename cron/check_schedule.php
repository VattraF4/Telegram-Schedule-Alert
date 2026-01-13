<?php
// This file should be called by cron job
// Example cron: * * * * * /usr/bin/php /path/to/telegram-schedule-bot/cron/check_schedule.php

// Set time limit
set_time_limit(0);

// Include required files
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/scheduler.php';

// Execute alert check
$result = checkAndSendAlerts();

// Log the result
$logMessage = date('Y-m-d H:i:s') . " - Alerts sent: {$result['alerts_sent']}, Schedules deleted: {$result['schedules_deleted']}\n";
file_put_contents(__DIR__ . '/../data/cron.log', $logMessage, FILE_APPEND);

echo "Cron job executed successfully!\n";
echo $logMessage;
?>