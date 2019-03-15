@extends('administrator.master')
@section('tag_admin_title', '- Client As Subscriber')
@section('main_section')
<client-subscriber url="{{ url('/') }}/" />
@endsection
