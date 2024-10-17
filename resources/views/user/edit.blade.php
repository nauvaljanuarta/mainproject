@extends('layout.home')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-2">Edit Posting</h4>
            <form action="{{ route('update.postings', $postings->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-4">
                    <label for="message" class="form-label">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="4" required>{{ $postings->message }}</textarea>
                </div>

                <div class="form-group mb-4">
                    <label for="message_gambar" class="form-label">Upload Image (optional)</label>
                    <input type="file" id="message_gambar" name="message_gambar" class="form-control" accept="image/*">
                    @if($postings->message_gambar)
                        <img src="{{ asset($postings->message_gambar) }}" alt="Image" class="img-fluid mt-3">
                    @endif
                </div>

                <div class="form-group d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Update Posting</button>
                    <a href="{{ route('add.postings') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
