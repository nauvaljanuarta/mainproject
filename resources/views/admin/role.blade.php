@extends('layout.home')

@section('content')

<div class="row mb-4">
    <div class="col">
        <h3 class="font-weight-bold">Role List</h3>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Role Name</th>
                        <th>Assigned Menus</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenisusers as $jenisuser)
                        <tr>
                            <td>{{ $jenisuser->id }}</td>
                            <td>{{ $jenisuser->jenis_user }}</td>
                            <td>
                            @if($jenisuser->menus->isNotEmpty())
                                <ul class="list-unstyled mb-0">
                                    @foreach($jenisuser->menus as $menu)
                                        <li>{{ $menu->menu_name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">No menus assigned</span>
                            @endif
                            </td>
                            <td>{{ $jenisuser->create_by }}</td>
                            <td>{{ $jenisuser->update_by }}</td>
                            <td>
                                <a href="{{ route('edit.roles', $jenisuser->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('delete.roles', $jenisuser->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="row mt-4">
            <div class="col">
                <button id="toggleFormButton" class="btn btn-primary">Add New Role</button>
            </div>
        </div>
    </div>
</div>

<div id="addRoleFormContainer" class="mt-4" style="display: none;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-4">Add New Role</h4>
            <form action="{{ route('create.roles') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="jenis_user">Role Name</label>
                    <input type="text" name="jenis_user" class="form-control" placeholder="Enter role name" required>
                </div>

                <button type="submit" class="btn btn-success mt-3">Save Role</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#toggleFormButton').click(function() {
            $('#addRoleFormContainer').slideToggle('slow');
        });
    });
</script>

@endsection
