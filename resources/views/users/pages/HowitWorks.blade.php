@extends('layouts.app')
@section('content')


	<main class="main">
		<section class="header-page">
			<div class="container">
				<div class="row">
					<div class="col-sm-3 hidden-xs">
						<h1 class="mh-title">How it works</h1>
					</div>
					<div class="breadcrumb-w col-sm-9">
						<ul class="breadcrumb">
							<li>
								<a href="{{route('index')}}">Home</a>
							</li>
							<li>
								<span>How it works</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<section id="aboutus" class="pr-main">
			<div class="container">			
				<div class="col-md-6 col-sm-6 col-xs-12">
					<img src="{{asset('/images/tt4.png')}}" >
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="top"><h2><span>visit tyneprints.com</span></h2>
					
                                Log on to tyneprints.com, select a product of your choice, e.g business cards, letterheads, wedding cards, mugs, gift items and other awesome print products
                                </div>
				</div>
				
			</div>
            <div style="padding-top:100px">
        </div>
            <div class="container">			
				<div class="col-md-6 col-sm-6 col-xs-12">
					<img src="{{asset('/images/tt1.jpg')}}" >
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="top"><h2><span>                   Make it Unique.
                        Make it yours.</span></h2>
                                            
                                
                        Select a template under your product category and customise it to your taste. Add images, edit texts, change font sizes and colour using our online editor. Checkout and make payment with your credit cards or via bank transfer.

                        Not happy with our templates? You can easily upload your own designs in PDF, PSD, AI, and CDR formats.  </div>
                                        </div>
                                        
			</div>
		<div style="padding-top:100px">
        </div>
              <div class="container">			
				<div class="col-md-6 col-sm-6 col-xs-12">
					<img src="{{asset('/images/tt3.jpg')}}">
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="top"><h2><span> Your Print order will be shipped to you.</span></h2>
                                            
                                
                      
Wherever you are in Nigeria, your order will be shipped to you without delay and we are 100% sure you will love it and If you don't, we will take it from you and give you a reprint.

100% customer satisfaction            </div>
                                        
			</div>
		</section>
		
	</main>
@endsection