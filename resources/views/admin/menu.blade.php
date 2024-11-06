@extends('layout.home')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h3 class="font-weight-bold">Manage Menus</h3>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="card-title mb-4">Menu List</h4>
        <div class="table-responsive">
            <table id="menuTable" class="table table-hover table-striped w-100">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Menu Name</th>
                        <th>Menu Link</th>
                        <th>Menu Icon</th>
                        <th>Parent Menu</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menu)
                        <tr>
                            <td>{{ $menu->id }}</td>
                            <td>{{ $menu->menu_name }}</td>
                            <td>{{ $menu->menu_link }}</td>
                            <td>{{ $menu->menu_icon }}</td>
                            <td>{{ $menu->parent ? $menu->parent->menu_name : 'None' }}</td>
                            <td>
                                <a href="{{ route('edit.menus', $menu->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('delete.menus') }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $menu->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>

                        @foreach ($subMenus as $subMenu)
                            @if ($subMenu->parent_id == $menu->id)
                                <tr>
                                    <td>{{ $subMenu->id }}</td>
                                    <td>{{ $subMenu->menu_name }}</td>
                                    <td>{{ $subMenu->menu_link }}</td>
                                    <td>{{ $subMenu->menu_icon }}</td>
                                    <td>{{ $menu->menu_name }}</td>
                                    <td>
                                        <a href="{{ route('edit.menus', $subMenu->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('delete.menus') }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $subMenu->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No menus found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="row mt-4">
            <div class="col">
                <button id="toggleFormButton" class="btn btn-primary">Add New Menu</button>
            </div>
        </div>
    </div>
</div>

<br>

<div id="addMenuFormContainer" style="display: none;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-4">Add New Menu or Submenu</h4>
            <form action="{{ route('create.menus') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="id_level">Menu Level</label>
                    <select class="form-control" id="id_level" name="id_level" required>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->level }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="menu_name">Menu Name</label>
                    <input type="text" class="form-control" id="menu_name" name="menu_name" required placeholder="Enter menu name">
                </div>
                <div class="form-group">
                    <label for="menu_link">Menu Link</label>
                    <input type="text" class="form-control" id="menu_link" name="menu_link" required placeholder="Enter menu link">
                </div>
                <div class="form-group">
                    <label for="menu_icon">Menu Icon</label>
                    <input type="text" class="form-control" id="menu_icon" name="menu_icon" placeholder="Enter icon class (optional)">
                    <small class="form-text text-muted">Example: <code>icon-grid menu-icon</code></small>
                </div>
                <div class="form-group">
                    <label for="parent_id">Parent Menu</label>
                    <select class="form-control" id="parent_id" name="parent_id">
                        <option value="">None (Top-level menu)</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->menu_name }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Select a parent to make this a submenu. Leave empty for a top-level menu.</small>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Add Menu</button>
            </form>
            <!-- Form ends -->

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#menuTable').DataTable({
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

        $('#toggleFormButton').click(function() {
            $('#addMenuFormContainer').slideToggle('slow');
        });
    });
</script>

@endsection
