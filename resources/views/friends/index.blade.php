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
                    <div class="row">
                        @if($f->profile == null)
                            <div class="col-md-3 mt-2">
                                <img class="rounded-circle" src="/images/th.webp" alt=""
                                     style="width: 50px; height: 50px;">

                                <a href="{{Route('friend.profile', $f->friend_id)}}" style="text-decoration: none"
                                   class="">{{$f->name}}</a>
                            </div>
                        @else
                            <div class="col-md-3 mt-2">
                                <img class="rounded-circle" src="/images/{{$f->profile}}" alt=""
                                     style="width: 50px; height: 50px;">

                                <a href="{{Route('friend.profile', $f->friend_id)}}"
                                   style="text-decoration: none; margin-left: 13px;"
                                   class="">{{$f->name}}</a>

                            </div>
                        @endif
                        <div class="col-md-1 mt-3">
                            <form action="" method="">
                                @csrf

                                <button class="btn btn-primary btn-sm btn-accept" data-accept-id="{{$f->user_id}}">
                                    Confirm
                                </button>
                            </form>
                        </div>

                        <div class="col-md-1 mt-3">
                            <form action="" method="GET">
                                @csrf
                                <button class="btn btn-danger btn-sm btn-reject" data-reject-id="{{$f->user_id}}">
                                    Reject
                                </button>

                            </form>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <p>No friend request</p>
        @endif
        <div class="card col-md-8 mt-2">
            <div class="card-header text-uppercase">Friends Suggestion</div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                    @foreach($users as $user)
                        <tr>

                            @if($user->fstatus === 'pending' && $user->userId === Auth()->user()['id']  )
                                <td><a href="" style="text-decoration: none">{{$user->name}}</a></td>
                                <td><span class="badge bg-info"><i>Request sent</i></span></td>
                            @elseif($user->fstatus === 'accepted' && $user->userId === Auth()->user()['id'] )
                            @elseif($user->fstatus === 'rejected' && $user->userId === Auth()->user()['id'] )
                            @else
                                <td><a href="" style="text-decoration: none">
                                        {{$user->id}}
                                        {{$user->name}}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{Route('friend.add', $user->id)}}"
                                       class="btn btn-sm btn-primary">
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
@section('script')
    <script>
        $(document).ready(function () {
            $('.btn-accept').click(function (e) {
                e.preventDefault();
                const button = e.currentTarget;
                const $acceptId = button.dataset.acceptId;
                alert($acceptId);
                swal({
                    title: "Are you sure?",
                    text: "You can also edit it if you like",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: `/api/friend/${$acceptId}/accept`,
                            method: 'GET',
                            success: function (response) {
                                swal('You successfully edited your blog', {
                                    icon: "success",
                                }).then(() => {
                                    location.reload()
                                });
                            },
                            error: function (response) {
                                swal("ops unable to edit the blog", {
                                    icon: "error",
                                })
                                    .then((willDelete) => {
                                        location.reload()
                                    });
                            }
                        })
                    }
                });
            });
            $('.btn-reject').click(function (e) {
                e.preventDefault();
                const button = e.currentTarget;
                const $rejectId = button.dataset.rejectId;
                alert($rejectId);
                swal({
                    title: "Are you sure?",
                    text: "You can also edit it if you like",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: `/api/friend/${$rejectId}/delete`,
                                method: 'GET',
                                success: function (response) {
                                    swal('You successfully edited your blog', {
                                        icon: "success",
                                    })
                                        .then((willDelete) => {
                                            location.reload()
                                        });
                                },
                                error: function (response) {
                                    swal("ops unable to edit the blog", {
                                        icon: "error",
                                    })
                                        .then((willDelete) => {
                                            location.reload()
                                        });
                                }
                            })
                        }
                    });
            });
        });
    </script>
@endsection
