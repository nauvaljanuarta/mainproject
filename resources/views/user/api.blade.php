@extends('layout.home')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Informasi Gempa Terkini</h1>
        <div class="d-flex justify-content-center mt-4">
            <button id="load-gempa" class="btn btn-primary">Tampilkan Info Gempa</button>
        </div>

        <br>


        <div id="gempa-card" class="card mb-4 shadow rounded" style="display: none;">
            <div class="card-header">
                <h4 class="card-title">Detail Gempa</h4>
            </div>
            <div class="card-body">
                <p><strong>Tanggal:</strong> <span id="tanggal"></span></p>
                <p><strong>Jam:</strong> <span id="jam"></span></p>
                <p><strong>Koordinat:</strong> <span id="koordinat"></span></p>
                <p><strong>Lintang:</strong> <span id="lintang"></span></p>
                <p><strong>Bujur:</strong> <span id="bujur"></span></p>
                <p><strong>Magnitude:</strong> <span id="magnitude"></span></p>
                <p><strong>Kedalaman:</strong> <span id="kedalaman"></span></p>
                <p><strong>Wilayah:</strong> <span id="wilayah"></span></p>
                <p><strong>Potensi:</strong> <span id="potensi"></span></p>
                <p><strong>Dirasakan:</strong> <span id="dirasakan"></span></p>
                <p><strong>Shakemap:</strong> <span id="shakemap"></span></p>
            </div>
            <div class="card-footer text-muted">
                Sumber data: BMKG
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#load-gempa').click(function() {

                $.getJSON('https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json', function(data) {
                    var gempa = data.Infogempa.gempa;
                    $('#tanggal').text(gempa.Tanggal);
                    $('#jam').text(gempa.Jam);
                    $('#koordinat').text(gempa.Coordinates);
                    $('#lintang').text(gempa.Lintang);
                    $('#bujur').text(gempa.Bujur);
                    $('#magnitude').text(gempa.Magnitude);
                    $('#kedalaman').text(gempa.Kedalaman);
                    $('#wilayah').text(gempa.Wilayah);
                    $('#potensi').text(gempa.Potensi);
                    $('#dirasakan').text(gempa.Dirasakan);
                    $('#shakemap').html(
                        "<img src='https://data.bmkg.go.id/DataMKG/TEWS/" + gempa.Shakemap + "' alt='Shakemap' style='max-width: 100%; height: auto;' />"
                    );

                    $('#gempa-card').slideDown();
                });
            });
        });
    </script>
@endsection
