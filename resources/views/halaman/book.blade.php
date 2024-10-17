@extends('layout.home')

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Add New Book</h4>
        <form method="POST" action="{{ route('submit.books') }}" class="forms-sample">
            @csrf
            <div class="form-group">
                <label for="bookTitle">Book Title</label>
                <input type="text" class="form-control" id="bookTitle" placeholder="Title" name="book_judul" required>
            </div>
            <div class="form-group">
                <label for="bookAuthor">Author</label>
                <input type="text" class="form-control" id="bookAuthor" placeholder="Author" name="book_pengarang" required>
            </div>
            <div class="form-group">
                <label for="bookCode">Book Code</label>
                <input type="text" class="form-control" id="bookCode" placeholder="Code" name="book_kode" required>
            </div>
            <div class="form-group">
                <label for="categorySelect">Category</label>
                <select class="form-control" id="categorySelect" name="category_id" required>
                    <option value="" disabled selected>Select a Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
        </form>
    </div>
</div>

<br>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Books Table</h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Book Code</th>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $index => $book)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $book->book_kode }}</td>
                        <td>{{ $book->book_judul }}</td>
                        <td>{{ $book->book_pengarang }}</td>
                        <td>{{ $book->category ? $book->category->category_name : 'N/A' }}</td>
                        <td>
                            <form action="{{ route('delete.books', $book->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mr-1" onclick="return confirm('Are you sure you want to delete this book?');">Delete</button>
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
