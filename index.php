<?php
// Main Dashboard
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/json_handler.php';
require_once __DIR__ . '/config/config.php';

$schedules = readSchedules();
$totalSchedules = count($schedules);

// Count upcoming schedules (next 7 days)
$upcomingCount = 0;
$today = date('Y-m-d');
foreach ($schedules as $schedule) {
    if ($schedule['date'] >= $today) {
        $upcomingCount++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telegram Schedule Bot Dashboard</title>
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>📅 Telegram Schedule Bot Dashboard</h1>

        <div class="navigation">
            <a href="index.php">Dashboard</a>
            <a href="pages/view_schedules.php">View Schedules</a>
            <a href="pages/add_schedule.php">Add Schedule</a>
        </div>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Schedules</h3>
                <p><?php echo $totalSchedules; ?></p>
            </div>

            <div class="card">
                <h3>Upcoming (Next 7 days)</h3>
                <p><?php echo $upcomingCount; ?></p>
            </div>

            <div class="card">
                <h3>Today's Date</h3>
                <p><?php echo date('Y-m-d'); ?></p>
            </div>
        </div>

        <div class="instructions" >
            <h2>How to Use:</h2>
            <ol   style="margin-left: 20px">
                <li>Go to "Add Schedule" to create new alerts</li>
                <li>View all schedules in "View Schedules"</li>
                <li>Edit or delete schedules as needed</li>
                <li>Set up cron job to run <code>cron/check_schedule.php</code> every minute</li>
            </ol><br>

            <h3>Cron Job Setup:</h3>
                <pre  style="margin-left: -120px">
                        # Run every minute
                        * * * * * /usr/bin/php /path/to/telegram-schedule-bot/cron/check_schedule.php
                </pre>

            <h3>Configuration:</h3>
            <p>Edit <code>config/config.php</code> to set your bot token and group chat ID.</p>
        </div>

    </div>
</body>

</html>