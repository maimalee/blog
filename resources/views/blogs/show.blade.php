@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="card col-md-7">
            <div class="card-header">
                <div class="text-uppercase">
                    User Details
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID#</th>
                        <th>Content</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$blog->id}}</td>
                        <td>{{$blog->blog_content}}</td>

                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div class="text-end">
                                <a href="{{Route('blog.edit', $blog['id'])}}" class="btn btn-primary">
                                    <i class="fa fa-edit"></i>Edit</a>
                                <input type="hidden" value="{{$blog['id']}}" class="btn btn-danger blog-delete">
                                <button class="btn btn-danger blogdeletebtn">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                {{--                <a type="button" href="{{Route('blog.delete', $blog['id'])}}" class="btn btn-danger">--}}
                {{--                    <i class="fa fa-trash"></i>Delete</a>--}}


                <br>

                <sm><b><i class="fa fa-comment me-2"></i>Comments</b></sm>
                <br>
                @if($comm === 0)
                    <div class="">
                        <i>
                            No Comment For this blog
                        </i>
                    </div>
                @else
                    @foreach($comment as $c)

                        <div class="mt-2">
                            {{--                            <br>--}}
                            {{--                            {{$c->comment_content}}--}}
                            {{--                            <br>By <b><i>{{$c->name}}</i></b>--}}
                            <div class="card mt-3">
                                <div class="card-body">
                                    @if($c->profile)
                                        <img class="rounded-circle" src="/images/{{$c['profile']}}" alt=""
                                             style="width: 40px; height: 40px;">
                                    @else
                                        <img class="rounded-circle" src="/images/th.webp" alt=""
                                             style="width: 40px; height: 40px;">
                                    @endif
                                    By <b><i>{{$c->name}}</i></b>
                                    Commented On <b><i>{{$c->created_at}} </i></b><br>
                                    {{$c->comment_content}}
                                </div>
                                <div class="text-end mt-2 p-2">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#replymodal">
                                        <i class="fa fa-reply me-2"></i>
                                        Reply
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="modal fade" id="replymodal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post" id="reply_form">

                                        <div class="modal-body">
                                            @csrf
                                            {{$errors}}

                                            <div class="form-group">
                                                <input type="hidden" value="{{$blog->id}}" name="blog_id"
                                                       class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <input type="hidden" value="{{$blog->user_id}}" name="user_id" class="">
                                            </div>

                                            <div class="form-group">
                                                <input type="hidden" value="{{$c->id}}" name="comment_id">
                                            </div>

                                            <div class="form-group">
                                                <textarea name="reply_content" id="reply_content" cols="30" rows="10"
                                                          class="form-control mt-2"
                                                          placeholder="Write a reply"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="button" onclick="form_submit()" class="btn btn-primary">
                                                    Send
                                                </button>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <br>


                @if(Auth()->user()->role =='admin')
                    <a type="button" href="{{Route('admin.blog')}}" class="btn btn-primary mt-2">
                        <i class="fa fa-arrow-left"></i>
                        Go BAck admin
                    </a>
                @elseif(Auth()->user()->role =='user')
                    <a type="button" href="{{Route('blogs.index')}}" class="btn btn-primary mt-2">
                        <i class="fa fa-arrow-left"></i>
                        Go Back user
                    </a>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function form_submit() {
            document.getElementById("reply_form").submit();
        }

        $(document).ready(function () {
            $('.blogdeletebtn').click(function (e) {
                e.preventDefault();
                const $blogId = $(this).closest("tr").find('.blog-delete').val();
                // alert($blogId);
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover your blog!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            const $data ={
                                "_token": $('input[name=_token]').val(),
                                "id": $blogId,
                            }
                            $.ajax({
                                url: '{{Route('blog.delete', $blog['id'])}}',
                                data: $data,
                                success: function (response) {
                                    swal("Your blog has been deleted", {
                                        icon: "success",
                                    })
                                        .then((willDelete) => {
                                            location.href = '{{Route('blogs.index')}}'
                                        });
                                },
                                error: function (response) {
                                    swal("Error deleting the blog", {
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
        });
    </script>
@endsection
