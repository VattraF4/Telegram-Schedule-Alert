<?php
// Common Functions
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function formatDate($date) {
    return date('Y-m-d', strtotime($date));
}

function showMessage($type, $text) {
    $classes = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info'
    ];
    
    if (isset($classes[$type])) {
        return '<div class="alert ' . $classes[$type] . '">' . $text . '</div>';
    }
    return '';
}
?>