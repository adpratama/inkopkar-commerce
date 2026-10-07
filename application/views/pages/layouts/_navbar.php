<div class="navbar">
    <div class="container-xl">
        <ul class="navbar-nav">
            <li class="nav-item <?= ($segment == "dashboard") ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-dashboard">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M13.45 11.55l2.05 -2.05" />
                            <path d="M6.4 20a9 9 0 1 1 11.2 0z" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        Dashboard
                    </span>
                </a>
            </li>
            <li class="nav-item <?= ($segment == "order") ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('order') ?>">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 6l11 0" />
                            <path d="M9 12l11 0" />
                            <path d="M9 18l11 0" />
                            <path d="M5 6l0 .01" />
                            <path d="M5 12l0 .01" />
                            <path d="M5 18l0 .01" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        Orders
                    </span>
                </a>
            </li>
            <li class="nav-item <?= ($segment == "product") ? 'active' : '' ?> dropdown">
                <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 6l11 0" />
                                <path d="M9 12l11 0" />
                                <path d="M9 18l11 0" />
                                <path d="M5 6l0 .01" />
                                <path d="M5 12l0 .01" />
                                <path d="M5 18l0 .01" />
                            </svg>
                        </span>
                    </span>
                    <span class="nav-link-title">
                        Product
                    </span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= base_url('product') ?>">
                        List of Product
                    </a>
                    <a class="dropdown-item" href="<?= base_url('stock') ?>">
                        Stock Management
                    </a>
                </div>
            </li>
            <li class="nav-item <?= ($segment == "setting") ? 'active' : '' ?> dropdown">
                <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        Setting
                    </span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= base_url('setting/menu') ?>">
                        Menu
                    </a>
                    <a class="dropdown-item" href="<?= base_url('setting/user') ?>">
                        User
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>