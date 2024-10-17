@extends('layout.home')

@section('content')
    <h2>Categories List</h2>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add New Category</h4>
            <form method="POST" action="{{ route('submit.categories') }}">
                @csrf
                <div class="form-group">
                    <label for="categoryName">Category</label>
                    <input type="text" class="form-control" id="categoryName" placeholder="Category" name="category_name" required>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
        </div>
    </div>

    <br>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Categories Table</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>{{ $category->created_at->format('D M Y') }}</td>
                            <td>
                                <form action="{{ route('delete.categories', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mr-1" onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
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
