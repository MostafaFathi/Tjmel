<div class="sidebar sidebar-dark sidebar-main sidebar-fixed sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        {{ config('app.name', 'Env Friends') }}
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">

                    <div class="media-body">
                        <div class="media-title font-weight-semibold"><span>مرحبا بك </span>, {{auth()->user()->name}}
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->

                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link ">
                        <i class="icon-home4"></i>
                        <span>الرئيسية</span>
                    </a>
                </li>
                @hasanyrole('admin|user')
                @can('Manage Advertisements')
                <li class="nav-item ">
                    <a href="{{route('advertisements.index')}}"
                       class="nav-link  {{request()->routeIs('advertisements.*')?'active' :'' }}">
                        <i class="icon-megaphone"></i>
                        <span>إدارة الاعلانات</span>
                    </a>
                </li>
                @endcan
                @can('Manage Tips')
                <li class="nav-item ">
                    <a href="{{route('tips.index')}}"
                       class="nav-link  {{request()->routeIs('tips.*')?'active' :'' }}">
                        <i class="icon-image2"></i>
                        <span>إدارة التلميحات</span>
                    </a>
                </li>
                @endcan
                @can('Manage Clinics')
                <li class="nav-item ">
                    <a href="{{route('clinics.index')}}"
                       class="nav-link  {{request()->routeIs('clinics.*')?'active' :'' }}">
                        <i class="icon-office"></i>
                        <span>إدارة العيادات</span>
                    </a>
                </li>
                @endcan
                @can('Manage Sections')
                <li class="nav-item ">
                    <a href="{{route('sections.index')}}"
                       class="nav-link  {{request()->routeIs('sections.*')?'active' :'' }}">
                        <i class="icon-menu3"></i>
                        <span>إدارة الاقسام</span>
                    </a>
                </li>
                @endcan
                @can('Manage Services')
                <li class="nav-item ">
                    <a href="{{route('services.acceptance')}}"
                       class="nav-link  {{request()->routeIs('services.*')?'active' :'' }}">
                        <i class="icon-yin-yang"></i>
                        <span>إدارة الخدمات</span>
                    </a>
                </li>
                @endcan
                @can('Manage Offers')
                <li class="nav-item ">
                    <a href="{{route('offers.acceptance')}}"
                       class="nav-link  {{request()->routeIs('offers.*')?'active' :'' }}">
                        <i class="icon-price-tag2"></i>
                        <span>إدارة العروض</span>
                    </a>
                </li>
                @endcan
                @can('Manage Reservations')
                <li class="nav-item ">
                    <a href="{{route('admin.reservations.index')}}"
                       class="nav-link  {{request()->routeIs('reservations.*')?'active' :'' }}">
                        <i class="icon-reminder"></i>
                        <span>إدارة الحجوزات</span>
                    </a>
                </li>
                @endcan
                @can('Manage App users')
                <li class="nav-item ">
                    <a href="{{route('app_users.index')}}"
                       class="nav-link  {{request()->routeIs('app_users.*')?'active' :'' }}">
                        <i class="icon-users4"></i>
                        <span>إدارة مستخدمي التطبيق</span>
                    </a>
                </li>
                @endcan
                @can('Manage Rates')
                <li class="nav-item ">
                    <a href="{{route('rates.index')}}"
                       class="nav-link  {{request()->routeIs('rates.*')?'active' :'' }}">
                        <i class="icon-star-full2"></i>
                        <span>إدارة التقييمات</span>
                    </a>
                </li>
                @endcan

                @endhasanyrole
                @hasanyrole('admin|user')
                @canany('Manage Settings','Manage Web users','Manage About us','Manage Agreement','Manage Contact us','Manage Clinic requests','Manage Telescope')
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs">الاعدادات</div>
                    <i class="icon-menu" title="Admin"></i>
                </li>
                @endcanany
                @can('Manage Settings')
                <li class="nav-item ">
                    <a href="{{route('settings.edit',0)}}"
                       class="nav-link  {{request()->routeIs('edit.*')?'active' :'' }}">
                        <i class="icon-cog3"></i>
                        <span> الاعدادات</span>
                    </a>
                </li>
                @endcan
                @can('Manage Web users')
                <li class="nav-item ">
                    <a href="{{route('users.index')}}"
                       class="nav-link  {{request()->routeIs('users.*')?'active' :'' }}">
                        <i class="icon-user"></i>
                        <span>إدارة المستخدمين</span>
                    </a>
                </li>
                @endcan
                @can('Manage About us')
                <li class="nav-item ">
                    <a href="{{route('about_us.create')}}"
                       class="nav-link  {{request()->routeIs('about_us.*')?'active' :'' }}">
                        <i class="icon-info22"></i>
                        <span>من نحن</span>
                    </a>
                </li>
                @endcan
                @can('Manage Agreement')
                <li class="nav-item ">
                    <a href="{{route('agreement.create')}}"
                       class="nav-link  {{request()->routeIs('agreement.*')?'active' :'' }}">
                        <i class="icon-quill4"></i>
                        <span>اتفاقية المستخدم</span>
                    </a>
                </li>
                @endcan
                @can('Manage Contact us')
                <li class="nav-item ">
                    <a href="{{route('contact_us.index')}}"
                       class="nav-link  {{request()->routeIs('contact_us.*')?'active' :'' }}">
                        <i class="icon-envelop"></i>
                        <span>اتصل بنا</span>
                    </a>
                </li>
                @endcan
                @can('Manage Clinic requests')
                <li class="nav-item ">
                    <a href="{{route('applications.index')}}"
                       class="nav-link  {{request()->routeIs('applications.*')?'active' :'' }}">
                        <i class="icon-touch"></i>
                        <span>طلبات العيادات</span>
                    </a>
                </li>
                @endcan
                @can('Manage Telescope')
                <li class="nav-item ">
                    <a href="{{route('telescope_view')}}"
                       class="nav-link  {{request()->routeIs('telescope_view*')?'active' :'' }}">
                        <i class="icon-eye"></i>
                        <span>تلسكوب</span>
                    </a>
                </li>

                @endcan


                <li class="nav-item d-none">
                    <a href="{{route('users_groups.index')}}"
                       class="nav-link  {{request()->routeIs('users_groups.*')?'active' :'' }}">
                        <i class="icon-users4"></i>
                        <span>إدارة المجموعات</span>
                    </a>
                </li>
                <li class="nav-item d-none">
                    <a href="{{route('users_groups_permissions.index')}}"
                       class="nav-link  {{request()->routeIs('users_groups_permissions.*')?'active' :'' }}">
                        <i class="icon-user-tie"></i>
                        <span>إدارة الصلاحيات</span>
                    </a>
                </li>

                @endhasanyrole


            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
