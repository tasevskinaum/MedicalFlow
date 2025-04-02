<aside class="sidebar">
    <a href="/dashboard" class="sidebar-logo">
        <img src="/storage/images/clinic-logo.png" alt="">
    </a>
    <button class="close-btn">
        <span class="bar bar-1"></span>
        <span class="bar bar-2"></span>
    </button>
    <nav>
        <ul class="sidebar-nav">
            <?php
            if (!(auth()->user()->role_id != 1)) { ?>
                <li class="sidebar-nav-item">
                    <a href="/admins" class="sidebar-link">
                        <span>Manage Admins</span>
                        <i class='bx bx-user'></i>
                    </a>
                </li>
            <?php }
            ?>
            <?php
            if (!(auth()->user()->role_id != 2)) { ?>
                <li class="sidebar-nav-item">
                    <a href="/doctors" class="sidebar-link">
                        <span>Manage Doctors</span>
                        <i class='bx bx-first-aid'></i>
                    </a>
                </li>
            <?php }
            ?>
            <?php
            if (!(auth()->user()->role_id != 3)) { ?>
                <li class="sidebar-nav-item">
                    <a href="/doctors/<?= auth()->user()->id ?>/schedule" class="sidebar-link">
                        <span>Work Schedule</span>
                        <i class='bx bx-calendar-check'></i>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="/appointments" class="sidebar-link">
                        <span>Upcoming Appointments</span>
                        <i class='bx bx-time-five'></i>
                    </a>
                </li>
            <?php }
            ?>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <ul class="social-links">
            <li class="social-links-item">
                <a href="" class="social-link">
                    <i class='bx bxl-tiktok'></i>
                </a>
            </li>
            <li class="social-links-item">
                <a href="" class="social-link">
                    <i class='bx bxl-facebook-circle'></i>
                </a>
            </li>
            <li class="social-links-item">
                <a href="" class="social-link">
                    <i class='bx bxl-instagram'></i>
                </a>
            </li>
        </ul>
    </div>
</aside>