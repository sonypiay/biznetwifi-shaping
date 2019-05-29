@extends('portal.members.master')
@section('maincontent')
<login-member url="{{ url('/') }}" :connectlocale="{{ json_encode( __('connect') ) }}"></login-member>
@endsection
