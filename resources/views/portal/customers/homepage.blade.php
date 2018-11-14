@extends('portal.customers.master')
@section('maincontent')
<customers-dashboard url="{{ url('/') }}" :datauser="{{ json_encode( $getCookie ) }}"></customers-dashboard>
@endsection
