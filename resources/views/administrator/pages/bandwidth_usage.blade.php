@extends('administrator.master')
@section('tag_admin_title', '- Bandwidth Usage')
@section('main_section')
<bandwidth-usage url="{{ url('/') }}/" />
@endsection
