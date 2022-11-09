@extends('layouts.app')

@section('content')
<p class="container-fluid bg-da">
    {{Auth()->user()['name']}}
    Dashboard</p>
@endsection
