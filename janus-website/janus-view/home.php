<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../janus-include/header.php';
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';
?>

<div class="container mt-5">
    <table style="width: 100%;">
        <tr>
            <td style="width: 33%; vertical-align: top; padding-right: 30px;">
                <div class="card" style="width: 100%; height: 100%;">
                    <div class="card-body graph-body" style="height: 300px;">
                        <canvas id="usersChart"></canvas>
                    </div>
                </div>
            </td>

            <td style="width: 33%; vertical-align: top; padding: 0 30px;">
                <div class="card" style="width: 100%; height: 100%;">
                    <div class="card-body graph-body" style="height: 300px;">
                        <canvas id="connectionsChart"></canvas>
                    </div>
                </div>
            </td>

            <td style="width: 33%; vertical-align: top; padding-left: 30px;">
                <div class="card" style="width: 100%; height: 100%;">
                    <div class="card-body graph-body" style="height: 300px;">
                        <canvas id="connectionsOverTimeChart"></canvas>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function() {
    fetch('get-stats.php')
        .then(response => response.json())
        .then(data => {
            const usersCtx = document.getElementById('usersChart').getContext('2d');
            new Chart(usersCtx, {
                type: 'bar',
                data: {
                    labels: data.users.labels,
                    datasets: [{
                        label: 'Utilisateurs créés',
                        data: data.users.data,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Users Created (7 days)',
                            align: 'center',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            const connectionsCtx = document.getElementById('connectionsChart').getContext('2d');
            new Chart(connectionsCtx, {
                type: 'doughnut',
                data: {
                    labels: data.connectionTypes.labels,
                    datasets: [{
                        data: data.connectionTypes.data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 205, 86, 0.7)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Connection Types',
                            align: 'center',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            const connectionsTimeCtx = document.getElementById('connectionsOverTimeChart').getContext('2d');
            new Chart(connectionsTimeCtx, {
                type: 'line',
                data: {
                    labels: data.connectionsOverTime.labels,
                    datasets: [{
                        label: 'Connexions créées',
                        data: data.connectionsOverTime.data,
                        fill: false,
                        backgroundColor: 'rgba(153, 102, 255, 0.5)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Connections Created (7 days)',
                            align: 'center',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
});

</script>

<?php require_once '../janus-include/footer.php'; ?>
