<header class="top-navbar">

    <div class="navbar-left">

        <button type="button"
                class="sidebar-toggle"
                id="sidebarToggle">

            <i class="fas fa-bars"></i>

        </button>

        <div class="page-brand">
            Latin Electrical
        </div>

    </div>


    <div class="navbar-right">

        <button class="nav-icon">
            <i class="fas fa-search"></i>
        </button>

        <button class="nav-icon">
            <i class="fas fa-bell"></i>
        </button>


        <div class="user-menu">

            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>

            <div class="user-info">

                <strong>
                    {{ auth()->user()->name ?? 'User' }}
                </strong>

                <small>Administrator</small>

            </div>

            <i class="fas fa-chevron-down"></i>

        </div>

    </div>

</header>