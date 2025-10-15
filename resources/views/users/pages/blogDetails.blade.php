@extends('layouts.app')
@section('content')
<section class="header-page">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 hidden-xs">
                <h1 class="mh-title">Blog Details</h1>
            </div>
            <div class="breadcrumb-w col-sm-8">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{route('index')}}">Home</a>
                    </li>
                    <li>
                        <a href="#">Blog Details</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="product-info-w">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
            </div>
        </div>

        <div class="row">
            <div class="tab-content clearfix">
                <div role="tabpanel" class="tab-pane active" id="features">
                    <div class="product-image v-middle">
                        <div class="col-sm-12 col-xs-12">
                            <img src="{{asset('/images/'.$blogs->image)}}" alt="ideal 1">
                        </div>
                    </div>
                    <div class="product-shortdescript v-middle">
                        <div class="col-sm-12 col-xs-12">
                            <div class="v-middle">
                                <h3>{{$blogs->title}}</h3>
                                <ul>
                                    <li style="text-align:justify">
                                    {!!$blogs->content!!}</li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row product-share hidden-xs">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-sm-12 social">
                        <ul>
                            <li class="label">Share this post:</li>
                            <li class="twiter">
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li class="facebook">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li class="google-plus">
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                            </li>
                            <li class="pinterest">
                                <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            </li>
                            <li class="twiter">
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</section>

<section class="add-to-cart-w">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="atc-header">
                    <h3>Post Comments</h3>
                </div>
                @forelse($post as $comments)
                <div class="options-list-w">
                    <div class="row">
                        <div class="block-options col-md-10 col-sm-10">
                           <p>{{$comments->name}}</p>
                           <p> {{$comments->email}}</p> 
                          <p> {{$comments->message}}</p>
                          <p> {{$comments->created_at->format('d/m/y h:i')}}</p>
                        </div>
                    </div>
                </div>
                <hr>
                @empty 
                @endforelse
            </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h2 style="font-size:18px">Write comment here</h2>
                    <hr>
                    <form id="login-form" class="form-validate form-horizontal" method="post" action="{{route('post.comments',encrypt($blogs->id))}}">
                        @csrf
                        <p>Full Name <span class="star">*</span></p>
                        <input class="form-control text"  type="text" name="name" placeholder="Full name">
                        <p>Email Address <span class="star">*</span></p>
                        <input class=" form-control email" type="text" name="email" value="" placeholder="Enter email">
                        <p>Comments <span class="star">*</span></p>
                        <textarea  rows="10" class="form-control" name="message" placeholder="write comments here">  </textarea> <br>
                        <p class="p-3">   <button type="submit" class="btn btn-primary">Post Comment</button></p>
                    </form>
                </div>
        </div>
    </div>
</section>
@endsection