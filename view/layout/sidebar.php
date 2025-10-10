<!-- Sidebar -->
<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <!-- User Profile Section -->
        <div class="user-info text-center p-3 border-bottom">
            <div class="user-avatar mb-3">
                <i class="fas fa-user-circle fa-3x text-primary"></i>
            </div>
            <h6 class="font-weight-bold"><?php echo $_SESSION['user_name']; ?></h6>
            <p class="text-muted small"><?php echo $_SESSION['user_email']; ?></p>
            <span class="badge badge-success">Administrator</span>
        </div>

        <!-- Navigation Menu -->
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active' : ''; ?>" href="dashboard">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Dashboard
                </a>
            </li>
            
            <!-- Institutes Module -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" href="#institutesCollapse" 
                   aria-expanded="<?php echo strpos($_SERVER['REQUEST_URI'], 'institutes') !== false ? 'true' : 'false'; ?>">
                    <i class="fas fa-university mr-2"></i>
                    Institutes
                    <i class="fas fa-chevron-down float-right mt-1"></i>
                </a>
                <div class="collapse <?php echo strpos($_SERVER['REQUEST_URI'], 'institutes') !== false ? 'show' : ''; ?>" id="institutesCollapse">
                    <ul class="nav flex-column pl-3">
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'institutes/manage') !== false ? 'active' : ''; ?>" 
                               href="institutes/manage">
                                <i class="fas fa-list mr-2"></i>Manage Institutes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'institutes/add') !== false ? 'active' : ''; ?>" 
                               href="add">
                                <i class="fas fa-plus-circle mr-2"></i>Add Institute
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'institutes/types') !== false ? 'active' : ''; ?>" 
                               href="institutes/types">
                                <i class="fas fa-tags mr-2"></i>Institute Types
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'institutes/departments') !== false ? 'active' : ''; ?>" 
                               href="institutes/departments">
                                <i class="fas fa-building mr-2"></i>Departments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'institutes/branches') !== false ? 'active' : ''; ?>" 
                               href="institutes/branches">
                                <i class="fas fa-code-branch mr-2"></i>Branches
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Other Modules (Placeholders) -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-book mr-2"></i>
                    Academic
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-users mr-2"></i>
                    Students
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chalkboard-teacher mr-2"></i>
                    Faculty
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    Finance
                </a>
            </li>

            <!-- Settings -->
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'profile') !== false ? 'active' : ''; ?>" href="profile">
                    <i class="fas fa-cog mr-2"></i>
                    Settings
                </a>
            </li>
        </ul>
    </div>
</nav>