<?php require __DIR__ . "/../layout/header.php"; ?>
<?php require __DIR__ . "/../layout/navbar.php"; ?>

<div class="dashboard-wrapper">

    <div class="dashboard-header">
        <h1>Welcome, <?= htmlspecialchars(Auth::user()['name']) ?></h1>
        <a href="/logout" class="logout-btn">Logout</a>
    </div>

    <h2>My Attendance</h2>

    <?php if(!empty($report)): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($report as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['subject_name']) ?></td>
                    <td><?= htmlspecialchars($r['date']) ?></td>
                    <td><?= htmlspecialchars($r['status']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p>No attendance records found.</p>
    <?php endif; ?>

</div>

<?php require __DIR__ . "/../layout/footer.php"; ?>
