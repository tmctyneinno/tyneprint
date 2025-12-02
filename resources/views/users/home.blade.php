@extends('layouts.app')
@section('content')
<main class="main index">
		<!--Home slider : Begin-->
		<!-- Hero Slider Section -->
<section class="hero-slider">
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-12">
                <div class="hero-slide position-relative overflow-hidden">
                    <!-- Background Image -->
                    <div class="hero-background">
                        <img src="{{ asset('/images/sliderss.jpg') }}" 
                             alt="Quality Printing Services"
                             class="img-fluid w-100"
                             style="object-fit: cover; min-height: 600px;">
                        <div class="hero-overlay"></div>
                    </div>
                    
                    <!-- Hero Content -->
                    <div class="hero-content position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                                    <!-- Main Heading -->
                                    <h1 class="hero-title display-3 fw-bold text-white mb-4 animate__animated animate__fadeInUp" 
                                        style="font-family: 'DM Serif Display', serif; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                                        Get Quality Prints
                                    </h1>
                                    
                                    <!-- Subtitle -->
                                    <h2 class="hero-subtitle text-white mb-5 animate__animated animate__fadeInUp animate__delay-1s">
                                        <span class="h2 fw-light">Shipped to Your</span>
                                        <span class="h2 fw-bold ms-2">Doorstep</span>
                                    </h2>
                                    
                                    <!-- Search Form -->
                                    <div class="hero-search animate__animated animate__fadeInUp animate__delay-2s">
                                        <h3 class="h4 text-white mb-4">
                                            <i class="fas fa-search me-2"></i>What do you want to print today?
                                        </h3>
                                        
                                        <form method="get" action="{{ route('search') }}" class="search-form">
                                            <div class="input-group shadow-lg rounded-pill overflow-hidden">
                                                <span class="input-group-text bg-white border-0 ps-4">
                                                    <i class="fas fa-search text-muted"></i>
                                                </span>
                                                <input type="text" 
                                                       name="search" 
                                                       class="form-control form-control-lg border-0"
                                                       placeholder="Search for papers, mugs, designs, banners..."
                                                       required
                                                       aria-label="Search for printing products">
                                                <button type="submit" 
                                                        class="btn btn-primary btn-lg px-4 px-md-5 fw-bold">
                                                    Search
                                                    <i class="fas fa-arrow-right ms-2"></i>
                                                </button>
                                            </div>
                                            <div class="form-text mt-3 text-white-50">
                                                <small>
                                                    <i class="fas fa-lightbulb me-1"></i>
                                                    Popular: Business Cards, Flyers, T-shirts, Mugs, Banners
                                                </small>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <!-- Trust Badges -->
                                    <div class="trust-badges mt-5 animate__animated animate__fadeIn animate__delay-3s">
                                        <div class="row g-3">
                                            <div class="col-auto">
                                                <span class="badge bg-white text-dark px-3 py-2 rounded-pill">
                                                    <i class="fas fa-shipping-fast text-primary me-2"></i>
                                                    Free Shipping
                                                </span>
                                            </div>
                                            <div class="col-auto">
                                                <span class="badge bg-white text-dark px-3 py-2 rounded-pill">
                                                    <i class="fas fa-award text-warning me-2"></i>
                                                    Premium Quality
                                                </span>
                                            </div>
                                            <div class="col-auto">
                                                <span class="badge bg-white text-dark px-3 py-2 rounded-pill">
                                                    <i class="fas fa-clock text-success me-2"></i>
                                                    24/7 Support
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Scroll Indicator -->
                    <div class="scroll-indicator position-absolute bottom-0 start-50 translate-middle-x mb-4">
                        <a href="#features" class="text-white text-decoration-none d-flex flex-column align-items-center">
                            <span class="mb-2">Explore More</span>
                            <i class="fas fa-chevron-down animate__animated animate__bounce animate__infinite"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add this CSS to your stylesheet -->
<style>
.hero-slider {
    position: relative;
}

.hero-background {
    position: relative;
    min-height: 600px;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.1) 100%);
}

.hero-content {
    z-index: 2;
}

.hero-title {
    line-height: 1.1;
    margin-bottom: 1.5rem !important;
}

.hero-subtitle {
    font-size: 2.2rem;
    line-height: 1.2;
}

.search-form .input-group {
    max-width: 800px;
    transition: all 0.3s ease;
}

.search-form .input-group:focus-within {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2) !important;
}

.search-form input {
    padding-left: 0.5rem;
    font-size: 1.1rem;
}

.search-form input:focus {
    box-shadow: none;
    outline: none;
}

.search-form button {
    padding-left: 2rem;
    padding-right: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    white-space: nowrap;
}

.search-form button:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.trust-badges .badge {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    transition: all 0.3s ease;
}

.trust-badges .badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.scroll-indicator {
    z-index: 3;
}

.scroll-indicator a {
    opacity: 0.8;
    transition: all 0.3s ease;
}

.scroll-indicator a:hover {
    opacity: 1;
    transform: translateY(-3px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.8rem;
    }
    
    .hero-background {
        min-height: 500px;
    }
    
    .search-form .input-group {
        flex-direction: column;
        border-radius: 1rem !important;
    }
    
    .search-form .input-group-text {
        display: none;
    }
    
    .search-form input {
        border-radius: 1rem 1rem 0 0 !important;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        text-align: center;
    }
    
    .search-form button {
        width: 100%;
        border-radius: 0 0 1rem 1rem !important;
        padding: 1rem;
    }
    
    .trust-badges .row {
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1.5rem;
    }
    
    .hero-content {
        padding-top: 3rem;
    }
}
</style>

<!-- Add Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		
		
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

