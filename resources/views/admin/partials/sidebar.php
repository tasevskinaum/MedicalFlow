<?php

use App\Http\Models\Role;

?>
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
            if (Role::queryBuilder()->where('id', '=', auth()->user()->role_id)->first()->name == 'super_admin') { ?>
                <li class="sidebar-nav-item">
                    <a href="/admins" class="sidebar-link">
                        <span>Manage Admins</span>
                        <i class='bx bx-user'></i>
                    </a>
                </li>
            <?php }
            ?>
            <?php
            if (Role::queryBuilder()->where('id', '=', auth()->user()->role_id)->first()->name == 'admin') { ?>
                <li class="sidebar-nav-item">
                    <a href="/doctors" class="sidebar-link">
                        <span>Manage Doctors</span>
                        <i class='bx bx-first-aid'></i>
                    </a>
                </li>
            <?php }
            ?>
            <?php
            if (Role::queryBuilder()->where('id', '=', auth()->user()->role_id)->first()->name == 'doctor') { ?>
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
                <li class="sidebar-nav-item">
                    <a href="/patients" class="sidebar-link">
                        <span>Patients</span>
                        <i class='bx bxs-user-rectangle'></i>
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