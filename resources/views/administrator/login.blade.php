<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('administrator.includes.meta-header')
<title>BiznetWifi - Login Administrator</title>
</head>
<body>
<div id="app">
  <section-login url="{{ asset('/') }}"></section-login>
</div>
<script src="{{ asset('js/admin/app.administrator.js') }}"></script>
</body>
</html>
