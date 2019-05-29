@extends('portal.members.master')
@section('maincontent')
<members-dashboard url="{{ url('/') }}" :datauser="{{ json_encode( $session ) }}" :connectlocale="{{ json_encode( __('connect') ) }}" :custdash="{{ json_encode( __('customer_dashboard') ) }}"></members-dashboard>
@endsection
