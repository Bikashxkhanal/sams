<?php if(Auth::check()): ?>
<nav>
    <?php if(Auth::role('ADMIN')): ?>
        <a href="/admin">Admin Dashboard</a>

        <!-- Quick Actions -->
        <span class="quick-actions">
            <a href="/admin/program/create">Add Program</a>
            <a href="/admin/semester/create">Add Semester</a>
            <a href="/admin/subject/create">Add Subject</a>
            <a href="/admin/user/create">Add Teacher/Student</a>
        </span>
    <?php endif; ?>

    <?php if(Auth::role('TEACHER')): ?>
        <a href="/teacher">Teacher Dashboard</a>
        <a href="/teacher/attendance">Attendance</a>
    <?php endif; ?>

    <?php if(Auth::role('STUDENT')): ?>
        <a href="/student">My Attendance</a>
    <?php endif; ?>

    <a href="/logout">Logout</a>
</nav>
<?php endif; ?>
