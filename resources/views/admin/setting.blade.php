@extends('layout.home')

@section('content')

<div class="row mb-4">
    <div class="col">
        <h3 class="font-weight-bold">Menu Assignments</h3>
        <h6 class="font-weight-normal mb-0">
            Customize menu access for each role.
        </h6>
    </div>
</div>

<div id="menuTableContainer" class="card shadow-sm">
    <div class="card-body">
        <h4 class="card-title mb-4">Assign Menus to Roles</h4>
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100">
                <thead class="table-light">
                    <tr>
                        <th>Role</th>
                        @foreach($topMenus as $topMenu)
                            <th>
                                {{ $topMenu->menu_name }}
                                @if($topMenu->subMenus->isNotEmpty())
                                    <br>
                                    <small class="text-muted">Submenus</small>
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($jenisusers as $role)
                        <tr>
                            <td>
                                {{ $role->jenis_user }}
                                <small>({{ $users->where('id_jenis_user', $role->id)->count() }} users)</small>
                            </td>
                            @foreach($topMenus as $topMenu)
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-menu" type="checkbox"
                                               id="menu-{{ $role->id }}-{{ $topMenu->id }}"
                                               data-role-id="{{ $role->id }}"
                                               data-menu-id="{{ $topMenu->id }}"
                                               {{ $role->settingMenuUsers->contains('menu_id', $topMenu->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="menu-{{ $role->id }}-{{ $topMenu->id }}">
                                            {{ $topMenu->menu_name }}
                                        </label>
                                    </div>
                                    @if($topMenu->subMenus->isNotEmpty())
                                        <div class="ml-3 mt-2">
                                            @foreach($topMenu->subMenus as $subMenu)
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input toggle-menu" type="checkbox"
                                                           id="menu-{{ $role->id }}-{{ $subMenu->id }}"
                                                           data-role-id="{{ $role->id }}"
                                                           data-menu-id="{{ $subMenu->id }}"
                                                           {{ $role->settingMenuUsers->contains('menu_id', $subMenu->id) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="menu-{{ $role->id }}-{{ $subMenu->id }}">
                                                        <small>{{ $subMenu->menu_name }}</small>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.toggle-menu').change(function() {
            const roleId = $(this).data('role-id');
            const menuId = $(this).data('menu-id');

            $.ajax({
                url: '{{ route("menu-assignments.toggle") }}',
                method: 'POST',
                data: {
                    role_id: roleId,
                    menu_id: menuId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response.status);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>


@endsection
