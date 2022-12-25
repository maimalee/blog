@extends('layouts.app')
@section('content')
    <div class="container-fluid col-md-10 mt3">


        <div class="card mt-3">

            <div class="card-header text-uppercase">Users</div>
            <div class="card-body">
                <div class="text-end">


                    <a href="{{Route('user.add')}}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i>
                        Add User
                    </a>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $u)
                        <tr>
                            <td>{{$u->id}}</td>

                            <td><a href="{{Route('users.show', $u->id)}}" style="text-decoration: none" class="">
                                    {{$u->name}} </a></td>
                            <td>{{$u->email}}</td>
                            <td>{{$u->role}}</td>
                            <div class="row">
                                <td>
                                    <a href="{{Route('users.edit', $u->id)}}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </a>
                                    <input type="hidden" value="{{$u->id}}" class="btn btn-primary userDeleteHide">
                                    <button class="btn btn-danger userDeleteBtn" data-delete-id="{{$u->id}}">
                                        <i class="fa fa-trash"></i>
                                        Delete
                                    </button>

                                    {{--                                    <a href="{{Route('user.delete', $u->id)}}" class="btn btn-danger btn-sm">--}}
                                    {{--                                        <i class="fa fa-trash"></i>--}}
                                    {{--                                        Delete--}}
                                    {{--                                    </a>--}}
                                </td>

                            </div>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{--            <div class=" p-2">--}}
            {{--                {{$users->links('pagination::bootstrap-5')}}--}}
            {{--            </div>--}}
        </div>
        <div class="card mt-2">
            <div class="card-header text-uppercase">Deleted Users</div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                    @foreach($trash as $t)
                        @if($t != null)
                        <tr>
                            <td>{{$t->id}}</td>
                            <td>{{$t->name}}</td>
                            <td>{{$t->role}}</td>
                            {{--                            <td><a href="{{Route('user.recover',$t->id)}}" class="btn btn-primary btn-sm">--}}
                            {{--                                    <i class="fa fa-undo m-lg-1"></i>Recover</a></td>--}}
                            <td>
                                <input type="hidden" value="{{$t->id}}" class="btn btn-primary userTrashHidden">
                                <button type="button" class="btn btn-primary UserTrashRecoverBtn" data-recover-id="{{$t['id']}}">
                                    <i class="fa fa-undo"></i>
                                    Recover
                                </button>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.userDeleteBtn').click(function (e) {
                e.preventDefault();
                const button = e.currentTarget;
                const $delete = button.dataset.deleteId;
                 swal({
                    title: "Are you sure?",
                    text: "you can also even after deleting the user!",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: `/api/users/${$delete}/delete`,
                                method:'POST',
                                success: function (response) {
                                    swal("Poof! you have successfully deleted the user!", {
                                        icon: "success",
                                    })
                                        .then((willDelete) => {
                                            location.reload()
                                        });
                                },
                                error: function (response) {
                                    swal("opps! unable to delete the user", {
                                        icon: 'error',
                                    })
                                        .then((willDelete) => {
                                            location.reload()
                                        });
                                }
                            })

                        }
                    });
            })

            $('.UserTrashRecoverBtn').click(function (e) {
                e.preventDefault();
                const button = e.currentTarget;
                const $recoverId = button.dataset.recoverId;
                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to recover the User",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: `/api/users/${$recoverId}/recover`,
                                method:'POST',
                                success: function (response) {
                                    swal("Poof! Your imaginary file has been deleted!", {
                                        icon: "success",
                                    })
                                        .then((willDelete) => {
                                            location.reload()
                                        });
                                },
                                error: function (response) {
                                    swal('error recovering the user', {
                                        icon: "error",
                                    })
                                        .then((willDelete) => {
                                            location.reload()
                                        });
                                }
                            })
                        }
                    });
            })
        })

    </script>
@endsection
