@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.app')
@section('content')
    user profile

    <div class="container-fluid col-md-12 mt-4">
        <div class="row">
            <div class="col-md-4">
                @if($friend->profile == null)
                    <img class="rounded-circle" src="/images/th.webp" alt="" style="width: 250px; height: 250px;">

                @else
                    <img class="rounded-circle" src="/images/{{$friend->profile}}" alt=""
                         style="width: 250px; height: 250px;">

                @endif

                    @if(Auth::user()['id']== $friend->uId)
                        <div class="mt-4 m-lg-5">
                            <a href="{{Route('profile.image')}}" class="btn btn-primary">
                                Edit Profile Pic
                            </a>
                        </div>
                    @endif
            </div>
            <div class="col-md-8">
                <b>Name: </b>{{ $friend->name}}<br>
                <b>Followers: </b>{{$friend->total_friends}}
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
