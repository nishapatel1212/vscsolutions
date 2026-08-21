<aside class="sidebar">

    <div class="sidebar-logo">
        <a href="{{ url('dashboard') }}">
            <img src="{{ asset('images/logo/latin_logo.jpeg') }}"
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

    </div>

    <div class="sidebar-bottom">

        <a href="{{ url('logout') }}" class="sidebar-item">

            <i class="fas fa-sign-out-alt"></i>

            <span>Logout</span>

        </a>

    </div>

</aside>