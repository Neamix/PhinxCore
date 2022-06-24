<aside class="app-sidebar">
    <div class="main-sidebar-header active">
        <a class="header-logo active" href="index.html">
            <img src="@if(app()->make('setup',['type' => 'header logo'])[0])  {{ asset('storage/system/small/'.app()->make('setup',['type' => 'header logo'])[0]) }} @else {{ asset('admin/img/brand/logo.png') }} @endif" class="main-logo  desktop-logo" alt="logo">
            <img src="@if(app()->make('setup',['type' => 'header logo'])[0])  {{ asset('storage/system/small/'.app()->make('setup',['type' => 'header logo'])[0]) }} @else {{ asset('admin/img/brand/logo.png') }} @endif" class="main-logo  desktop-dark" alt="logo">
            <img src="@if(app()->make('setup',['type' => 'header logo'])[0])  {{ asset('storage/system/small/'.app()->make('setup',['type' => 'short logo'])[0]) }} @else {{ asset('admin/img/brand/logo.png') }} @endif" class="main-logo  mobile-logo" alt="logo">
            <img src="@if(app()->make('setup',['type' => 'header logo'])[0])  {{ asset('storage/system/small/'.app()->make('setup',['type' => 'short logo'])[0]) }} @else {{ asset('admin/img/brand/logo.png') }} @endif" class="main-logo  mobile-dark" alt="logo">
        </a>
    </div>
    <div class="main-sidemenu">
        <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
        <ul class="side-menu">
            <li class="side-item side-item-category">Main</li>
            <li class="slide">
                <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('dashboard') }}">
                    <i class="icon ion-md-stats me-2"></i>
                    <span class="side-menu__label">Dashboards</span>
                </a>
            </li>
        </ul>

        @foreach($menus as $menu_key => $menu)
        <ul class="side-menu">
            <li class="side-item side-item-category">{{ $menu_key }}</li>
            @foreach($menu as $item)
            <li class="slide ">
                <a class="side-menu__item" data-bs-toggle="slide" href="{{ route(strtolower($item->name)) }}">
                    <i class="{{ $item->icon_class }} me-2"></i>
                    <span class="side-menu__label">{{ ucwords($item->name) }}</span>
                </a>
            </li>
            @endforeach
            <li class="slide ">
                <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('category.index') }}">
                    <i class="icon ion-md-pricetags me-2"></i>
                    <span class="side-menu__label">Category</span>
                </a>
            </li>
        </ul>

        @endforeach

        <ul class="side-menu">
            <li class="side-item side-item-category ">Settings</li>
            <li class="slide">
                <a class="side-menu__item py-2" data-bs-toggle="slide" href="{{ route('setup.index') }}">
                    <i class="icon ion-md-settings me-2"></i>
                    <span class="side-menu__label">Setup</span>
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item py-2" data-bs-toggle="slide" href="{{ route('info.index') }}">
                    <i class="fas fa-exclamation me-2"></i>
                    <span class="side-menu__label">Website Info</span>
                </a>
            </li>
        </ul>
    </div>
</aside>