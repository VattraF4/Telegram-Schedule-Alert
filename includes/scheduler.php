<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/telegram.php';
require_once __DIR__ . '/json_handler.php';

function checkAndSendAlerts() {
    $schedules = readSchedules();
    $today = date('Y-m-d');
    $alertsSent = [];
    $schedulesToDelete = [];
    
    foreach ($schedules as  $schedule) {
        $scheduleDate = $schedule['date'];
        $eventTitle = $schedule['title'];
        $eventDesc = $schedule['description'] ?? '';
        
        // Calculate days difference
        $date1 = new DateTime($today);
        $date2 = new DateTime($scheduleDate);
        $interval = $date1->diff($date2);
        $daysDifference = $interval->days;
        
        // Check if it's exactly 1 day before
        if (ALERT_1_DAY_BEFORE && $daysDifference == 1) {
            $message = "⏰ REMINDER: 1 DAY LEFT!\n";
            $message .= "📅 Event: <b>{$eventTitle}</b>\n";
            $message .= "📆 Date: {$scheduleDate}\n";
            if ($eventDesc) {
                $message .= "📝 Details: {$eventDesc}\n";
            }
            
            sendTelegramMessage(GROUP_CHAT_ID, $message);
            $alertsSent[] = $schedule['id'];
        }
        
        // Check if it's exactly 2 days before
        if (ALERT_2_DAYS_BEFORE && $daysDifference == 2) {
            $message = "⏰ REMINDER: 2 DAYS LEFT!\n";
            $message .= "📅 Event: <b>{$eventTitle}</b>\n";
            $message .= "📆 Date: {$scheduleDate}\n";
            if ($eventDesc) {
                $message .= "📝 Details: {$eventDesc}\n";
            }
            
            sendTelegramMessage(GROUP_CHAT_ID, $message);
            $alertsSent[] = $schedule['id'];
        }
        
        // Check if schedule date has passed
        if ($date1 >= $date2) {
            $message = "⏰ REMINDER: TODAY MEET THE EVENT!\n";
            $message .= "📅 Event: <b>{$eventTitle}</b>\n";
            $message .= "📆 Date: {$scheduleDate}\n";
            if ($eventDesc) {
                $message .= "📝 Details: {$eventDesc}\n";
            }
            sendTelegramMessage(GROUP_CHAT_ID, $message);
            $schedulesToDelete[] = $schedule['id'];
        }
    }
    
    // Delete past schedules
    foreach ($schedulesToDelete as $scheduleId) {
        deleteSchedule($scheduleId);
    }
    
    return [
        'alerts_sent' => count($alertsSent),
        'schedules_deleted' => count($schedulesToDelete)
    ];
}
?>