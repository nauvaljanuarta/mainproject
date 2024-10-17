@extends('layout.home')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-body">
        <div class="table responsive">
            <h4 class="card-title mb-2">Create New Posting</h4>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('create.postings') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-4">
                    <label for="message" class="form-label">Message</label>
                    <textarea id="message" name="message" class="form-control" required></textarea>
                </div>

                <div>
                    <label for="message_gambar">Upload Image (optional)</label>
                    <input type="file" id="message_gambar" name="message_gambar" class="form-control" accept="image/*">
                </div>
                <br>
                <div class="form-group d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Create Posting</button>
                    <a href="" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
@endsection
