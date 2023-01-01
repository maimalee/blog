@extends('layouts.app')
@section('content')
    <div class="container-fluid mt-4">
        <di class="card col-lg-6">
            <div class="card-header text-uppercase">Edit Blog</div>
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    {{$errors}}
                    <table>
                        <tr>
                            <td>
                                 <textarea name="blog_content" id="blog_content" cols="30" rows="10"
                                          class="form-control mt-3">{{value(old('blog_content', $blog['blog_content']))}}</textarea>
                                <div class="text-end">
                                    <input type="hidden" value="{{value(old('blog_id', $blog['id']))}}" class="btn btn-primary blogEdit">
                                    <button class="btn btn-primary mt-3 blogEditBtn" data-blog-id="{{$blog['id']}}">
                                        <i class="fa fa-refresh"></i>Update
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </di>
    </div>
@endsection
@section('script')
{{--    <script type="text/javascript">--}}
{{--        $(document).ready(function(){--}}
{{--            $('.blogEditBtn').click(function (e){--}}
{{--                e.preventDefault();--}}
{{--                const button = e.currentTarget;--}}
{{--                const $blogId = button.dataset.blogId;--}}
{{--                 alert($blogId);--}}
{{--                swal({--}}
{{--                    title: "Are you sure?",--}}
{{--                    text: "You can also edit it if you like",--}}
{{--                    icon: "success",--}}
{{--                    buttons: true,--}}
{{--                    dangerMode: true,--}}
{{--                })--}}
{{--                    .then((willDelete) => {--}}
{{--                        if (willDelete) {--}}
{{--                            $.ajax({--}}
{{--                                url: `/api/blogs/${$blogId}/edit`,--}}
{{--                                method:'POST',--}}
{{--                                success: function (response) {--}}
{{--                                    swal('You successfully edited your blog', {--}}
{{--                                        icon: "success",--}}
{{--                                    })--}}
{{--                                        .then((willDelete) => {--}}
{{--                                            location.href = '{{Route('blogs.index')}}'--}}
{{--                                        });--}}
{{--                                },--}}
{{--                                error: function (response) {--}}
{{--                                    swal("ops unable to edit the blog", {--}}
{{--                                        icon: "error",--}}
{{--                                    })--}}
{{--                                        .then((willDelete) => {--}}
{{--                                            location.reload()--}}
{{--                                        });--}}
{{--                                }--}}
{{--                            })--}}
{{--                        }--}}
{{--                    });--}}
{{--            })--}}
{{--        });--}}

    </script>
@endsection
