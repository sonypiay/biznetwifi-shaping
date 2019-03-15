@extends('administrator.master')
@section('tag_admin_title', '- Client As Visitor')
@section('main_section')
<client-visitor url="{{ url('/') }}/" />
@endsection
