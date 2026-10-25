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

        @can('manage-safety-checks')
        <a href="{{ url('safetycheck/index') }}"
           class="sidebar-item {{ request()->is('safetycheck/*') ? 'active' : '' }}">
            <i class="fas fa-file-signature"></i>
            <span>Safety Check</span>
        </a>
        @endcan

        @can('manage-quotes')
        <a href="{{ url('quote/index') }}"
           class="sidebar-item {{ request()->is('quote/*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Quotes</span>
        </a>
        @endcan

        @can('manage-customers')
        <a href="{{ url('customer') }}" class="sidebar-item {{ request()->is('customer*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Customers</span>
        </a>
        @endcan

        @can('manage-jobs')
        <a href="{{ url('jobs') }}" class="sidebar-item {{ request()->is('jobs*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i>
            <span>Jobs</span>
        </a>
        @endcan

        @can('manage-leads')
        <a href="{{ url('leads') }}" class="sidebar-item {{ request()->is('leads*') ? 'active' : '' }}">
            <i class="fas fa-inbox"></i>
            <span>Leads</span>
        </a>
        @endcan

        @can('use-chatbot')
        <a href="{{ url('chatbot/index') }}" class="sidebar-item {{ request()->is('chatbot*') ? 'active' : '' }}">
            <i class="fas fa-robot"></i>
            <span>Chatbot</span>
        </a>
        @endcan

        @can('view-audit-logs')
        <a href="{{ url('audit-logs') }}" class="sidebar-item {{ request()->is('audit-logs*') ? 'active' : '' }}">
            <i class="fas fa-history"></i>
            <span>Audit Log</span>
        </a>
        @endcan

        @canany(['manage-users', 'manage-roles'])
        <div class="sidebar-section-label">Administration</div>
        @endcanany

        @can('manage-users')
        <a href="{{ url('users') }}" class="sidebar-item {{ request()->is('users*') ? 'active' : '' }}">
            <i class="fas fa-user-cog"></i>
            <span>Users</span>
        </a>
        @endcan

        @can('manage-roles')
        <a href="{{ url('roles') }}" class="sidebar-item {{ request()->is('roles*') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i>
            <span>Roles</span>
        </a>

        <a href="{{ url('permissions') }}" class="sidebar-item {{ request()->is('permissions*') ? 'active' : '' }}">
            <i class="fas fa-key"></i>
            <span>Permissions</span>
        </a>
        @endcan

    </div>

    <div class="sidebar-bottom">

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-item" style="border:none;background:none;width:100%;text-align:left;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>

    </div>

</aside>
