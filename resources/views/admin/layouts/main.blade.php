<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('admin.layouts.head')
<body class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
@include('admin.layouts.header')
@include('admin.layouts.aside_bar')
@section('content')
@show
@include('admin.layouts.footer')
@include('admin.layouts.footer_script')
</body>
</html>
