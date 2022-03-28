<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{route('user.profile')}}" class="nav-link {{ (request()->is('user/profile*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Profile</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('user.orders')}}" class="nav-link {{ (request()->is('user/orders*')) ? 'active' : '' }}">
                <i class="far fa-address-book nav-icon"></i>
                <p>All Orders</p>
                </p>
            </a>
        </li>

    </ul>
</nav>
