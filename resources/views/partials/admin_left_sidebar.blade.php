<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <li class="nav-item">
            <a href="{{route('admin.categories')}}" class="nav-link {{ (request()->is('admin/categories*')) ? 'active' : '' }}">
                <i class="nav-icon fab fa-audible"></i>
                <p>Categories<span class="right badge badge-danger">New</span>
                </p>
            </a>
        </li>


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
                <li class="nav-item">
                    <a href="{{route('admin.employees.create')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Customers with orders</p>
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

    </ul>
</nav>
