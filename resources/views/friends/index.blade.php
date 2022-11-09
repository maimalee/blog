@extends('layouts.app')
@section('content')
    <div class="container-fluid mt-4">
        <div class="card col-md-8 mt-2">
            <div class="card-header text-uppercase">Friend Request</div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                    @foreach( $friends as $f)
                        @if($f->status =='accepted' )
                            <tr>
                                <td><span class="badge bg-info">Accepted</span></td>

                                @else
                                    <form action="{{Route('friend.accept', $f->friend_id)}}" method="post">
                                        @csrf
                                        {{$errors}}
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="status" name="status" value="accepted">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="friend_id" name="friend_id" value="{{$f->friend_id}}">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{Auth()->user()['id']}}">
                                        </div>
                                        <td><a href="" style="text-decoration: none" class="">{{$f->name}}</a></td>
                                        <td><button class="btn btn-primary btn-sm">Accept</button>
                                    </form>
                            </tr>

                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card col-md-8 mt-2">
            <div class="card-header text-uppercase">Friends Suggestion</div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                    @foreach($users as $f)
                        <tr>
                            @if($f->status === 'pending' )
                                <td><a href="" style="text-decoration: none">{{$f->name}}</a></td>
                                <td><span class="badge bg-info"><i>Request sent</i></span></td>
                            @else
                                <td><a href="" style="text-decoration: none">{{$f->name}}</a></td>

                                <td>
                                    <a href="{{Route('friend.add', $f->id)}}" class="btn btn-sm btn-primary">Add
                                        friend</a></td>

                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-2">
                {{$users->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>

@endsection
