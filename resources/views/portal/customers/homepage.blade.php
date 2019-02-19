@extends('portal.customers.master')
@section('maincontent')
<customers-dashboard url="{{ url('/') }}" :datauser="{{ json_encode( $session ) }}" :connectlocale="{{ json_encode( __('connect') ) }}" :custdash="{{ json_encode( __('customer_dashboard') ) }}"></customers-dashboard>
@endsection
