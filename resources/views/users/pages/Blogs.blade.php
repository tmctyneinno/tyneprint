@extends('layouts.app')

@section('content')

<section class="header-page">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 hidden-xs">
                <h1 class="mh-title">Blog Post</h1>
            </div>
            <div class="breadcrumb-w col-sm-8">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{route('index')}}">Home</a>
                    </li>
                    <li>
                        <a href="#">Blog Post</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section><!--Breadcrumb : End-->
<section class="home-blog" style="background-position: 50% 156px;">
    <div class="container">
        <div class="row">
            <div class="block-title-w">
                <h2 class="block-title"></h2> 
                <span class="icon-title">
                    <span></span>
                    <i class="fa fa-star"></i>
                </span> 
            </div>
            <div class="blog-content-w" id="blog-content-w">
                <div class="slider">
                    <div class="" style="opacity: 1; display: block;">
                        <div class="owl-wrapper-outer"><div class="owl-wrapper" style="width: 7020px; left: 0px; display: block;"><div class="owl-item active" style="width: 1170px;"><div class="wrap-item"> 
                           
                           @forelse($blogs as $blog)
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 item" style="padding-bottom:20px">
                                <div class="inner"> 
                                    <a class="image" href="#">
                                        <img src="{{asset('/images/'.$blog->image)}}" alt="{{asset('/images/'.$blog->image)}}">
                                    </a>
                                    <div class="info">
                                        <div class="title">
                                            <a href="#">{{substr($blog->title,0,20)}}</a>
                                        </div>
                                        <div class="sub-title">
                                            <p>
                                                {{substr($blog->content,0,200)}}
                                            </p>
                                        </div>
                                        <a href="{{route('blog.readMore', encrypt($blog->id))}}" class="read-more">Read more</a>
                                    </div>
                                </div>
                            </div>

                            @empty 
                            @endforelse

                         
                        </div>
                     </div>
                   
                    </div></div>
                        
                         
                </div>

                
            </div>
        </div>
    </div>
</section>
@endsection