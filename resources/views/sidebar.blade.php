<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="in">
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark {{ request()->is('dashboard') ? 'active-link' : 'inactive-link' }}" 
                        href="{{ route('dashboard.index') }}" 
                        aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark {{ request()->is('products*') ? 'active-link' : 'inactive-link' }}" 
                        href="{{ route('products.index') }}" 
                        aria-expanded="false">
                        <i class="mdi mdi-store"></i>
                        <span class="hide-menu">Product</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark {{ request()->is('Purchase*') ? 'active-link' : 'inactive-link' }}" 
                        href="{{ route('purchases.index') }}"
                        aria-expanded="false">
                        <i class="mdi mdi-cart-outline"></i>
                        <span class="hide-menu">Purchase</span>
                    </a>
                </li>

                @if (Auth::user()->role == 'admin')
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark {{ request()->is('users*') ? 'active-link' : 'inactive-link' }}" 
                        href="{{ route('users.index') }}" 
                        aria-expanded="false">
                        <i class="mdi mdi-account-edit"></i>
                        <span class="hide-menu">User</span>
                    </a>
                </li>
                @endif
                
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
