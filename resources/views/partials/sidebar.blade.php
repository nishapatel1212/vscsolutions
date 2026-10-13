<aside class="sidebar">

    <div class="sidebar-logo">
        <a href="{{ url('dashboard') }}">
            <img src="{{ asset('images/logo/latin_logo.png') }}"
                 alt="Latin Electrical">
        </a>
    </div>

    <div class="sidebar-menu">

        <a href="{{ url('dashboard') }}"
           class="sidebar-item {{ request()->is('dashboard') ? 'active' : '' }}">

            <i class="fas fa-home"></i>

            <span>Dashboard</span>
        </a>


        <a href="{{ url('safetycheck/index') }}"
           class="sidebar-item {{ request()->is('safetycheck/*') ? 'active' : '' }}">
            <i class="fas fa-file-signature"></i>
            <span>Safety Check</span>
        </a>


        <a href="{{ url('quote/index') }}"
           class="sidebar-item {{ request()->is('quote/*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Quotes</span>
        </a>

        <a href="{{ url('customer') }}" class="sidebar-item {{ request()->is('customer*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Customers</span>
        </a>

        <a href="{{ url('jobs') }}" class="sidebar-item {{ request()->is('jobs*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i>
            <span>Jobs</span>
        </a>

        <a href="{{ url('leads') }}" class="sidebar-item {{ request()->is('leads*') ? 'active' : '' }}">
            <i class="fas fa-inbox"></i>
            <span>Leads</span>
        </a>

    </div>

    {{-- <div class="sidebar-bottom">

        <a href="{{ url('logout') }}" class="sidebar-item">

            <i class="fas fa-sign-out-alt"></i>

            <span>Logout</span>

        </a>

    </div> --}}

</aside>