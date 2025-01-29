<canvas id="myChart"></canvas>
<script src="{{ asset('admin_assets/js/chart.js') }}"></script>
<script>
    var ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'june', 'july', 'August', 'September',
                'October', 'November', 'December'
            ],
            datasets: [{
                label: 'Transaction per month ($)',
                data: [
                    {{ $total_membership_transaction['january'] }},
                    {{ $total_membership_transaction['february'] }},
                    {{ $total_membership_transaction['march'] }},
                    {{ $total_membership_transaction['april'] }},
                    {{ $total_membership_transaction['may'] }},
                    {{ $total_membership_transaction['june'] }},
                    {{ $total_membership_transaction['july'] }},
                    {{ $total_membership_transaction['august'] }},
                    {{ $total_membership_transaction['september'] }},
                    {{ $total_membership_transaction['october'] }},
                    {{ $total_membership_transaction['november'] }},
                    {{ $total_membership_transaction['december'] }}
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgb(255, 205, 86, 0.2)',
                    'rgb(75, 192, 192, 0.2)',
                    'rgb(54, 162, 235, 0.2)',
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>