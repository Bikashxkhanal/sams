<?php require_once __DIR__ . "/../layout/header.php"; ?>
<?php require_once __DIR__ . "/../layout/navbar.php"; ?>

<div class="attendance-wrapper">

    <h2>Mark Attendance</h2>

    <div class="attendance-info">
        <p><strong>Date:</strong> <?= date('Y-m-d') ?></p>
        <p><strong>Teacher:</strong> <?= htmlspecialchars(Auth::user()['name']) ?></p>
    </div>

    <!-- SUBJECT SELECTOR (ALWAYS VISIBLE) -->
    <label for="subject_id"><strong>Select Subject:</strong></label>
    <select id="subject_id"
            onchange="if(this.value) window.location='?subject_id=' + this.value;">
        <option value="">-- Select Subject --</option>

        <?php foreach($subjects as $s): ?>
            <option value="<?= $s['id'] ?>"
                <?= ($subjectId == $s['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($s['name']) ?> (Semester <?= $s['semester_id'] ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <hr>

    <?php if(!$subjectId): ?>

        <p class="info-text">Please select a subject to view or mark attendance.</p>

    <?php elseif(!empty($todayAttendance)): ?>

        <!-- ATTENDANCE ALREADY DONE -->
        <p class="already-done">Attendance already done for today:</p>

        <table class="attendance-table done">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($todayAttendance as $att): ?>
                <tr>
                    <td><?= htmlspecialchars($att['student_name']) ?></td>
                    <td class="<?= $att['status'] === 'PRESENT' ? 'present' : 'absent' ?>">
                        <?= $att['status'] ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>

        <!-- ATTENDANCE FORM -->
        <form method="POST">

            <input type="hidden" name="subject_id" value="<?= $subjectId ?>">

            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['name']) ?></td>
                        <td>
                            <select name="attendance[<?= $student['id'] ?>]">
                                <option value="PRESENT">Present</option>
                                <option value="ABSENT">Absent</option>
                            </select>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <button type="submit" class="save-btn">Save Attendance</button>
        </form>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . "/../layout/footer.php"; ?>


<style>
.attendance-wrapper {
    max-width: 1000px;
    margin: 30px auto;
    padding: 20px;
    background: #f7f9fc;
    border-radius: 12px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.attendance-wrapper h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #1e3c72;
}

.attendance-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    font-weight: 500;
    color: #333;
}

.attendance-info p {
    margin: 0;
}

.date-info {
    font-size: 0.9rem;
    color: #555;
}

.attendance-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.attendance-table th, .attendance-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

.attendance-table th {
    background: #1e3c72;
    color: #fff;
}

.attendance-table tr:nth-child(even){
    background-color: #f2f2f2;
}

.attendance-table tr:hover {
    background-color: #e6f0ff;
}

.attendance-table .present {
    color: #1e3c72;
    font-weight: bold;
}

.attendance-table .absent {
    color: #f15a5a;
    font-weight: bold;
}

.save-btn {
    display: block;
    margin: 20px auto 0 auto;
    padding: 10px 20px;
    background: #1e3c72;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.3s ease;
}

.save-btn:hover {
    background: #1452a0;
}

.already-done {
    font-weight: bold;
    color: #f15a5a;
    text-align: center;
    margin-bottom: 15px;
}
</style>

<?php require_once __DIR__ . "/../layout/footer.php"; ?>
