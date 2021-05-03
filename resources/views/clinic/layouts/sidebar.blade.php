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

        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" style="    margin: 0 auto;" data-nav-type="accordion">

                <!-- Main -->


                @hasanyrole('clinic')
                <li class="nav-item {{request()->routeIs('reservations.index')?'active' :'' }}">
                    <a href="{{route('reservations.index')}}"
                       class="nav-link  ">
                        <span>الحجوزات</span>
                    </a>
                </li>
                <li class="nav-item  {{request()->routeIs('services.create')?'active' :'' }}">
                    <a href="{{route('services.create')}}"
                       class="nav-link ">
                        <span>إضافة خدمة</span>
                    </a>
                </li>
                <li class="nav-item  {{request()->routeIs('services.index')?'active' :'' }}">
                    <a href="{{route('services.index')}}"
                       class="nav-link ">
                        <span>إدارة الخدمات</span>
                    </a>
                </li>
                <li class="nav-item {{request()->routeIs('offers.create')?'active' :'' }}">
                    <a href="{{route('offers.create')}}"
                       class="nav-link  ">
                        <span>إضافة عرض</span>
                    </a>
                </li>
                <li class="nav-item  {{request()->routeIs('offers.index')?'active' :'' }}">
                    <a href="{{route('offers.index')}}"
                       class="nav-link ">
                        <span>إدارة العروض</span>
                    </a>
                </li>
                <li class="nav-item {{request()->routeIs('appointments.*')?'active' :'' }}">
                    <a href="{{route('appointments.index')}}"
                       class="nav-link  ">
                        <span>فتح المواعيد</span>
                    </a>
                </li>

                <li class="nav-item {{request()->routeIs('statics')?'active' :'' }}">
                    <a href="{{route('statics')}}"
                       class="nav-link  ">
                        <span>الدعم والاحصائيات</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('log_out') }}"
                       class="nav-link  ">
                        <span style="color: red">تسجيل الخروج</span>
                    </a>
                </li>

                @endhasanyrole


            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
