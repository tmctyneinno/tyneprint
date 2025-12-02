@extends('layouts.app')
@section('content')
<main class="main index">
		<!--Home slider : Begin-->
		<section class="home-slidershow">
			<div class="slide-show">
				<div class="vt-slideshow">
    <ul>
        <li class="slide1" data-transition="random">
            <img src="{{asset('images/sliderss.jpg')}}" alt="" />
            
            <!-- Container for alignment -->
            <div class="container-fluid h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <!-- Text Content Section -->
                        <div class="tp-caption lfr" data-x="left" data-hoffset="-56" data-y="100" data-start="800" data-speed="2000" data-endspeed="300">
                            <span class="style1">
                                <span class="textcolor">
                                    <p style="font-family: 'DM Serif Display',serif; text-transform: capitalize; font-weight:bold; margin: 0;">
                                        Get Quality Prints
                                    </p>
                                </span>
                            </span>
                        </div>
                        
                        <!-- Subtitle Section -->
                        <div class="tp-caption lfb" data-x="left" data-hoffset="-56" data-y="155" data-start="800" data-speed="2000" data-endspeed="300">
                            <span class="style3">
                                <p style="font-size: 30px; margin: 0;">
                                    Shipped to Your Doorstep
                                </p>
                            </span>
                        </div>
                        
                        <!-- Search Section -->
                        <div class="tp-caption lfr" data-x="left" data-hoffset="-56" data-y="275" data-start="1300" data-speed="2000" data-easing="easeInOutQuint" data-endspeed="300">
                            <div class="row align-items-center">
                                <!-- Desktop Version -->
                                <div class="col-12 col-lg-6 d-none d-md-block">
                                    <p style="font-size: 18px; font-weight:bold; margin-bottom: 15px;">
                                        What do you want to print today?
                                    </p>
                                    <form method="get" action="{{route('search')}}" style="background:#fff; border-radius: 5px; overflow: hidden; display: flex;">
                                        <input name="search" type="text" placeholder="Search for papers, mugs, designs" style="flex: 1; font-size:15px; padding-left:20px; height:60px; border:none; color:#000" required>
                                        <button type="submit" class="btn" style="width:60px; background:#fff; border-left: 1px solid #eee;">
                                            <i style="font-size: 20px" class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Mobile Version -->
                                <div class="col-12 d-md-none">
                                    <p style="font-size: 20px; font-weight:bolder; margin-bottom: 15px;">
                                        What do you want to print?
                                    </p>
                                    <form method="get" action="{{route('search')}}" style="background:#fff; border-radius: 5px; overflow: hidden; display: flex;">
                                        <input name="search" type="text" placeholder="Search for papers, mugs, designs" style="flex: 1; font-size:15px; padding-left:20px; height:50px; border:none; color:#000" required>
                                        <button type="submit" class="btn" style="width:50px; background:#fff; border-left: 1px solid #eee;">
                                            <i style="font-size: 20px" class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Right side content (you can add more here) -->
                                <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-end">
                                    <!-- Optional right side content -->
                                    <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; backdrop-filter: blur(5px);">
                                        <p style="color: white; margin: 0; font-size: 16px;">
                                            <i class="fa fa-truck me-2"></i>Free shipping on orders over $50
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
			</div>
		</section>  
		
		
        <section class="or-service">
			<div class="container">
				<div class="row">
					<div class="block-title-w">
						<h2 class="block-title">FEATURED PRODUCTS</h2>
						<span class="icon-title">
							<span></span>
							<i class="fa fa-star"></i>
						</span>
						
					</div>
					<div class="or-service-w">

                    @foreach ($products as $prod )
                       @php
                        $name = preg_replace("[\(|\)|/|\"|\"]", '-', $prod->name);  
                         @endphp
						<div class="col-md-3 col-sm-6 col-xs-12 or-block" style="padding-bottom:20px">
							<div class="or-image">
								<a href="{{url('/products/details',$name.'_'.encrypt($prod->id))}}">
									<img src="{{asset('/images/products/'.$prod->image)}}" alt="service-01"/>
								</a>
							</div>
							<div class="or-title">
								<a href="{{url('/products/details',$name.'_'.encrypt($prod->id))}}">{{$prod->name}}</a>
							</div>
							<div class="or-text">
								<p>
									From 	<span class="normal-price">₦{{number_format($prod->priceList[0]->price,2)}} per {{$prod->priceList[0]->qty}}   </span>
								</p>
							</div>
							<a href="{{url('/products/details',$name.'_'.encrypt($prod->id))}}" class="btn-readmore order-now">Order {{substr($prod->name,0,15) . '...'}}</a>
						</div>

                       @endforeach
					</div>
				</div>
			</div>

		</section>
	
		<section class="home-testimonial" style="background-position: 50% -79px; background:#f1fff6">
			<div class="container">
				<div class="row" style="padding-left:10px" >
				
					<h1 style="font-size:30px; font-weight:bold; font-family:'dm serif display',serif"> You have come to the right place</h1>
					<p style=""> We work with over 100 top brands in Nigeria and Internationally</p>	
				</div>
			</div>
			<div class="container" >
				<div class="row">
					<div class="bran-block">
						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="{{asset('/images/brands/1.jpg')}}" >
							</a>
						</div>
						
						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="{{asset('/images/brands/3.png')}}" >
							</a>
						</div>
						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="{{asset('/images/brands/7.jpg')}}" >
							</a>
						</div>
						
						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="{{asset('/images/brands/8.jpg')}}" >
							</a>
						</div>

						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="{{asset('/images/brands/6.jpg')}}" >
							</a>
						</div>
						
						
						
						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="{{asset('/images/brands/2.png')}}" >
							</a>
						</div>
					


						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="{{asset('/images/brands/5.png')}}" >
							</a>
						</div>
						<div class="item col-md-2 col-sm-4 col-xs-6">
							<a href="#" class="image">
								<img src="{{asset('/images/brands/6.png')}}" >
							</a>
						</div>
						
					</div>
				</div>
			</div>
		</section>
	
	</main> 

@endsection

