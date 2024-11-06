@extends('layout.home')

@section('content')

<div class="row mb-4">
    <div class="col">
        <h3 class="font-weight-bold">Laporan Emiten Bulanan</h3>
        <h6 class="font-weight-normal mb-0">
            Ini adalah laporan total.
        </h6>
    </div>
</div>

<div id="emitenTableContainer" class="card shadow-sm mb-4">
    <div class="card-body">
        <h4 class="card-title mb-4">Ringkasan Emiten</h4>
        <button id="download-emiten" class="btn btn-secondary mb-3">Download Laporan Emiten PDF</button>
        <div class="table-responsive">
            <table id="emiten-table" class="table table-hover table-striped w-100">
                <thead class="table-light">
                    <tr>
                        <th>Stock Code</th>
                        <th>Total Volume</th>
                        <th>Total Value</th>
                        <th>Total Frequency</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data Emiten dari AJAX akan ditampilkan di sini -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Fetch data emiten including total values via AJAX
        $.ajax({
            url: '/emiten/data-summary',
            type: 'GET',
            success: function (data) {
                const tableBody = $('#emiten-table tbody');

                // Append each emiten's summary data to the table
                data.forEach(emiten => {
                    tableBody.append(`
                        <tr>
                            <td>${emiten.stock_code}</td>
                            <td>${parseInt(emiten.total_volume).toLocaleString()}</td>
                            <td>${parseFloat(emiten.total_value).toLocaleString()}</td>
                            <td>${parseInt(emiten.total_frequency).toLocaleString()}</td>
                        </tr>
                    `);
                });
            },
            error: function (error) {
                console.error('Error fetching emiten summary data:', error);
            }
        });

        // Download PDF for Emiten
        $('#download-emiten').click(function () {
            var element = document.getElementById('emitenTableContainer');
            html2pdf()
                .from(element)
                .save('laporan_emiten.pdf');
        });
    });
</script>

@endsection
