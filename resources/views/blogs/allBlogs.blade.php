@extends('layouts.app')
@section('content')
    {{--    @foreach($number as $n)--}}
    {{--        <br>--}}
    {{--        {{$n}}--}}
    {{--    @endforeach--}}
    <div class=" mt-5 col-md-11" style="border: 1px solid lightgray">
        @foreach($blogs as $blog)
            <div class="row mt-2">

                <div class="col-md-1">
                    @if($blog->profile == null)
                        <img class="rounded-circle" src="/images/th.webp" alt="" style="width: 60px; height: 60px;">

                    @else
                        <img class="rounded-circle" src="/images/{{$blog->profile}}" alt=""
                             style="width: 60px; height: 60px;">

                    @endif

                </div>
                <div class="col-md-10">

                    <b>@ {{$blog->name}}</b>
                    {{$blog->created_at}}
                    <span class="text-end">
                        <a href="" style="text-decoration: none" class="m-lg-2">
                            ...
                        </a>
                    </span>
                    <br>
                    <a href="{{Route('allblog.show', $blog['id'])}}"
                       style="text-decoration: none">{{$blog->blog_content}}</a>
                    <div class="mt-4" style="display: table">
                        <div class="container text-center">
                            @foreach($blog['image_chunks'] as $chunk)
                                <div class="row mb-1">
                                    @foreach($chunk as $src)
                                        <div class="col-md-4" style="margin: 0 12px">
                                            <img
                                                style="width: 150px;height: 150px; border-radius: 4px;"
                                                src="/images/{{$src}}" alt="">

                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="mt-2">

                            <span class="" id="like-count-{{$blog['id']}}">
                                {{$blog->likes}}
                            </span>
                            <button type="button" class="btn btn-link btn-like" data-blog-id="{{$blog['id']}}">
                                <i class="fa fa-heart"></i>
                            </button>
                            <span class="p-1">
                            <a href="" class=" text-decoration-none">
                                <i class="fa fa-share">
                                    share
                                </i>
                            </a>
                            <a href="" class="text-decoration-none">
                                <i class="fa fa-retweet me-2 p-3"></i>

                            </a>
                            <a href="{{Route('comment', $blog->id)}}" class="text-decoration-none">
                                <i class="fa fa-comment m-lg-2"></i>
                                  Comment
                            </a>
                            </span>

                    </div>
                    @if(Auth()->check() && Auth()->user()->id== $blog['user_id'])
                        <a href="" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit m-lg-1"></i>Edit</a>
                        <a href="" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash m-lg-1"></i>Delete</a>
                    @endif

                </div>
            </div>
        @endforeach
    </div>
    <style>
    </style>
@endsection
@section('script')
    <script type="text/javascript">

        $('button.btn-like').on('click', e => {
            e.preventDefault();
            const button = e.currentTarget;
            const blogId = button.dataset.blogId
            const $spanLikeCount = $(`span#like-count-${blogId}`);
            $.ajax({
                url: `{{url('api/blogs/' . $blog['id'] . '/like')}}?userId={{\auth()->id()}}`,
                method: 'POST',
                success(data) {
                    if (data.hasOwnProperty('increment')) {
                        const incremented = parseInt($spanLikeCount.html()) +1
                        $spanLikeCount.html(incremented)
                    }

                    if (data.hasOwnProperty('decrement')) {
                        const incremented = parseInt($spanLikeCount.html()) -1
                        $spanLikeCount.html(incremented)
                    }
                }
            });
        })
    </script>
@endsection
