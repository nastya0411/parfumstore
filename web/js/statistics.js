document.addEventListener("DOMContentLoaded", function () {
    fetch('/admin/statistics/data')
        .then(res => res.json())
        .then(data => {

            const ctxOrders = document.getElementById('ordersChart').getContext('2d');
            new Chart(ctxOrders, {
                type: 'line',
                data: {
                    labels: data.ordersByDate.map(d => d.date),
                    datasets: [{
                        label: 'Количество заказов',
                        data: data.ordersByDate.map(d => d.count),
                        borderColor: '#3e95cd',
                        backgroundColor: 'rgba(62, 149, 205, 0.1)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            title: { display: true, text: 'Дата' },
                        },
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Количество' }
                        }
                    }
                }
            });

            const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctxRevenue, {
                type: 'bar',
                data: {
                    labels: data.revenueByDateFormatted.map(d => d.date),
                    datasets: [{
                        label: 'Доход (₽)',
                        data: data.revenueByDateFormatted.map(d => parseFloat(d.total)),
                        backgroundColor: '#1cc88a'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            title: { display: true, text: 'Дата' },
                        },
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Сумма (₽)' }
                        }
                    }
                }
            });

            const ctxTopProducts = document.getElementById('topProductsChart').getContext('2d');
            new Chart(ctxTopProducts, {
                type: 'pie',
                data: {
                    labels: data.topProducts.map(p => p.title),
                    datasets: [{
                        label: 'Продажи',
                        data: data.topProducts.map(p => p.orders_count),
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
                    }]
                },
                options: {
                    responsive: true
                }
            });

            const ctxTimeDist = document.getElementById('timeDistributionChart').getContext('2d');
            new Chart(ctxTimeDist, {
                type: 'radar',
                data: {
                    labels: data.timeDistribution.map(t => t.hour + ':00'),
                    datasets: [{
                        label: 'Количество заказов',
                        data: data.timeDistribution.map(t => t.count),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        pointBackgroundColor: 'rgba(255, 99, 132, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    scale: {
                        ticks: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
});