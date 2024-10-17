<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @foreach($menus as $menu)
    @php
        $subMenus = $menu->subMenus;
        $isMenuVisible = in_array($menu->id, $selectedMenus) || $subMenus->whereIn('id', $selectedMenus)->isNotEmpty();
    @endphp

    @if($isMenuVisible)
        <li class="nav-item">
            @if($subMenus->isNotEmpty())
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#menu-{{ $menu->id }}">
                    <i class="{{ $menu->menu_icon }} mr-2"></i>
                    <span class="menu-title">{{ $menu->menu_name }}</span>
                    <i class="menu-arrow"></i>
                </a>
                <ul id="menu-{{ $menu->id }}" class="nav flex-column collapse sub-menu">
                    @foreach($subMenus as $subMenu)
                        @if(in_array($subMenu->id, $selectedMenus))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ $subMenu->menu_link }}">{{ $subMenu->menu_name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @else
                <a class="nav-link" href="{{ $menu->menu_link }}">
                    <i class="{{ $menu->menu_icon }} mr-2"></i>
                    <span class="menu-title">{{ $menu->menu_name }}</span>
                </a>
            @endif
        </li>
    @endif
@endforeach

    </ul>
</nav>

<script>
    $(document).ready(function() {
     $('[data-toggle="collapse"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        $(target).collapse('toggle');
    });
});
</script>
