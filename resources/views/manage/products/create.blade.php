@extends('layouts.admin')
@section('content')
 <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                {{Form::open(['action' => 'App\Http\Controllers\ProductController@store', 'method'=>'post', 'enctype' => 'multipart/form-data'])}}
              @csrf
              <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Create Product</h6>
                            <div class="row">
                                <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="name"  value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1"
                                                   aria-describedby="emailHelp" placeholder="Product name">
                                            <small id="emailHelp" class="form-text text-muted">Product Name e.g Calender, Envelope
                                            </small>
                                            @error('name')
                                            <span class="invalid-feedback"> <small> * </small> </span>
                                            @enderror
                                        </div>
                                    </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                           <input type="text" name="price"  value="{{old('price')}}"class="form-control @error('price') is-invalid @enderror" id="exampleInput"
                                                   aria-describedby="EventLocation" placeholder="Product Price">
                                            <small id="emailHelp" class="form-text text-muted">Product price per unit production 
                                            </small>
                                            @error('price')
                                            <span class="invalid-feedback"> <small> {{$message}} </small> </span>
                                            @enderror
                                        </div>
                                         </div>

                                            <div class="col-md-6">
                                         <div class="form-group">
                                            <input type="text" name="sale_price"  value="{{old('sale_price')}}" class="form-control @error('sale_price') is-invalid @enderror" id="exampleInputEmail1"
                                                   aria-describedby="emailHelp" placeholder="Sale Price">
                                            <small id="emailHelp" class="form-text text-muted">Price after discount
                                            </small>
                                            @error('sale_price')
                                            <span class="invalid-feedback"> <small> {{$message}}</small> </span>
                                            @enderror
                                        </div>           
                              </div>

                                      <div class="col-md-12">
                                         <div class="form-group">
                                           
                                           <select value="{{old('category_id')}}" class="form-control @error('category_id') is-invalid @enderror" name="category_id"> 
                                          <option> SELECT CATEGORY </option>
                                           @foreach ($category as $cat )
                                                <option value="{{$cat->id}}"> {{$cat->name}} </option>
                                           @endforeach
                                           </select>
                                           <small id="emailHelp" class="form-text text-muted">Select Product Category
                                            </small>
                                            @error('category_id"')
                                            <span class="invalid-feedback"> <small> *</small> </span>
                                            @enderror
                                        </div>           
                              </div>

                                         <div class="col-md-12">
                                  <div class="form-group">
                                    
                                    <textarea id="summernote" class="@error('description') is-invalid @enderror" name="description">{{old('description')}}</textarea>
                                     <small id="emailHelp" class="form-text text-muted">Product Description
                                            </small>
                                            @error('description')
                                            <span class="invalid-feedback"> <small> *</small> </span>
                                            @enderror
                                    </div>


                                         </div>


                                               <div class="col-md-6">
                                  <div class="custom-file">
                                            <input type="file"name="image" class="custom-file-input  @error('image') is-invalid @enderror" id="customFile">
                                                <label class="custom-file-label" for="customFile">Choose Cover Image</label>
                                            </div>
                                            <small id="emailHelp" class="form-text text-muted"> Choose a cover image for design sample
                                            </small>
                                              @error('image')
                                            <span class="invalid-feedback"> <small> *</small> </span>
                                            @enderror
                                         </div>

                                         
                                               <div class="col-md-6">
                                  <div class="custom-file">
                                            <input type="file"name="images[]" multiple class="custom-file-input  @error('images') is-invalid @enderror" id="customFile">
                                                <label class="custom-file-label" for="customFile">Choose More Image</label>
                                            </div>
                                            <small id="emailHelp" class="form-text text-muted"> Choose more images of the design sample slides
                                            </small>
                                              @error('images')
                                            <span class="invalid-feedback"> <small> *</small> </span>
                                            @enderror
                                         </div>
                                            
                            </div> 
                        </div>
                         
                    </div>
                           <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Price variation</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    
                                        <div class="form-group">
                                            <input type="text" name="qty"  value="{{old('qty')}}" class="form-control @error('qty') is-invalid @enderror" id="exampleInputEmail1"
                                                   aria-describedby="emailHelp" placeholder=" Enter a quantity seperated by coma">
                                            <small id="emailHelp" class="form-text text-muted">quantity seperated by comma(,) e.g 100, 200
                                            </small>
                                            @error('qty')
                                            <span class="invalid-feedback"> <small> * </small> </span>
                                            @enderror
                                        </div>
                                        </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <input type="text" name="amount"  value="{{old('amount')}}"class="form-control @error('amount') is-invalid @enderror" id="exampleInput"
                                                   aria-describedby="EventLocation" placeholder="Enter Amount seperated by comma">
                                            <small id="emailHelp" class="form-text text-muted"> Amount for quantity seperated by comma(,)
                                            </small>
                                            @error('amount')
                                            <span class="invalid-feedback"> <small> * </small> </span>
                                            @enderror
                                        </div>
                                </div>
                                   <div class="col-md-6">
                                        <div class="form-group">
                                           <input type="text" name="design_fee"  value="{{old('design_fee')}}"class="form-control @error('design_fee') is-invalid @enderror" id="exampleInput"
                                                   aria-describedby="EventLocation" placeholder="Design Fee">
                                            <small id="emailHelp" class="form-text text-muted"> Design Fee
                                            </small>
                                            @error('design_fee')
                                            <span class="invalid-feedback"> <small> * </small> </span>
                                            @enderror
                                        </div>
                                </div>
                            </div> 
                        </div>
                         
                    </div>
                         <div class="card">
                        <div class="card-body">
                        <div class="row">
                          <div class="col-md-4">
                          </div>
                          <div class="col-md-4">
                        <div class="p-5">
                             <button type="submit" class="btn btn-primary w-100 p-3">Add New Product</button>
                           </div>
                           </div>
                           </div>
                        </div>
                        </div>
                    {{Form::close()}}

    </div>
                        </div>
                    </div>
                   

@endsection
@section('script')
<script>



$('.clockpicker-example').clockpicker({
    autoclose: true
});

$('input[name="date"]').daterangepicker({
  singleDatePicker: true,
  showDropdowns: true
});

let message = {!! json_encode(Session::get('message')) !!};
let msg = {!! json_encode(Session::get('alert')) !!};
//alert(msg);
toastr.options = {
        timeOut: 3000,
        progressBar: true,
        showMethod: "slideDown",
        hideMethod: "slideUp",
        showDuration: 200,
        hideDuration: 200
    };
if(message != null && msg == 'success'){
toastr.success(message);
}else if(message != null && msg == 'error'){
    toastr.error(message);
}
</script>
@endsection