@extends('administrator.master')
@section('tag_admin_title', '- Dashboard')
@section('main_section')
<dashboard-admin url="{{ url('/') }}/" />
@endsection
