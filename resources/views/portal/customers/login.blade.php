@extends('portal.customers.master')
@section('maincontent')
<login-biznetwifi url="{{ url('/') }}" :connectlocale="{{ json_encode( __('connect') ) }}"></login-biznetwifi>
@endsection
