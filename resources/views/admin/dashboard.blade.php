@extends('layout.home')

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Welcome Admin</h3>
                <h6 class="font-weight-normal mb-0">
                    All systems are running smoothly! You have <span class="text-primary">3 unread alerts!</span>
                </h6>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                        <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                            <a class="dropdown-item" href="#">January - March</a>
                            <a class="dropdown-item" href="#">March - June</a>
                            <a class="dropdown-item" href="#">June - August</a>
                            <a class="dropdown-item" href="#">August - November</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card tale-bg">
            <div class="card-people mt-auto">
                <img src="{{ asset('images/dashboard/people.svg') }}" alt="people">
                <div class="weather-info">
                    <div class="d-flex">
                        <div>
                            <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                        </div>
                        <div class="ml-2">
                            <h4 class="location font-weight-normal">Bangalore</h4>
                            <h6 class="font-weight-normal">India</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin transparent">
        <div class="row">
            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body">
                        <p class="mb-4">Total Emiten</p>
                        <p class="fs-30 mb-2" id="emiten-count">0</p>
                        <p>Diatas merupakan total emiten</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-tale">
                    <div class="card-body">
                        <p class="mb-4">Total Volume</p>
                        <p class="fs-30 mb-2" id="volume-count">0</p>
                        <p>Diatas merupakan total volume transaksi</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                <div class="card card-light-blue">
                    <div class="card-body">
                        <p class="mb-4">Total Value</p>
                        <p class="fs-30 mb-2" id="value-count">0</p>
                        <p>Diatas merupakan total value transaksi</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 stretch-card transparent">
                <div class="card card-light-danger">
                    <div class="card-body">
                        <p class="mb-4">Total Frequency</p>
                        <p class="fs-30 mb-2" id="frequency-count">0</p>
                        <p>Diatas merupakan jumlah frequensi transaksi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Value Transaction Report</p>
                    <a href="#" class="text-info">View all</a>
                </div>
                <canvas id="value-transaction-chart" style="height: 400px; width: 100%;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Emiten Sum Frequency</p>
                    <a href="#" class="text-info">View all</a>
                </div>
                <p class="font-weight-500">The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc.</p>
                <div id="monthly-frequencies-legend" class="chartjs-legend mt-4 mb-2"></div>
                <canvas id="monthly-frequencies-chart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Transaction Details</h4>
                <div class="table-responsive">
                    <table id="transactions-table" class="display table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Stock Code</th>
                                <th>Date</th>
                                <th>Volume</th>
                                <th>Value</th>
                                <th>Frequency</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Fetch overall transaction summary
        $.ajax({
            url: '/transaksi/summary',
            type: 'GET',
            success: function(data) {
                function formatLargeNumber(number) {
                    if (number >= 1000000000) {
                        return (number / 1000000000).toLocaleString('en-US', { maximumFractionDigits: 2 }) + ' B';
                    } else if (number >= 1000000) {
                        return (number / 1000000).toLocaleString('en-US', { maximumFractionDigits: 2 }) + ' M';
                    } else {
                        return number.toLocaleString();
                    }
                }

                $('#emiten-count').text(formatLargeNumber(data.totalEmiten));
                $('#volume-count').text(formatLargeNumber(data.totalVolume));
                $('#value-count').text('Rp ' + formatLargeNumber(data.totalValue));
                $('#frequency-count').text(data.totalFrequency.toLocaleString());
            },
            error: function(error) {
                console.error('Error fetching transaction summary:', error);
            }
        });

        // Fetch top 5 frequencies
        $.ajax({
            url: '/top5-frequencies',
            type: 'GET',
            success: function(data) {
                function formatLargeNumber(number) {
                    if (number >= 1000000000) {
                        return (number / 1000000000).toLocaleString('en-US', { maximumFractionDigits: 2 }) + ' B';
                    } else if (number >= 1000000) {
                        return (number / 1000000).toLocaleString('en-US', { maximumFractionDigits: 2 }) + ' M';
                    } else {
                        return number.toLocaleString();
                    }
                }


                const labels = data.map(item => item.stock_code);
                const frequencies = data.map(item => item.total_frequency);


                const legendHTML = labels.map((label, index) => `<p>${label}: ${formatLargeNumber(frequencies[index])}</p>`).join('');
                $('#monthly-frequencies-legend').html(legendHTML);


                const ctx = document.getElementById('monthly-frequencies-chart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Monthly Frequency',
                            data: frequencies,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Frequency'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                        }
                    }
                });
            },
            error: function(error) {
                console.error('Error fetching top 5 frequencies:', error);
            }
        });

        $.ajax({
        url: '/transaksi/values', // Endpoint for fetching transaction values
        type: 'GET',
        success: function(data) {
            const labels = data.map(item => item.stock_code);
            const values = data.map(item => item.value); // Assuming value is the key

            // Initialize the Chart.js pie chart
            const ctx = document.getElementById('value-transaction-chart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Transaction Value',
                        data: values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)', // Red
                            'rgba(54, 162, 235, 0.6)', // Blue
                            'rgba(255, 206, 86, 0.6)', // Yellow
                            'rgba(75, 192, 192, 0.6)', // Teal
                            'rgba(153, 102, 255, 0.6)', // Purple
                        ],
                        hoverBackgroundColor: [
                            'rgba(255, 99, 132, 1)', // Darker red
                            'rgba(54, 162, 235, 1)', // Darker blue
                            'rgba(255, 206, 86, 1)', // Darker yellow
                            'rgba(75, 192, 192, 1)', // Darker teal
                            'rgba(153, 102, 255, 1)', // Darker purple
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: Rp ${tooltipItem.raw.toLocaleString()}`; // Format tooltips for value
                                }
                            }
                        }
                    }
                }
            });
        },
        error: function(error) {
            console.error('Error fetching transaction values:', error);
        }
    });

    $.ajax({
        url: '/transaksi/values', // Endpoint for fetching transaction values
        type: 'GET',
        success: function(data) {
            const labels = data.map(item => item.stock_code);
            const values = data.map(item => item.value); // Assuming value is the key

            // Initialize the Chart.js pie chart
            const ctx = document.getElementById('value-transaction-chart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Transaction Value',
                        data: values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                        ],
                        hoverBackgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: Rp ${tooltipItem.raw.toLocaleString()}`;
                                }
                            }
                        }
                    }
                }
            });
        },
        error: function(error) {
            console.error('Error fetching transaction values:', error);
        }
    });

    var table = $('#transactions-table').DataTable({
    "processing": true,
    "serverSide": false,
    "ajax": {
        url: '/transaksi-harian/data',
        type: 'GET',
        dataSrc: function (json) {
            return json.map(function(item) {
                return [
                    item.stock_code,
                    item.date_transaction,
                    item.volume,
                    item.value,
                    item.frequency       
                ];
            });
        }
    },
    "columns": [
        { "title": "Stock Code" },
        { "title": "Date" },
        { "title": "Volume" },
        { "title": "Value" },
        { "title": "Frequency" }
    ],
    "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/Indonesian.json"
    }
});



    });
</script>


@endsection




