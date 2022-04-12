<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{route('admin.dashboard')}}" class="nav-link {{ (request()->is('admin/dashboard*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>Dashboard</span>
                </p>
            </a>
        </li>
        @if(auth()->user()->isOrdersAdministrator() || auth()->user()->isWarehouseManager())
        <li class="nav-item">
            <a href="{{route('admin.orders')}}" class="nav-link {{ (request()->is('admin/orders*')) ? 'active' : '' }}">
                <i class="nav-icon far fa-newspaper"></i>
                <p>Orders</span>
                </p>
            </a>
        </li>
        @endif

        <li class="nav-item">
            <a href="#" class="nav-link {{ (request()->is('admin/customers*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>
                    Customers
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                    <a href="{{route('admin.customers')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Customers</p>
                    </a>
                </li>

            </ul>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link {{ (request()->is('admin/products*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-code"></i>
                <p>
                    Products
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                    <a href="{{route('admin.products')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Published products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.products.unpublished')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Unpublished products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.products.out.of.stock')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Out of stock products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.products.deleted')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Deleted products</p>
                    </a>
                </li>
               <li class="nav-item">
                    <a href="{{route('admin.products.create')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Create product</p>
                    </a>
                </li>

            </ul>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link {{ (request()->is('admin/contact-us*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-question"></i>
                <p>
                    Contact Us
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                    <a href="{{route('admin.contact.us.in.progress')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>In progress</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.contact.us.closed')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Closed</p>
                    </a>
                </li>
            </ul>
        </li>

        @if(auth()->user()->isMasterAdministrator())

        <li class="nav-item">
            <a href="#" class="nav-link {{ (request()->is('admin/employees*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Employees
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                    <a href="{{route('admin.employees')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Employees</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.employees.create')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Create Employee</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="{{route('admin.categories')}}" class="nav-link {{ (request()->is('admin/categories*')) ? 'active' : '' }}">
                <i class="nav-icon fab fa-audible"></i>
                <p>Categories
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link {{ (request()->is('admin/coupons*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-copyright"></i>
                <p>
                    Coupons
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                    <a href="{{route('admin.coupons')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Coupons</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.create.coupons')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Create Coupon</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="{{route('admin.settings')}}" class="nav-link {{ (request()->is('admin/settings')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-cog"></i>
                <p>Settings</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.logs')}}" class="nav-link {{ (request()->is('admin/logs')) ? 'active' : '' }}">
                <i class="nav-icon far fa-address-card"></i>
                <p>Logs</p>
            </a>
        </li>
            @endif

    </ul>
</nav>
