@extends('layout.home')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h3 class="font-weight-bold">Edit Menu</h3>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="card-title mb-4">Edit Menu: {{ $menu->menu_name }}</h4>

        <form action="{{ route('update.menus', $menu->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="id_level">Menu Level</label>
                <select class="form-control" id="id_level" name="id_level" required>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}" {{ $menu->id_level == $level->id ? 'selected' : '' }}>{{ $level->level }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="menu_name">Menu Name</label>
                <input type="text" class="form-control" id="menu_name" name="menu_name" required value="{{ $menu->menu_name }}" placeholder="Enter menu name">
            </div>

            <div class="form-group">
                <label for="menu_link">Menu Link</label>
                <input type="text" class="form-control" id="menu_link" name="menu_link" required value="{{ $menu->menu_link }}" placeholder="Enter menu link">
            </div>

            <div class="form-group">
                <label for="menu_icon">Menu Icon</label>
                <input type="text" class="form-control" id="menu_icon" name="menu_icon" value="{{ $menu->menu_icon }}" placeholder="Enter icon class (optional)">
            </div>

            <div class="form-group">
                <label for="parent_id">Parent Menu</label>
                <select class="form-control" id="parent_id" name="parent_id">
                    <option value="">None (Top-level menu)</option>
                    @foreach($menus as $parentMenu)
                        <option value="{{ $parentMenu->id }}" {{ $menu->parent_id == $parentMenu->id ? 'selected' : '' }}>{{ $parentMenu->menu_name }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Select a parent to make this a submenu. Leave empty for a top-level menu.</small>
            </div>
            <button type="submit" class="btn btn-primary">Update Menu</button>
            <div class="mt-3">
                <a href="/admin/menu" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
