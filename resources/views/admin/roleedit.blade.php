@extends('layout.home')

@section('content')
<div class="container">
    <h1>Edit Role: {{ $jenisusers->jenis_user }}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('update.roles', $jenisusers->id) }}" method="POST">
        @csrf
        @method('PUT')


        <div class="form-group">
            <label for="jenis_user">User Role:</label>
            <input type="text" name="jenis_user" value="{{ old('jenis_user', $jenisusers->jenis_user) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="menus">Assign Menus:</label>
            <div class="checkbox-group">
                @foreach($menus as $menu)
                    <div>
                        <label>
                            <input type="checkbox" name="menus[]" value="{{ $menu->id }}"
                                {{ in_array($menu->id, old('menus', $selectedMenusRole)) ? 'checked' : '' }}>
                            {{ $menu->menu_name }}
                        </label>

                        @if($menu->subMenus->isNotEmpty())
                            <ul>
                                @foreach($menu->subMenus as $subMenu)
                                    <li>
                                        <label>
                                            <input type="checkbox" name="menus[]" value="{{ $subMenu->id }}"
                                                {{ in_array($subMenu->id, old('menus', $selectedMenusRole)) ? 'checked' : '' }}>
                                            {{ $subMenu->menu_name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Role</button>
    </form>

    <a href="/admin/role" class="btn btn-secondary mt-3">Back to Roles</a>
</div>


<script>
    $(document).ready(function() {

        var selectedMenus = @json($selectedMenusRole);

        $('input[type="checkbox"]').each(function() {
            var menuId = $(this).val();
            if (selectedMenus.includes(parseInt(menuId))) {
                $(this).prop('checked', true);
            }
        });

        // Handle old inputs (from form validation errors)
        var oldMenus = @json(old('menus', []));
        if (oldMenus.length > 0) {
            $('input[type="checkbox"]').each(function() {
                var menuId = $(this).val();
                if (oldMenus.includes(parseInt(menuId))) {
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false); // Reset unchecked inputs
                }
            });
        }
    });
</script>
@endsection
