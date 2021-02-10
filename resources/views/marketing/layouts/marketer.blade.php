<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('marketing.layouts.head')
<body class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
@include('marketing.layouts.header')
@include('marketing.layouts.aside_bar')
@section('content')
@show
@include('marketing.layouts.footer')
@include('marketing.layouts.footer_script')
</body>
</html>
