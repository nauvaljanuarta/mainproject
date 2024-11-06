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
                <input type="text" class="form-control" id="bookCode" placeholder="Code" name="book_code" required>
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
            <table id="bookTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Book Code</th>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Create by</th>
                        <th>Updated by</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $index => $book)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $book->book_code }}</td>
                        <td>{{ $book->book_judul }}</td>
                        <td>{{ $book->book_pengarang }}</td>
                        <td>{{ $book->category ? $book->category->category_name : 'N/A' }}</td>
                        <td>{{ $book->create_by }}</td>
                        <td>{{ $book->update_by }}</td>
                        <td>
                            <div class="d-flex justify-content-start">
                                <a class="btn btn-warning btn-sm me-2" onclick="showEditForm(
                                    {{ $book->id }},
                                    '{{ $book->book_judul }}',
                                    '{{ $book->book_pengarang }}',
                                    '{{ $book->book_code }}',
                                    {{ $book->category_id }})">Edit</a>
                                <form action="{{ route('delete.books', $book->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?');">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Books found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<br>

<div class="card" id="editBookCard" style="display:none;">
    <div class="card-body">
        <h4 class="card-title">Edit Book</h4>
        <form method="POST" action="{{ isset($book) ? route('update.books', $book->id) : '#' }}" class="forms-sample">
            @csrf
            @method('PUT')
            <input type="hidden" id="editBookId" name="book_id">
            <div class="form-group">
                <label for="editBookTitle">Book Title</label>
                <input type="text" class="form-control" id="editBookTitle" name="book_judul" required>
            </div>
            <div class="form-group">
                <label for="editBookAuthor">Author</label>
                <input type="text" class="form-control" id="editBookAuthor" name="book_pengarang" required>
            </div>
            <div class="form-group">
                <label for="editBookCode">Book Code</label>
                <input type="text" class="form-control" id="editBookCode" name="book_code" required>
            </div>
            <div class="form-group">
                <label for="editCategorySelect">Category</label>
                <select class="form-control" id="editCategorySelect" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Update</button>
            <button type="button" class="btn btn-secondary" onclick="hideEditForm()">Cancel</button>
        </form>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<script>
$(document).ready(function() {
    $('#bookTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        language: {
            search: "Search:",
            lengthMenu: "Display _MENU_ records per page",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No records available",
            zeroRecords: "No matching records found"
        }
    });
});

function showEditForm(id, title, author, code, categoryId) {

    document.getElementById('editBookId').value = id;
    document.getElementById('editBookTitle').value = title;
    document.getElementById('editBookAuthor').value = author;
    document.getElementById('editBookCode').value = code;
    document.getElementById('editCategorySelect').value = categoryId;

    $('#editBookCard').slideDown('slow');
}

function hideEditForm() {
    $('#editBookCard').slideUp('slow');
}
</script>

@endsection
