
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="{{route('admindashboard')}}"><i class="la la-dashboard"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a> </li>
            <li class=" nav-item"><a href="#"><i class="ft-clipboard"></i><span class="menu-title" data-i18n="nav.page_layouts.main">CMS</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{route('aboutus')}}" data-i18n="nav.page_layouts.fixed_navbar">About</a> </li>
                    <li><a class="menu-item" href="{{route('marketing')}}" data-i18n="nav.page_layouts.fixed_navbar_footer">Marketing</a> </li>
                    <li><a class="menu-item" href="{{route('termsandconditions')}}" data-i18n="nav.page_layouts.fixed_navigation">Terms & Conditions</a> </li>
                    <li><a class="menu-item" href="{{route('privacy')}}" data-i18n="nav.page_layouts.fixed_layout">Privacy Policy</a> </li>
                    <li><a class="menu-item" href="{{route('signupterms')}}" data-i18n="nav.page_layouts.fixed_navbar_navigation">Signup Terms</a> </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="icon-diamond"></i><span class="menu-title" data-i18n="nav.page_layouts.main">Extras</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{route('cat_list')}}" data-i18n="nav.page_layouts.fixed_navbar">Interests</a> </li>
                    <li><a class="menu-item" href="{{route('topic_list')}}" data-i18n="nav.page_layouts.fixed_navbar">Topics</a> </li>
                    <li><a class="menu-item" href="{{route('advertise')}}" data-i18n="nav.page_layouts.fixed_navbar">Advertis with us</a> </li>
                </ul>
            </li>
            <li class="nav-item"><a href="{{route('allcreditlogs')}}"><i class="la la-repeat"></i><span class="menu-title" data-i18n="nav.form_repeater.main">Credit Logs</span></a> </li>
            <li class="nav-item"><a href="{{route('alluserstransactions')}}"><i class="la la-money"></i><span class="menu-title" data-i18n="nav.add_on_block_ui.main">Transactions</span></a> </li>
            <li class="nav-item"><a href="{{route('all.marketing')}}"><i class="icon-volume-2"></i><span class="menu-title" data-i18n="nav.add_on_image_cropper.main">Marketing</span></a> </li>
            <li class=" nav-item"><a href="#"><i class="ft-trending-up"></i><span class="menu-title" data-i18n="nav.pickers.main">Analytics</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{route('analytics.marketing')}}" data-i18n="nav.pickers.pickers_date_time_picker">Marketing</a> </li>
                    <li><a class="menu-item" href="{{route('income')}}" data-i18n="nav.pickers.pickers_color_picker">Income</a> </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="{{route('alluser')}}"><i class="ft-users"></i><span class="menu-title" data-i18n="nav.add_on_drag_drop.main">Users</span></a> </li>
            <li class=" nav-item"><a href="{{route('allpushnotifications')}}"><i class="la la-comments"></i><span class="menu-title" data-i18n="">Push Notifications</span></a> </li>            <li class=" nav-item"><a href="{{route('admin.packages')}}"><i class="la la-dollar"></i><span class="menu-title" data-i18n="">Packages</span></a> </li>
            <!-- la la-bullseye -->
{{--            <li class=" nav-item"><a href="{{route('underconstruction')}}"><i class="icon-bar-chart"></i><span class="menu-title" data-i18n="nav.rickshaw_charts.main">Reports</span></a> </li>--}}
            <li class=" nav-item"><a href="javascript:void(0)"><i class="la la-gear"></i><span class="menu-title" data-i18n="nav.flot_charts.main">Settings</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{route('admin.edi.profile')}}" data-i18n="nav.flot_charts.flot_line_charts">Profile</a> </li>
                    <li><a class="menu-item" href="{{route('setting')}}" data-i18n="nav.flot_charts.flot_bar_charts">Payment</a> </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="{{ route('logout') }}"
                                     onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="ft-power"></i><span class="menu-title" data-i18n="nav.morris_charts.main">Signout</span></a> <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form></li>
        </ul>
    </div>
</div>

