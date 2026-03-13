<?php if (!empty($success)): ?>
    <div class="alert-success">✅ User "<?= htmlspecialchars($success) ?>" created successfully!</div>
<?php endif; ?>

<form method="POST">
    <h3>Create User</h3>

    <label>Full Name</label>
    <input name="name" placeholder="e.g. John Doe" required>

    <label>Username / Email</label>
    <input name="email" type="text" placeholder="e.g. bba2_2@uni.com" required>

    <label>Password</label>
    <input name="password" type="password" placeholder="Enter password" required>

    <label>Role</label>
    <select name="role" id="role_select" onchange="toggleStudent()">
        <option value="TEACHER">Teacher</option>
        <option value="STUDENT">Student</option>
    </select>

    <!-- Shown only when STUDENT is selected -->
    <div id="student_fields" style="display:none; flex-direction:column; gap:6px;">

        <label>Program</label>
        <select id="program_select" onchange="filterSemesters()">
            <option value="">-- Select Program --</option>
            <?php foreach ($programs as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= htmlspecialchars($p['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Semester</label>
        <select name="semester_id" id="semester_select">
            <option value="">-- Select Program First --</option>
            <?php foreach ($semesters as $s): ?>
                <option
                    value="<?= $s['id'] ?>"
                    data-program="<?= $s['program_id'] ?>"
                    class="semester-option"
                    style="display:none">
                    Semester <?= htmlspecialchars($s['semester_no']) ?>
                </option>
            <?php endforeach; ?>
        </select>

    </div>

    <button type="submit">Create User</button>
</form>

<script>
function toggleStudent() {
    const isStudent = document.getElementById('role_select').value === 'STUDENT';
    const fields    = document.getElementById('student_fields');
    const semSelect = document.getElementById('semester_select');

    fields.style.display  = isStudent ? 'flex' : 'none';
    semSelect.required    = isStudent;
}

function filterSemesters() {
    const programId   = document.getElementById('program_select').value;
    const semSelect   = document.getElementById('semester_select');
    const options     = semSelect.querySelectorAll('.semester-option');
    let   hasOptions  = false;

    semSelect.value = '';

    options.forEach(opt => {
        const match = opt.dataset.program === programId;
        opt.style.display = match ? '' : 'none';
        if (match) hasOptions = true;
    });

    semSelect.options[0].text = programId
        ? (hasOptions ? '-- Select Semester --' : '-- No semesters found --')
        : '-- Select Program First --';
}
</script>

<style>
.alert-success {
    max-width: 500px;
    margin: 20px auto 0;
    padding: 14px 20px;
    background-color: #1a3a2a;
    border: 1px solid #2d7a50;
    border-radius: 8px;
    color: #4caf82;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 1rem;
    text-align: center;
}
form {
    max-width: 500px;
    margin: 50px auto;
    padding: 40px;
    background-color: #1a1f3a;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35);
    color: #f0f0f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    flex-direction: column;
    gap: 6px;
}
form h3 {
    text-align: center;
    margin-bottom: 10px;
    color: #e0e0ff;
    font-size: 1.6rem;
}
form label {
    font-size: 0.82rem;
    color: #a0a8d0;
    margin-top: 10px;
}
form input,
form select {
    width: 100%;
    padding: 14px 15px;
    border: 1px solid #3b3f5c;
    border-radius: 8px;
    background-color: #2a2f50;
    color: #f0f0f5;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-sizing: border-box;
}
form input:focus,
form select:focus {
    border-color: #5060a0;
    background-color: #333a60;
    outline: none;
}
form button {
    width: 100%;
    padding: 14px;
    margin-top: 14px;
    border: none;
    border-radius: 8px;
    background-color: #5060a0;
    color: #f0f0f5;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}
form button:hover {
    background-color: #3d4a80;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}
</style>