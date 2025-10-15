@extends('layouts.admin')
@section('content')
<div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                     <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="card-title">Orders Details</h6>
                                <div>
                                    <a href="#" class="mr-3">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown" aria-haspopup="true"
                                           aria-expanded="false">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                 <div class="table-responsive">
                                        <table id="myTable" class="table table-striped table-bordered">
                                           <thead>
                                            <tr><th class="text-left">S/N</th>
                                                <th>Order No</th>
                                                <th>Product Name</th>
                                                  <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Design Fee</th>
                                                <th>Customer Design</th>
                                                  <th>Customer Request</th>
                                                 <th>Created At</th>
                                                 <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                        @if(count($ordersItems) > 0)
                                        @foreach ($ordersItems as  $sp)
                                            <tr>
                                            <td>{{$sp->id}}</td>
                                               
                                                <td>
                                                    <a href="#">{{$sp->order_No}}</a>
                                                </td>
                                                <td>
                                                    <a href="#">{{$sp->product_name}}</a>
                                                </td>
                                            
                                                 <td>
                                                    <a href="#">{{number_format($sp->price,2)}}</a>
                                                </td>
                                                  <td>
                                                    <a href="#">{{$sp->qty}}</a>
                                                </td>
                                                 <td>
                                                    <a href="#">{{number_format($sp->design_fee,2)}}</a>
                                                </td>
                                            
                                                 <td>
                                                     @php
                                                        $dd = json_decode($sp->design_image);
                                                    @endphp
                                                    @if(isset($dd) && count($dd) > 0)
                                                    @foreach ($dd as $img )
                                                        <img src="{{asset('/images/products/'.$img)}}" width="50px" height="50px"> 
                                                  
                                                    <a href="#"> <a href="{{route('design.download', encrypt($img))}}" class=" btn-primary btn-sm ">Download</a> 
                                                    </a>
                                                       @endforeach
                                                    @else
                                                    No Design image
                                                    @endif 
                                                    </td>
                                               
                                                <td>
                                                {{$sp->description}}
                                                </td>      
                                                  <td>
                                                    <a href="#">{{$sp->created_at->format('d/M/y')}}</a>
                                                </td>
                                            </tr>
                                              @endforeach
                                              @else 
                                              <tr>
                                              <td> No data available </td>
                                              </tr>
                                              @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                 </div>
                  </div>

@endsection