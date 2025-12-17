

    
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                
            <div class="nav-item theme-logo">
                    <a href="<?php echo e(auth()->user()->hasAnyRole('doctor') ? route('doctor.dashboard') : route('admin-dashboard')); ?>"></a>
                        <img src="<?php echo e(Vite::asset('resources/images/logo.png')); ?>" class="navbar-logo logo-light" alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="<?php echo e(auth()->user()->hasAnyRole('doctor') ? route('doctor.dashboard') : route('admin-dashboard')); ?>" class="nav-link"> </a>
                </div>
            </div>
            
        </div>
        <?php if(!Request::is('collapsible-menu/*')): ?>
        
            <div class="profile-info">
                <div class="user-info">
                    <div class="profile-img">
                        <?php if(auth()->user()->profile_image != ''): ?>
                        <img src="<?php echo e(url(auth()->user()->profile_image)); ?>" alt="avatar">
                        <?php else: ?>
                        <img src="<?php echo e($profilePath); ?>" alt="avatar">
                        <?php endif; ?>
                    </div>
                    <div class="profile-content">
                        <h6 class=""><?php echo e(auth()->user()->name); ?></h6>
                        <p class=""><?php echo e(auth()->user()->email); ?></p>
                    </div>
                </div>
            </div>

        <?php endif; ?>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">

        <?php if(auth()->user()->hasAnyRole('admin')): ?>


        <li class="menu <?php echo e((Request::is('*/dashboard')) ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin-dashboard')); ?>" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    <span>Dashboard</span>
                </div>
            </a>
        </li>

        <li class="menu  <?php echo e((Request::is('*/user-management')) ? 'active' : ''); ?>">
            <a href="<?php echo e(route('user-management')); ?>" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Doctor Management</span>
                </div>
            </a>
        </li>

        <li class="menu  <?php echo e((Request::is('*/patients*')) ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.patients.index')); ?>" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17,11 19,13 23,9"></polyline></svg>
                    <span>Patient Management</span>
                </div>
            </a>
        </li>

        <li class="menu  <?php echo e((Request::is('*/settings*') || Request::is('*/email-management*')) ? 'active' : ''); ?>">
            <a href="#settings" data-bs-toggle="collapse" aria-expanded="<?php echo e((Request::is('*/settings*') || Request::is('*/email-management*')) ? 'true' : 'false'); ?>" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1 1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span>Settings</span>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9,18 15,12 9,6"></polyline></svg>
                </div>
            </a>
            <ul class="collapse submenu list-unstyled <?php echo e((Request::is('*/settings*') || Request::is('*/email-management*')) ? 'show' : ''); ?>" id="settings" data-bs-parent="#accordionExample">
                <li class="<?php echo e(Request::is('*/settings*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.settings.index')); ?>"> General Settings </a>
                </li>
                
                <li class="<?php echo e(Request::is('*/email-management*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.email-management.index')); ?>"> Email Management </a>
                </li>
                
                
            </ul>
        </li>


        <?php endif; ?>

        <?php if(auth()->user()->hasAnyRole('doctor')): ?>


        <li class="menu <?php echo e((Request::is('*/dashboard')) ? 'active' : ''); ?>">
            <a href="<?php echo e(route('doctor.dashboard')); ?>" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    <span>Dashboard</span>
                </div>
            </a>
        </li>

        <li class="menu <?php echo e((Request::is('*/patients') && !Request::is('*/patients/*')) ? 'active' : ''); ?>">
            <a href="<?php echo e(route('doctor.patients.index')); ?>" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>My Patients</span>
                </div>
            </a>
        </li>

        <li class="menu <?php echo e((Request::is('*/my-appointments')) ? 'active' : ''); ?>">
            <a href="<?php echo e(route('doctor.my-appointments')); ?>" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <span>My Appointments</span>
                </div>
            </a>
        </li>

        <li class="menu <?php echo e((Request::is('*/patients/add-appointment')) ? 'active' : ''); ?>">
            <a href="<?php echo e(route('doctor.patients.add-appointment')); ?>" aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                    <span>New Appointment</span>
                </div>
            </a>
        </li>


        <?php endif; ?>

        <li class="menu d-none <?php echo e((Request::is('*/settings')) ? "active" : ""); ?>">
                <a href="#user" data-bs-toggle="collapse" aria-expanded="<?php echo e(Request::is('*/settings') ? "true" : "false"); ?>" class="dropdown-toggle">
                    <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>Profile</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled <?php echo e(Request::is('*/settings') ? "show" : ""); ?>" id="user" data-bs-parent="#accordionExample">
                    <li class="<?php echo e(Request::routeIs('settings') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('settings')); ?>"> Account Settings </a>
                    </li>
                   
                    
                </ul>
            </li>


            

            
            
        </ul>
        
    </nav>

</div><?php /**PATH C:\Users\ANZO-KRUPALI\Desktop\sugarsightsaver1\resources\views/components/menu/vertical-menu.blade.php ENDPATH**/ ?>