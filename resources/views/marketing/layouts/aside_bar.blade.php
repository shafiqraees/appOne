<!-- aside bar start here-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="{{ route('home') }}"><i class="la la-dashboard"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a> </li>
            <li class="nav-item"><a href="{{ route('buyredits') }}"><i class="la la-repeat"></i><span class="menu-title" data-i18n="nav.form_repeater.main">Buy Credits</span></a> </li>
            <li class="nav-item"><a href="{{ route('transactions') }}"><i class="la la-money"></i><span class="menu-title" data-i18n="nav.add_on_block_ui.main">Transactions</span></a> </li>
            <li class="nav-item"><a href="{{route('marketer.marketing')}}"><i class="icon-volume-2"></i><span class="menu-title" data-i18n="nav.add_on_image_cropper.main">Marketing</span></a> </li>
            <li class=" nav-item"><a href="{{route('under-cons')}}"><i class="la la-comments"></i><span class="menu-title" data-i18n="">Analytics</span></a> </li>
            <li class=" nav-item"><a href="{{route('edit.profile')}}"><i class="la la-gear"></i><span class="menu-title" data-i18n="nav.flot_charts.main">Settings</span></a></li>
            <li class=" nav-item"><a href="{{ route('logout') }}"
                                     onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="ft-power"></i><span class="menu-title" data-i18n="nav.morris_charts.main">Signout</span></a> <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form></li>
        </ul>
    </div>
</div>
<!-- aside bar end here-->
