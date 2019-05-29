@extends('portal.customers.master')
@section('maincontent')
<registration-biznetwifi 
    url="{{ url('/') }}" 
    :connectlocale="{{ json_encode( __('connect') ) }}"
    client_mac="{{ $mac }}" 
    uip="{{ $uip }}" 
    ssid="{{ $ssid }}" 
    startUrl="{{ $startUrl }}" 
    loc="{{ $loc }}" 
    ap="{{ $ap }}"></registration-biznetwifi>
@endsection
