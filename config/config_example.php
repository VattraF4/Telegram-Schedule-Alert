<?php
// Bot Configuration
define('BOT_TOKEN', 'YOUR_BOT_TOKEN_HERE');
define('GROUP_CHAT_ID', 'YOUR_GROUP_CHAT_ID_HERE');

// JSON Data File
define('SCHEDULE_FILE', __DIR__ . '/../data/schedules.json');

// Timezone
date_default_timezone_set('Asia/Jakarta'); // Change to your timezone

// Alert Intervals (in days)
define('ALERT_1_DAY_BEFORE', true);
define('ALERT_2_DAYS_BEFORE', true);
?>