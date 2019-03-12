@extends('administrator.master')
@section('tag_admin_title', '- Admin Roles')
@section('main_section')
<admin-roles url="{{ url('/') }}/" />
@endsection
