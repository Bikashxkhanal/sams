<?php require_once __DIR__ . "/../layout/header.php"; ?>
<?php require_once __DIR__ . "/../layout/navbar.php"; ?>

<div class="dashboard-wrapper">
    <h2>Admin Dashboard</h2>
    <p class="welcome-text">Welcome, <?= htmlspecialchars(Auth::user()['name']) ?> | Date: <?= date('Y-m-d') ?></p>

    <!-- Date Filter -->
    <form method="GET" class="date-filter">
        <label>From: <input type="date" name="from" value="<?= $_GET['from'] ?? date('Y-m-d', strtotime('-7 days')) ?>"></label>
        <label>To: <input type="date" name="to" value="<?= $_GET['to'] ?? date('Y-m-d') ?>"></label>
        <button>Filter</button>
    </form>

    <div class="summary-charts">

        <!-- Pie Chart: Today's attendance -->
        <div class="chart-box">
            <h3>Today's College Attendance</h3>
            <?php if(($todayData['PRESENT'] ?? 0) + ($todayData['ABSENT'] ?? 0) > 0): ?>
                <canvas id="pieCollege" width="320" height="320" ></canvas>
            <?php else: ?>
                <p class="no-attendance">Attendance not done yet today.</p>
            <?php endif; ?>
        </div>

        <!-- Line Chart: Attendance over date range -->
        <div class="chart-box">
            <h3>Attendance Trend</h3>
            <canvas id="lineCollege" width="1000" height="400"></canvas>
        </div>
    </div>

    <hr>

    <div class="admin-actions">
        <h3>Quick Actions</h3>
        <ul>
            <li><a href="/admin/program/create">➕ Add Program</a></li>
            <li><a href="/admin/semester/create">➕ Add Semester</a></li>
            <li><a href="/admin/subject/create">➕ Add Subject</a></li>
            <li><a href="/admin/user/create">➕ Add Teacher / Student</a></li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Pie Chart: Today
<?php if(($todayData['PRESENT'] ?? 0) + ($todayData['ABSENT'] ?? 0) > 0): ?>
new Chart(document.getElementById('pieCollege').getContext('2d'), {
    type: 'pie',
    data: {
        labels: ['Present', 'Absent'],
        datasets: [{
            data: [<?= $todayData['PRESENT'] ?? 0 ?>, <?= $todayData['ABSENT'] ?? 0 ?>],
            backgroundColor: ['#1e3c72','#f15a5a']
        }]
    },
    options: { responsive: false, plugins:{legend:{position:'bottom'}} }
});
<?php endif; ?>

// Line Chart: Date Range
<?php
$lineLabels = json_encode(array_keys($lineChartData));
$presentData = json_encode(array_map(fn($d)=>$d['PRESENT'] ?? 0, $lineChartData));
$absentData  = json_encode(array_map(fn($d)=>$d['ABSENT'] ?? 0, $lineChartData));
?>
new Chart(document.getElementById('lineCollege').getContext('2d'), {
    type: 'line',
    data: {
        labels: <?= $lineLabels ?>,
        datasets: [
            {
                label: 'Present',
                data: <?= $presentData ?>,
                borderColor: '#1e3c72',
                fill: false,
                tension:0.3
            },
            {
                label: 'Absent',
                data: <?= $absentData ?>,
                borderColor: '#f15a5a',
                fill: false,
                tension:0.3
            }
        ]
    },
    options: {
        responsive: true,
        plugins:{legend:{position:'bottom'}},
        scales:{
            y:{title:{display:true,text:'Number of Students'}, beginAtZero:true},
            x:{title:{display:true,text:'Date'}}
        }
    }
});
</script>

<style>
.dashboard-wrapper {
    max-width: 1400px;
    margin: 40px auto;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background:#f7f9fc;
    border-radius:12px;
}

.welcome-text { color:#333; margin-bottom: 20px; font-size:1.1rem; }

.date-filter {
    display: flex; justify-content:center; gap:15px; margin-bottom:30px;
}

canvas#pieCollege {
    width: 180px;       /* set desired width */
    height: 180px;      /* set desired height */
    display: block;     /* makes margin auto centering work */
    margin: 0 auto;     /* horizontally center */
}

.date-filter input { padding:6px 10px; border-radius:6px; border:1px solid #ccc; }
.date-filter button { padding:7px 15px; border:none; background:#1e3c72; color:#fff; border-radius:6px; cursor:pointer; transition:0.3s; }
.date-filter button:hover { background:#1452a0; }

.summary-charts { display:flex; gap:40px; flex-wrap:wrap; justify-content:center; margin-bottom:40px; }
.chart-box { background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.05); text-align:center; flex:1 1 400px; }

.no-attendance { color:#f15a5a; font-weight:bold; font-size:1rem; }

.admin-actions ul { list-style:none; padding:0; display:flex; gap:20px; flex-wrap:wrap; }
.admin-actions a { text-decoration:none; padding:8px 12px; background:#1e3c72; color:#fff; border-radius:6px; transition:0.3s; }
.admin-actions a:hover { background:#1452a0; }

</style>

<?php require_once __DIR__ . "/../layout/footer.php"; ?>
