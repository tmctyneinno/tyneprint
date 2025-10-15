@extends('layouts.app')
@section('content')

<main class="main" id="product-detail">
		<!--Breadcrumb : Begin-->
		<section class="header-page">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 hidden-xs">
						<h1 class="mh-title">{{$product->category->name}}</h1>
					</div>
					<div class="breadcrumb-w col-sm-8">
						<ul class="breadcrumb">
							<li>
								<a href="{{route('index')}}">Home</a>
							</li>
							<li>
								<a href="#">{{$product->name}}</a>
							</li>
							<li>
								<span>Details</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</section><!--Breadcrumb : End-->
		<!--Product info : Begin-->
		<section class="product-info-w">
			<div class="container">
				<div class="row">
					<div class="tab-content clearfix">
					    <div role="tabpanel" class="tab-pane active" id="features">
					    	<div class="product-image v-middle">
						    		<div class="slide-show">
				<div class="vt-slideshow" style="height:56px">
					<ul>
					@php
						$gallery = json_decode($product->gallery, true); 
					@endphp
					@foreach ($gallery as $pp )
						<li class="slide1" data-transition="random" ><img src="{{asset('/images/products/'.$pp)}}"  alt="" />
					</li>
					@endforeach
				</ul>
				</div>
							</div>
						    </div>
						    <div class="product-shortdescript v-middle">
								<div class="col-sm-12 col-xs-12">
									<div class="v-middle ">
										<h3>{{$product->name}}</h3>
							    		<ul >
										<li class="text-wrap"> {!! $product->description !!} </li>
							    		
							    		</ul>
							    	</div>
								</div>
							</div>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="ideals">
					    	<div class="col-md-8 col-md-offset-2 col-xs-12 ideals-w">
					    		<div class="ideal">
					    			<img src="images/img-paper.png" alt="ideal 1">
					    		</div>
					    	</div>
					    </div>
					
					</div>
				</div>
			</div>
		</section><!--Product info : Begin-->
		<!--Step order : Begin-->
		<section class="product-step-order hidden-xs">
			<div class="container">
			
				<div class="pso-content  d-md-none d-sm-none" >
					<div class="pso-content-top row">
						<div class="col-md-3 col-md-offset-1 col-sm-4">
							<span class="line-number"></span>
							<span class="pso-number border-radius-50 d-block">1</span>
							<span class="line-number2 d-block"></span>
						</div>
						<div class="col-sm-4">
							<span class="line-number"></span>
							<span class="pso-number border-radius-50 d-block">2</span>
							<span class="line-number2"></span>
						</div>
						<div class="col-md-3 col-sm-4 d-block">
							<span class="line-number"></span>
							<span class="pso-number border-radius-50 d-block">3</span>
							<span class="line-number2 d-block"></span>
						</div>
					</div>
					<div class="pso-content-bottom row">
						<div class="col-md-3 col-md-offset-1 col-sm-4 step-select-option">
							<span class="pso-icon border-radius-50 d-block"></span>
							<h3>Select Option</h3>
							<p class="pso-text">
								Choose options that you want for your prints..
							</p>
						</div>
						<div class="col-sm-4 step-upload-design">
							<span class="pso-icon border-radius-50 d-block">
								<i class="fa fa-file-text-o"></i>
								<i class="fa fa-arrow-circle-o-up"></i>
							</span>
							<h3>Upload your design</h3>
							<p class="pso-text">
								Upload your finished design  or a sample design.
							</p>
						</div>
						<div class="col-md-3 col-sm-4 step-checkout">
							<span class="pso-icon border-radius-50 d-block">
								<i class="fa fa-shopping-cart"></i>
							</span>
							<h3>Proceed to cart</h3>
							<p class="pso-text">
								Add Item to your Cart
							</p>
						</div>
					</div>
				</div>
			
			</div>
		</section>
		<form action="{{ action('App\\Http\\Controllers\\CartController@add', encrypt($product->id)) }}" method="POST" enctype="multipart/form-data">
    	@csrf
		<section class="add-to-cart-w">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 product-options">
						<div class="atc-header">
							<span class="number">1</span>
							<h3>Price Calculator</h3>
						</div>
						<div class="options-list-w">
							<div class="row">
								<div class="block-options col-md-4 col-sm-5">
									<div class="options-col"> Select Quantity
										<select class="form-control" name="pricelist" id="pricelist">
										@foreach ($product->PriceList as  $qq)
											<option value="{{$qq->qty}}"> {{$qq->qty}} </option>
											 @endforeach
										</select>
									</div>
								</div>
								<div class="block-options col-md-4 col-sm-5">
									<div class="options-col">Choose Design Type
										<select class="form-control"  id="designPrice" name="design_fee">
											<option class="design" value="0"> I have own Design </option>
											<option id="design" value="{{$product->design_fee}}"> Let our experts design for you?</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="block-options col-md-4 col-sm-5" style="padding-top:10px">
									<div class="options-col">Price

										<select class="form-control" name="price" readOnly>
											<option class="totals" value="{{$product->priceList[0]->price}}"> ₦{{number_format($product->priceList[0]->price,2)}} </option>
										</select>
									
									</div>
								</div>
								<div class="block-options col-md-4 col-sm-5 " style="padding-top:10px">
									<div class="options-col"> Design Fee
										<select class="form-control" readOnly>
											<option class="designFee" value=""> 0 </option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								@forelse($product->metas as $meta )	
								<div class="block-options col-md-4 col-sm-5" style="padding-top:10px">
									<div class="options-col"> {{$meta->name}}
										<select class="form-control metas" name="metas"  id="select-meta{{$meta->id}}" >
											@php $attr = json_decode($meta->finishings) @endphp
											@foreach ($attr as $attrs )
											@php $name = explode(":", $attrs) @endphp
											<option  value="{{$name[1]}}" selected ="selected"  class="printTypes">{{$name[0]}} </option>
											@endforeach
										</select>
									</div>
								</div>
								@empty
								@endforelse
							</div>
						</div>
					</div>
					<div class="row">
					<div class="col-md-6 col-sm-6 upload-add-cart">
						<div class="row">
							<div class="upload-file col-md-12 col-sm-12 hidden-xs">
								<div class="atc-header">
									<span class="number">2</span>
									<h3>Upload design Sample</h3>
								</div>
								<p class="upload-allow">
									You can only upload jpg, jpeg, PDF, png, txt, doc, docx, files.
								</p>
								<div class="box-upload">
									<span class="icon">
										<i class="fa fa-file-text-o"></i>
										<i class="fa fa-arrow-up border-radius-50"></i>
									</span>
									<p>Upload a complete design or Sample Design</p>
									
								<span class="btn fileinput-button">
				                    <i class="glyphicon "></i>
				                    <input style="border:2px solid green" type="file" name="images[]" multiple="">
				                </span>
								
									</div>
								<div class="box-upload">
									<p style="color:#000; font-weight:200; text-align:left; padding-left:10px" >Please include all information you want in your design here, preferred colours, instructions etc</p>					
								<textarea class="form-control" name="description" rows="7" placeholder="Type text here">  </textarea>
									</div>
							</div>
							<div class="add-to-cart col-md-12 col-sm-12 col-xs-12">
								<div class="atc-header">
									<span class="number visible-480 visible-xs">2</span>
									<span class="number hidden-xs">3</span>
									<h3>Add to cart</h3>
								</div>
								<div class="quantity-price-w row">
									<div class="price-total col-xs-6">
										<label>Total:</label>
										<span class="price total"></span>
									</div>
									<div class="add-cart-btn-w col-xs-12">
										<button type="submit" class="add-cart-btn btn w-100">
											<i class="fa fa-shopping-cart"></i>
											Add To Cart
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div class="col-md-6 col-sm-6 upload-add-cart">
						<div class="row">
							<div class="upload-file col-md-12 col-sm-12 hidden-xs">
								<div class="atc-header">
									<span class="number">₦</span>
									<h3>Total Price</h3>
								</div>
								<div class="box-upload" style="padding:50px">
									<span class="icon" >
										<input type="hidden" id="payable" value="{{$product->priceList[0]->price}}" name="price">
										<input type="hidden" id="totalQty" value="{{$product->priceList[0]->qty}}" name="qty">
									</span>
									
									<h3 style="color:darkred; font-weight:bolder; font-size:30px" class="total" > ₦{{number_format($product->priceList[0]->price)}}</h3>
						
								
									</div>
								
							</div>
							
						</div>
							<div class="quantity-price-w row add-to-cart col-md-12 ">
								
									<div class="add-cart-btn-w col-xs-12">
										<button type="submit" class="add-cart-btn btn w-100">
											<i class="fa fa-shopping-cart"></i>
											Add To Cart
										</button>
									</div>
								</div>
					</div>

						<div class="col-md-6 col-sm-6 upload-add-cart p-20" >
						<div class="row">
							<div class="slide-show">
				{{-- <div class="vt-slideshow" style="height:56px">
					<ul>
					@php
						$gallery = json_decode($product->gallery, true); 
					@endphp
					@foreach ($gallery as $pp )
						<li class="slide1" data-transition="random" ><img src="{{asset('/images/products/'.$pp)}}"  alt="" />
					</li>
					@endforeach
				</ul>
				</div> --}}
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</section><!--Add to cart : End-->

		</form>

		<!-- Product upload file: Begin-->
	</main>
@endsection

@section('script')


<script>
 desn = {!! json_encode($product->design_fee) !!}
 sale_price = {!! json_encode($product->priceList[0]->price) !!}
prices = {!! json_encode($product->PriceList) !!}

$('#pricelist').on('change', function(){	
qtys = document.getElementById('pricelist').value;
$.each(prices, function(key, value){
if(value.qty == qtys){
	 sale_price = value.price;
      $('#totalQty').attr('value', value.qty);
	  $('#payable').attr('value', value.price);
	$('.totals').html('<span class="font-weight-bold" style="color:darkblue; font-size:20px">'+'₦'+thousands_separators(value.price)+'</span>');
    $('.total').html('<span class="font-weight-bold" style="color:darkred; font-weight:bolder; font-size:30px">'+'₦'+thousands_separators(value.price)+'</span>');
}
});
});

	$('#designPrice').on('change', function(){
if(document.getElementById('design').selected == true){ 
     price = parseInt(sale_price) + parseInt(desn);
	$('#payable').attr('value', price);
     $('.designFee').html('<span class="font-weight-bold"  style="color:darkblue; font-size:18px">'+'₦'+desn+'</span>');
	 $('#designPrice').attr('value', desn);
	  $('.total').html('<span class="font-weight-bold" style="color:darkred; font-weight:bolder; font-size:30px">'+'₦'+thousands_separators(price)+'</span>');
}else{
	$('#payable').attr('value', value.price);
	$('#designPrice').attr('value', 0);
      $('.designFee').html('<span class="font-weight-bold"  style="color:darkblue; font-weight:bolder; font-size:18px">'+'₦'+0+'</span>');
	  $('.total').html('<span class="font-weight-bold" style="color:darkred; font-weight:bolder; font-size:30px">'+'₦'+thousands_separators(value.price)+'</span>');
	}
});
  
//   $('.metas').on('change', function(){
// 	var value = event.target.value;
// 	recd = record.push(value);
// //	$('#payable').attr('value', thousands_separators(price + parseInt(value)));
// //  $('.total').html('<span class="font-weight-bold" style="color:darkred; font-weight:bolder; font-size:30px">'+'₦'+thousands_separators(price + parseInt(value) )+'</span>');
//   });


   let metaPrices = [];
   jQuery(document).on('change', '.metas', function(e){
      e.preventDefault();
    //  var totalprice = parseFloat(jQuery('.printTypes').val());
     // alert(totalprice);
      var thisprice = event.target.value;
	  let selectedTypeId = $(this).attr('id');
	  let selectedTypeValue = $(`#${selectedTypeId} option:selected`).val();
	  let metaData = {id: selectedTypeId, price: selectedTypeValue}
	  if(metaPrices.length) {
		array.forEach(meta => {
			if(meta.id === selectedTypeId) {
				meta.price = selectedTypeValue;
			} else {
				metaPrices.push(metaData)
			}
		});
	}
	  let totalMetaPrice = metaPrices.reduce(function (initial, metaInfo) { return initial + metaInfo.price; }, 0);

         totalprice =  parseInt(sale_price) + parseInt(thisprice);
		 metaData = 0;
		 totals = 0;
		 $('.metas').each(function() {
			metaData += parseInt(totalprice)
			localStorage.setItem("metaprice", metaData);
		 });

		// alert(totalprice)
		// alert(localStorage.getItem('metaprice'));
		//  metaPrices = JSON.parse('lastname')
		//  alert(metaPrices)
		//  metaPrices.push(thisprice);
 		// Items = localStorage.setItem("metaprice", JSON.stringify( metaPrices));
		// console.log(Items);
        // jQuery('.totalprice strong').text(totalprice);
        // jQuery('input[name="totalprice"]').val(totalprice);
    });


</script>
@endsection

