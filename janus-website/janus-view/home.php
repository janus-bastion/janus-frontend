<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

require_once '../janus-include/header.php';
require_once '/home/janus-storage/janus-db-connect/janus-db-connection.php';
?>

<style>
    body {
        background-color: #414856 !important;
        min-height: 100vh;
        margin: 0;
    }
</style>

<div class="container mt-5">
    <table style="width: 100%;">
        <tr>
            <td style="width: 33%; vertical-align: top; padding-right: 30px;">
                <div class="card" style="width: 100%; height: 100%; background-color: transparent;">
                    <div class="card-body graph-body" style="background-color: transparent;height: 300px;">
                        <canvas id="usersChart"></canvas>
                    </div>
                </div>
            </td>

            <td style="width: 33%; vertical-align: top; padding: 0 30px;">
                <div class="card" style="width: 100%; height: 100%; background-color: transparent;">
                    <div class="card-body graph-body" style="background-color: transparent; height: 300px;">
                        <canvas id="connectionsChart"></canvas>
                    </div>
                </div>
            </td>

            <td style="width: 33%; vertical-align: top; padding-left: 30px;">
                <div class="card" style="width: 100%; height: 100%; background-color: transparent;">
                    <div class="card-body graph-body" style="height: 300px; background-color: transparent;">
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
    fetch('/stats')
        .then(response => response.json())
        .then(data => {
            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        align: 'center',
                        font: {
                            size: 16,
                            weight: 'bold'
                        },
                        color: 'white'
                    },
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: 'white'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white',
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        }
                    }
                }
            };

            // Users Chart
            const usersCtx = document.getElementById('usersChart').getContext('2d');
            new Chart(usersCtx, {
                type: 'bar',
                data: {
                    labels: data.users.labels,
                    datasets: [{
                        label: 'Utilisateurs créés',
                        data: data.users.data,
                        backgroundColor: 'rgba(0, 191, 255, 0.7)',
                        borderColor: 'rgba(0, 191, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        ...commonOptions.plugins,
                        title: {
                            ...commonOptions.plugins.title,
                            text: 'Utilisateurs créés (7 jours)'
                        }
                    }
                }
            });

            // Connection Types Chart
            const connectionsCtx = document.getElementById('connectionsChart').getContext('2d');
            new Chart(connectionsCtx, {
                type: 'doughnut',
                data: {
                    labels: data.connectionTypes.labels,
                    datasets: [{
                        data: data.connectionTypes.data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(0, 255, 150, 0.8)',
                            'rgba(255, 215, 0, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(0, 255, 150, 1)',
                            'rgba(255, 215, 0, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        ...commonOptions.plugins,
                        title: {
                            ...commonOptions.plugins.title,
                            text: 'Types de connexions'
                        },
                        legend: {
                            ...commonOptions.plugins.legend,
                            position: 'bottom'
                        }
                    },
                    scales: {} // Doughnut chart doesn't use scales
                }
            });

            // Connections Over Time Chart
            const connectionsTimeCtx = document.getElementById('connectionsOverTimeChart').getContext('2d');
            new Chart(connectionsTimeCtx, {
                type: 'line',
                data: {
                    labels: data.connectionsOverTime.labels,
                    datasets: [{
                        label: 'Connexions créées',
                        data: data.connectionsOverTime.data,
                        fill: false,
                        backgroundColor: 'rgba(255, 140, 0, 0.8)',
                        borderColor: 'rgba(255, 140, 0, 1)',
                        tension: 0.3
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        ...commonOptions.plugins,
                        title: {
                            ...commonOptions.plugins.title,
                            text: 'Connexions créées (7 jours)'
                        }
                    }
                }
            });
        });
});
</script>


<?php require_once '../janus-include/footer.php'; ?>
