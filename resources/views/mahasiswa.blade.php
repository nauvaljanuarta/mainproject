@extends('layout.home')

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Add Mahasiswa</h4>
        <form method="POST" action="{{ route('submit.mahasiswa') }}" class="forms-sample">
            @csrf
            <div class="form-group">
                <label for="nama mahasiswa">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="mahasiswanama" placeholder="Nama" name="mahasiswa_nama" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="mahasiswaemail" placeholder="Email" name="mahasiswa_email" required>
            </div>
            <div class="form-group">
                <label for="alamat mahasiswa">Alamat mahasiswa</label>
                <input type="text" class="form-control" id="mahasiswaalamat" placeholder="Alamat" name="mahasiswa_alamat" required>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
        </form>
    </div>
</div>

<br>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Mahasiswa Table</h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>eMail</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswas as $index => $mahasiswa)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $mahasiswas->mahasiswa_nama }}</td>
                        <td>{{ $mahasiswas->mahasiswa_email }}</td>
                        <td>{{ $mahasiswas->mahasiswa_alamat }}</td>
                        <td>
                            <form action="{{ route('delete.mahasiswa', $mahasiswa->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mr-1" onclick="return confirm('Are you sure you want to delete this mahasiswa?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

@endsection
