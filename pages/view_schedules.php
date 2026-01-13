<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/json_handler.php';

$schedules = readSchedules();

// Sort by date
usort($schedules, function($a, $b) {
    return strtotime($a['date']) - strtotime($b['date']);
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Schedules</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Schedules List</h1>
        
        <div class="mb-3">
            <a href="add_schedule.php" class="btn btn-primary">Add New Schedule</a>
            <a href="../index.php" class="btn btn-secondary">Back to Home</a>
        </div>
        
        <?php if (empty($schedules)): ?>
            <div class="alert alert-info">No schedules found. Add your first schedule!</div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedules as $schedule): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($schedule['title']); ?></td>
                        <td><?php echo $schedule['date']; ?></td>
                        <td><?php echo htmlspecialchars($schedule['description'] ?? 'N/A'); ?></td>
                        <td><?php echo date('M d, Y', strtotime($schedule['created_at'])); ?></td>
                        <td>
                            <a href="edit_schedule.php?id=<?php echo $schedule['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_schedule.php?id=<?php echo $schedule['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>