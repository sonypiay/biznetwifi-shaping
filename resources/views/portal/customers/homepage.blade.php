@extends('portal.customers.master')
@section('maincontent')
<customers-dashboard url="{{ url('/') }}" :datauser="{{ json_encode( $session ) }}"></customers-dashboard>
@endsection
