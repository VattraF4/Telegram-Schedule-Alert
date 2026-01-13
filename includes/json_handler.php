<?php
include_once __DIR__ . '/../config/config.php';
// JSON File Operations
function readSchedules() {
    if (!file_exists(SCHEDULE_FILE)) {
        file_put_contents(SCHEDULE_FILE, '[]');
    }
    
    $json = file_get_contents(SCHEDULE_FILE);
    $schedules = json_decode($json, true);
    
    if ($schedules === null) {
        return [];
    }
    
    return $schedules;
}

function saveSchedules($schedules) {
    $json = json_encode($schedules, JSON_PRETTY_PRINT);
    return file_put_contents(SCHEDULE_FILE, $json);
}

function addSchedule($schedule) {
    $schedules = readSchedules();
    
    // Generate unique ID
    $schedule['id'] = uniqid('sch_', true);
    $schedule['created_at'] = date('Y-m-d H:i:s');
    
    $schedules[] = $schedule;
    
    return saveSchedules($schedules);
}

function updateSchedule($id, $updatedData) {
    $schedules = readSchedules();
    
    foreach ($schedules as &$schedule) {
        if ($schedule['id'] === $id) {
            $schedule = array_merge($schedule, $updatedData);
            break;
        }
    }
    
    return saveSchedules($schedules);
}

function deleteSchedule($id) {
    $schedules = readSchedules();
    
    $newSchedules = array_filter($schedules, function($schedule) use ($id) {
        return $schedule['id'] !== $id;
    });
    
    return saveSchedules(array_values($newSchedules));
}

function getScheduleById($id) {
    $schedules = readSchedules();
    
    foreach ($schedules as $schedule) {
        if ($schedule['id'] === $id) {
            return $schedule;
        }
    }
    
    return null;
}
?>