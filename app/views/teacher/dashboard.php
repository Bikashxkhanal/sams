<?php require_once __DIR__ . "/../layout/header.php"; ?>
<?php require_once __DIR__ . "/../layout/navbar.php"; ?>

<div class="dashboard-wrapper">
    <h2>Teacher Dashboard</h2>
    <p class="welcome-text">Welcome, <?= htmlspecialchars(Auth::user()['name']) ?> | Date: <?= date('Y-m-d') ?></p>

    <!-- Date filter for line chart -->
    <form method="GET" class="date-filter">
        <label>From: <input type="date" name="from" value="<?= $_GET['from'] ?? date('Y-m-d', strtotime('-7 days')) ?>"></label>
        <label>To: <input type="date" name="to" value="<?= $_GET['to'] ?? date('Y-m-d') ?>"></label>
        <button>Filter</button>
    </form>

    <?php foreach($subjects as $sub): ?>
        <div class="subject-box">
            <h3><?= htmlspecialchars($sub['name']) ?> (Sem <?= $sub['semester_id'] ?>)</h3>

            <!-- Summary -->
            <p class="summary">
                Total Students: <strong><?= $sub['total_students'] ?></strong> | 
                Present Today: <strong><?= $todayData[$sub['id']]['PRESENT'] ?? 0 ?></strong> | 
                Absent Today: <strong><?= $todayData[$sub['id']]['ABSENT'] ?? 0 ?></strong>
            </p>

            <div class="charts-wrapper">
               <!-- Pie chart for today -->
<!-- Pie chart for today -->
<?php if( ($todayData[$sub['id']]['PRESENT'] ?? 0) + ($todayData[$sub['id']]['ABSENT'] ?? 0) > 0 ): ?>
    <canvas class="pie-chart" id="pie<?= $sub['id'] ?>" width="180" height="180"></canvas>
<?php else: ?>
    <p class="no-attendance">Attendance not done yet for today.</p>
<?php endif; ?>


                

                <!-- Line chart for date range -->
                <canvas id="line<?= $sub['id'] ?>" width="800" height="400"></canvas>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
<?php foreach($subjects as $sub):
    $pie = $todayData[$sub['id']];
    $line = $lineChartData[$sub['id']];
    $labels = json_encode(array_keys($line));
    $presentData = json_encode(array_map(fn($d) => $d['PRESENT'] ?? 0, $line));
    $absentData  = json_encode(array_map(fn($d) => $d['ABSENT'] ?? 0, $line));
?>
// Pie Chart - only if canvas exists
if(document.getElementById('pie<?= $sub['id'] ?>')) {
    new Chart(document.getElementById('pie<?= $sub['id'] ?>').getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Present', 'Absent'],
            datasets: [{
                data: [<?= $pie['PRESENT'] ?? 0 ?>, <?= $pie['ABSENT'] ?? 0 ?>],
                backgroundColor: ['#1e3c72', '#f15a5a']
            }]
        },
        options: { responsive: true, plugins:{legend:{position:'bottom'}} }
    });
}

// Line Chart - always render
new Chart(document.getElementById('line<?= $sub['id'] ?>').getContext('2d'), {
    type: 'line',
    data: {
        labels: <?= $labels ?>,
        datasets: [
            {
                label: 'Present',
                data: <?= $presentData ?>,
                borderColor: '#1e3c72',
                fill: false,
                tension: 0.3
            },
            {
                label: 'Absent',
                data: <?= $absentData ?>,
                borderColor: '#f15a5a',
                fill: false,    
                tension: 0.3
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
<?php endforeach; ?>

</script>

<style>
/* Container */
.dashboard-wrapper {
    max-width: 1400px;
    margin: 40px auto;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background:#f7f9fc;
    border-radius:12px;
}

/* Welcome Text */
.welcome-text {
    font-size: 1.1rem;
    margin-bottom: 20px;
    color: #333;
}

/* Date Filter */
.date-filter {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 30px;
    gap: 15px;
}

.date-filter label {
    font-weight: 500;
    color: #555;
}

.date-filter input {
    padding: 6px 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.date-filter button {
    padding: 7px 15px;
    border: none;
    background: #1e3c72;
    color: #fff;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.date-filter button:hover {
    background: #1452a0;
}

/* Subject Card */
.subject-box {
    margin-bottom: 40px;
    padding: 20px;
    background:#fff;
    border-radius:12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

/* Summary */
.summary {
    margin: 10px 0 20px;
    font-size: 1rem;
    color: #444;
}

/* Charts wrapper */
.charts-wrapper {
    display: flex;
    justify-content: space-around;
    align-items: center;
    flex-wrap: wrap;
    gap: 30px;
}

/* Pie Chart: keep original small size */
/* Pie Charts */
canvas.pie-chart {
    max-width: 180px;
    max-height: 180px;
    margin: 0 auto;
    display: block;
}


/* Line chart: larger width */
canvas[id^="line"] {
    max-width: 800px;
    max-height: 400px;
    display: block;
}
.no-attendance {
    color: #f15a5a;
    font-weight: bold;
    font-size: 1rem;
    margin: 20px 0;
}
</style>

<?php require_once __DIR__ . "/../layout/footer.php"; ?>
