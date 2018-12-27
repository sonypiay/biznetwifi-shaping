@extends('portal.customers.master')
@section('maincontent')
<login-biznetwifi url="{{ url('/') }}" :connectlocale="{{ json_encode( __('connect') ) }}" :homepagelocale="{{ json_encode( __('homepage') ) }}"></login-biznetwifi>
@endsection
