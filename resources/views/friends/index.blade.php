@extends('layouts.app')
@section('content')
    <div class="container-fluid mt-4">


        <h4>Friends</h4>
        @foreach($onlyFriends as $fr)
            <div class="row">
                <div class="col-md-10">
                    <div class="p-3" style="font-size: 1.5em">

                        @if($fr->profile == null)
                            <img class="rounded-circle" src="/images/th.webp" alt=""
                                 style="width: 70px; height: 70px;">

                            <a href="{{Route('friend.profile', $fr->friend_id)}}"
                               class="text-decoration-none p-3">{{$fr->name}}</a>
                        @else
                            <img class="rounded-circle" src="/images/{{$fr->profile}}" alt=""
                                 style="width: 70px; height: 70px;">

                            <a href="{{Route('friend.profile', $fr->friend_id)}}"
                               class="text-decoration-none p-3">{{$fr->name}}</a>
                        @endif
                    </div>
                </div>

            </div>

        @endforeach

        <h3>Friend Requests</h3>
        @if($totalRequest > 0)
            @foreach( $friends as $f)

                @if($f->status =='accepted' )
                    {{--                    <a href="">{{$f->name}}</a>--}}
                    {{--                    <span class="badge bg-info">Accepted</span>--}}
                    {{--                    <br>--}}

                @else
                    @if($f->profile == null)
                        <table>
                            <tr>
                                <td class="mt-2">
                                    <img class="rounded-circle" src="/images/th.webp" alt=""
                                         style="width: 50px; height: 50px;">

                                </td>
                                <td style="font-size: 1.5em">
                                    <a href="{{Route('friend.profile', $f->friend_id)}}" style="text-decoration: none"
                                       class="">{{$f->name}}</a>

                                </td>
                                <td>
                                    <form action="{{Route('friend.accept', $f->friend_id)}}" method="post">
                                        @csrf
                                        {{$errors}}
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="status" name="status"
                                                   value="accepted">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="friend_id" name="friend_id"
                                                   value="{{$f->friend_id}}">
                                        </div>
                                        <div class="form-group">

                                            <input type="hidden" class="form-control" id="user_id" name="user_id"
                                                   value="{{$f->user_id}}">
                                        </div>
                                        <br>
                                        <button class="btn btn-primary btn-sm">Confirm</button>
                                    </form>


                                    <form action="{{Route('friend.reject', $f->friend_id)}}" method="post">
                                        @csrf
                                        {{$errors}}
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="status" name="status"
                                                   value="rejected">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="friend_id"
                                                   name="friend_id"
                                                   value="{{$f->friend_id}}">
                                        </div>
                                        <div class="form-group">

                                            <input type="hidden" class="form-control" id="user_id" name="user_id"
                                                   value="{{$f->user_id}}">
                                        </div>
                                        <br>

                                        <button class="btn btn-danger btn-sm">
                                            Delete
                                        </button>

                                    </form>

                                </td>
                            </tr>
                        </table>

                    @else
                        <table>
                            <tr>
                                <td>
                                    <img class="rounded-circle" src="/images/{{$f->profile}}" alt=""
                                         style="width: 50px; height: 50px;"> <a href="" style="text-decoration: none"
                                                                                class="">{{$f->name}}</a>
                                </td>
                                <td style="font-size: 1.5em">
                                    <a href="{{Route('friend.profile', $f->friend_id)}}" style="text-decoration: none"
                                       class="">{{$f->name}}</a>
                                </td>
                                <td>
                                    <form action="{{Route('friend.accept', $f->friend_id)}}" method="post">
                                        @csrf
                                        {{$errors}}
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="status" name="status"
                                                   value="rejected">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="friend_id" name="friend_id"
                                                   value="{{$f->friend_id}}">
                                        </div>
                                        <div class="form-group">

                                            <input type="hidden" class="form-control" id="user_id" name="user_id"
                                                   value="{{$f->userID}}">
                                        </div>
                                        <br>
                                        <button class="btn btn-primary btn-sm">Confirm</button>
                                    </form>


                                    <form action="{{Route('friend.reject', $f->friend_id)}}" method="post">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="status" name="status"
                                                   value="accepted">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="friend_id"
                                                   name="friend_id"
                                                   value="{{$f->friend_id}}">
                                        </div>
                                        <div class="form-group">

                                            <input type="hidden" class="form-control" id="user_id" name="user_id"
                                                   value="{{$f->userID}}">
                                        </div>
                                        <br>

                                        <button class="btn btn-danger btn-sm">
                                            Delete
                                        </button>

                                    </form>

                                </td>
                            </tr>
                        </table>
                    @endif
                @endif
            @endforeach
        @else
            <p>No friend request</p>
        @endif

    </div>

    <div class="card col-md-8 mt-2">
        <div class="card-header text-uppercase">Friends Suggestion</div>
        <div class="card-body">
            <table class="table">
                <tbody>
                @foreach($users as $user)
                    <tr>
                        @if($user->status === 'pending' && $user->userID === Auth()->user()['id']  )
                            <td><a href="" style="text-decoration: none">{{$user->name}}</a></td>
                            <td><span class="badge bg-info"><i>Request sent</i></span></td>
                        @else
                            <td><a href="" style="text-decoration: none">
                                    {{$user->id}}
                                    {{$user->name}}
                                </a>
                            </td>
                            <td>
                                <a href="{{Route('friend.add', $user->id)}}" class="btn btn-sm btn-primary">
                                    Add friend
                                </a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{--        <div class="p-2">--}}
        {{--            {{$users->links('pagination::bootstrap-5')}}--}}
        {{--        </div>--}}
    </div>

    </div>

@endsection
