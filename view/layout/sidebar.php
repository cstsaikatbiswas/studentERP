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
                <a class="nav-link <?php echo (isset($current_page) && $current_page == 'dashboard') ? 'active' : ''; ?>" 
                   href="<?= BASE_URL?>/dashboard">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Dashboard
                </a>
            </li>
            
            <!-- Institutes Module -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" href="#institutesCollapse" 
                   aria-expanded="<?php echo (isset($current_page) && strpos($current_page, 'institutes') !== false) ? 'true' : 'false'; ?>">
                    <i class="fas fa-university mr-2"></i>
                    Institutes
                    <i class="fas fa-chevron-down float-right mt-1"></i>
                </a>
                <div class="collapse <?php echo (isset($current_page) && strpos($current_page, 'institutes') !== false) ? 'show' : ''; ?>" id="institutesCollapse">
                    <ul class="nav flex-column pl-3">
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($current_page) && $current_page == 'institutes/manage') ? 'active' : ''; ?>" 
                               href="<?= BASE_URL?>/institutes/manage">
                                <i class="fas fa-list mr-2"></i>Manage Institutes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($current_page) && $current_page == 'institutes/add') ? 'active' : ''; ?>" 
                               href="<?= BASE_URL?>/institutes/add">
                                <i class="fas fa-plus-circle mr-2"></i>Add Institute
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($current_page) && $current_page == 'institutes/types') ? 'active' : ''; ?>" 
                               href="<?= BASE_URL?>/institutes/types">
                                <i class="fas fa-tags mr-2"></i>Institute Types
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($current_page) && $current_page == 'institutes/departments') ? 'active' : ''; ?>" 
                               href="<?= BASE_URL?>/institutes/departments">
                                <i class="fas fa-building mr-2"></i>Departments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($current_page) && $current_page == 'institutes/branches') ? 'active' : ''; ?>" 
                               href="<?= BASE_URL?>/institutes/branches">
                                <i class="fas fa-code-branch mr-2"></i>Branches
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Academic Module -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" href="#academicCollapse" 
                aria-expanded="<?php echo (isset($current_page) && strpos($current_page, 'academic') !== false) ? 'true' : 'false'; ?>">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Academic
                    <i class="fas fa-chevron-down float-right mt-1"></i>
                </a>
                <div class="collapse <?php echo (isset($current_page) && strpos($current_page, 'academic') !== false) ? 'show' : ''; ?>" id="academicCollapse">
                    <ul class="nav flex-column pl-3">
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($current_page) && $current_page == 'academic/programs') ? 'active' : ''; ?>" 
                            href="<?php echo BASE_URL; ?>/academic/programs">
                                <i class="fas fa-list mr-2"></i>Programs & Courses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($current_page) && $current_page == 'academic/batches') ? 'active' : ''; ?>" 
                            href="<?php echo BASE_URL; ?>/academic/batches">
                                <i class="fas fa-users mr-2"></i>Batch Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (isset($current_page) && $current_page == 'academic/subjects') ? 'active' : ''; ?>" 
                            href="<?php echo BASE_URL; ?>/academic/subjects">
                                <i class="fas fa-book mr-2"></i>Subjects
                            </a>
                        </li>
                       
                    </ul>
                </div>
            </li>

            <!-- Other Modules (Placeholders) -->
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
                <a class="nav-link <?php echo (isset($current_page) && $current_page == 'profile') ? 'active' : ''; ?>" 
                   href="<?= BASE_URL?>/profile">
                    <i class="fas fa-cog mr-2"></i>
                    Settings
                </a>
            </li>
        </ul>
    </div>
</nav>