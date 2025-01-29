<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul class="sidebar-vertical">
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="{{ Request::is('admin/dashboard*') ? 'active' : ' ' }}">
                    <a href="{{ route('admin.dashboard') }}"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
                </li>

                <li class="submenu">
                    <a href="#"
                        class="{{ Request::is('admin/profile*') || Request::is('admin/password*') || Request::is('admin/detail*') ? 'active' : ' ' }}"><i
                            class="la la-user-cog"></i> <span>Manage Account </span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li class="{{ Request::is('admin/profile*') ? 'active' : ' ' }}">
                            <a href="{{ route('admin.profile') }}">My Profile</a>
                        </li>
                        <li class="{{ Request::is('admin/password*') ? 'active' : ' ' }}">
                            <a href="{{ route('admin.password') }}">Change Password</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-title">
                    <span>Speciality Management</span>
                </li>
                <li class="{{ Request::is('admin/specializations*') ? 'active' : ' ' }}">
                    <a href="{{ route('specializations.index') }}"><i class="la la-heart"></i>
                        <span>Specialization</span></a>
                </li>
                <li class="{{ Request::is('admin/symptoms*') ? 'active' : ' ' }}">
                    <a href="{{ route('symptoms.index') }}"><i class="	fa fa-stethoscope"></i>
                        <span>Symptoms</span></a>
                </li>

                <li class="menu-title">
                    <span>User Management</span>
                </li>
                <li class="{{ Request::is('admin/patients*') ? 'active' : ' ' }}">
                    <a href="{{ route('patients.index') }}"><i class="fa fa-wheelchair"></i> <span>Manage
                            Patients</span></a>
                </li>

                <li class="{{ Request::is('admin/medical-stuff*') ? 'active' : ' ' }}">
                    <a href="{{ route('medical-stuff.index') }}"><i class="fas fa-user-md"></i> <span>Manage
                           Medical Stuff</span></a>
                </li>

                <li class="menu-title">
                    <span>Service Center Management</span>
                </li>
                <li class="{{ Request::is('admin/clinics*') ? 'active' : ' ' }}">
                    <a href="{{ route('clinics.index') }}"><i class="fas fa-clinic-medical"></i>
                        <span>Service Center</span></a>
                </li>
                <li class="{{ Request::is('admin/appointments*') ? 'active' : ' ' }}">
                    <a href="{{ route('appointments.index') }}"><i class="fa fa-calendar"></i>
                        <span>Appointments</span></a>
                </li>

                <li class="menu-title">
                    <span>Plan Section</span>
                </li>
                <li class="{{ Request::is('admin/plans*') ? 'active' : ' ' }}">
                    <a href="{{ route('plans.index') }}"><i class="la la-crown"></i> <span>Membership Plans</span></a>
                </li>
                {{-- <li class="{{ Request::is('admin/video-call-price*') ? 'active' : ' ' }}">
                    <a href="{{ route('video-call-price.index') }}"><i class="la la-video"></i> <span>Video Calling Price</span></a>
                </li> --}}
                <li class="menu-title">
                    <span>Transaction</span>
                </li>
                {{-- <li class="{{ Request::is('admin/donations*') ? 'active' : ' ' }}">
                    <a href="{{ route('donations.list') }}"><i class="la la-hand-holding-usd"></i> <span>Donations</span></a>
                </li> --}}
                <li class="{{ Request::is('admin/membership-history*') ? 'active' : ' ' }}">
                    <a href="{{ route('membership-history.index') }}"><i class="la la-usd"></i> <span>Membership
                            Transaction</span></a>
                </li>
                {{-- <li class="{{ Request::is('admin/video-call-payment*') ? 'active' : ' ' }}">
                    <a href="{{ route('video-call-payment.index') }}"><i class="la la-cc-stripe"></i> <span>Video Call Payment</span></a>
                </li> --}}
                <li class="menu-title">
                    <span>Others</span>
                </li>
                <li class="submenu">
                    <a href="#" class="{{ Request::is('admin/blogs*') ? 'active' : ' ' }}"><i
                            class="la la-blog"></i> <span>Blogs</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li class="{{ Request::is('admin/blogs/categories*') ? 'active' : ' ' }}">
                            <a href="{{ route('blogs.categories.index') }}">Category</a>
                        </li>
                        <li
                            class="{{ Request::is('admin/blogs') || Request::is('admin/blogs/create') || Request::is('admin/blogs/edit/*') ? 'active' : ' ' }}">
                            <a href="{{ route('blogs.index') }}">Details</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/contact-us*') ? 'active' : ' ' }}">
                    <a href="{{ route('contact-us.index') }}"><i class="la la-phone"></i> <span>Contact Us</span></a>
                </li>
                <li class="{{ Request::is('admin/help-and-support*') ? 'active' : ' ' }}">
                    <a href="{{ route('help-and-support.index') }}"><i class="la la-support"></i> <span>Help &
                            Support</span></a>
                </li>
                <li class="{{ Request::is('admin/newsletters*') ? 'active' : ' ' }}">
                    <a href="{{ route('newsletters.index') }}"><i class="la la-paper-plane"></i>
                        <span>Newsletter</span></a>
                </li>
                <li class="{{ Request::is('admin/notifications*') ? 'active' : ' ' }}">
                    <a href="{{ route('notifications.index') }}"><i class="la la-bell"></i> <span>Send
                            Notification</span></a>
                </li>
                <li class="{{ Request::is('admin/testimonials*') ? 'active' : ' ' }}">
                    <a href="{{ route('testimonials.index') }}"><i class="la la-comments"></i> <span>Testimonial</span></a>
                </li>
                <li class="{{ Request::is('admin/services*') ? 'active' : ' ' }}">
                    <a href="{{ route('services.index') }}"><i class="la la-tools"></i> <span>Service</span></a>
                </li>
                <li class="submenu">
                    <a href="#" class="{{ Request::is('admin/cms*') ? 'active' : ' ' }}"><i
                            class="la la-cog"></i> <span>Settings</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li class="{{ Request::is('admin/cms/logo*') ? 'active' : ' ' }}">
                            <a href="{{ route('cms.logo.index') }}">Logo </a>
                        </li>

                        <li class="{{ Request::is('admin/cms/footer*') ? 'active' : ' ' }}">
                            <a href="{{ route('cms.footer.index') }}">Footer Content</a>
                        </li>
                        <li class="{{ Request::is('admin/cms/home') ? 'active' : ' ' }}">
                            <a href="{{ route('cms.home.index') }}">Home Page Banners </a>
                        </li>
                        <li class="{{ Request::is('admin/cms/home-content*') ? 'active' : ' ' }}">
                            <a href="{{ route('cms.home-content.index') }}">Home Page Content </a>
                        </li>
                        <li class="{{ Request::is('admin/cms/telehealth*') ? 'active' : ' ' }}">
                            <a href="{{ route('cms.telehealth.index') }}">Telehealth Page Content </a>
                        </li>
                        <li class="{{ Request::is('admin/cms/qna*') ? 'active' : ' ' }}">
                            <a href="{{ route('cms.qna.index') }}">QNA Page</a>
                        </li>
                        <li class="{{ Request::is('admin/cms/contact-us*') ? 'active' : ' ' }}">
                            <a href="{{ route('cms.contact-us.index') }}">Contact Us Page</a>
                        </li>
                        <li class="{{ Request::is('admin/cms/terms-and-condition*') ? 'active' : ' ' }}">
                            <a href="{{ route('cms.terms-and-condition.index') }}">Terms & Condition Page</a>
                        </li>
                        <li class="{{ Request::is('admin/cms/privacy-policy*') ? 'active' : ' ' }}">
                            <a href="{{ route('cms.privacy-policy.index') }}">Privacy Policy Page</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
