@extends('administrator.master')
@section('tag_admin_title', '- Log Activity')
@section('main_section')
<admin-log-activity url="{{ url('/') }}/" />
@endsection
