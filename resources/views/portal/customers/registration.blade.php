@extends('portal.customers.master')
@section('maincontent')
<registration-biznetwifi url="{{ url('/') }}" :connectlocale="{{ json_encode( __('connect') ) }}"></registration-biznetwifi>
@endsection
