<body>
    <div class="site-wrapper" id="top">
        <div class="site-header d-none d-lg-block">
         <div class="header-top header-top--style-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <ul class="header-top-list">
                                <li class="dropdown-trigger currency-dropdown"><a href="#">₦ NG</a><i
                                        class="fas fa-chevron-down dropdown-arrow"></i>
                                   
                                </li>
                                <li class="dropdown-trigger language-dropdown"><a href="#"><span class="flag-img"><img
                                                src="{{asset('/frontend/image/icon/ng.png')}}" alt=""></span>NG </a><i
                                        class="fas fa-chevron-down dropdown-arrow"></i>
                                    <ul class="dropdown-box">
                                        <li> <a href="#"> <span class="flag-img"><img src="image/icon/eng-flag.png"
                                                        alt=""></span>English</a>
                                        </li>
                                       
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-8 flex-lg-right">
                            <ul class="header-top-list">
                            @auth
                                <li class="dropdown-trigger language-dropdown"><a href="#"><i
                                            class="icons-left fas fa-user"></i>
                                        My Account</a><i class="fas fa-chevron-down dropdown-arrow"></i>
                                    <ul class="dropdown-box">
                                        <li> <a href="{{route('user.account')}}">My Account</a></li>
                                        <li> <a href="{{route('user.account')}}">Order History</a></li>
                                        <li> <a href="#">Logout</a></li>
                                    </ul>
                                </li>
                                @endauth
                                <li><a href="#"><i class="icons-left fas fa-phone"></i> Contact</a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-middle pt--10 pb--10">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-2 ">
                            <a href="{{route('index')}}" class="site-brand">
                                <img src="{{asset('/frontend/image/logo.png')}}" alt="" width="200px">
                            </a>
                        </div>
                        <div class="col-lg-10">
                            <div class="main-navigation flex-lg-right">
                                <ul class="main-menu menu-right "> 
                                   @foreach ($menu as $menus)
                                   <li class="menu-item" >            
                                        <a style="font-size:14px; font-weight:bold" href="javascript:void(0)">{{$menus->name}} </a>           
                                    </li>
                                     @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom pb--10">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            <nav class="category-nav">
                                <div>
                                <a href="javascript:void(0)" class="category-trigger"><i
                                            class="fa fa-bars"></i>Browse
                                        categories</a>
                                    <ul class="category-menu">
                                    @foreach( $menu_categories as $cat )
                                        <li class="cat-item has-children">
                                            <a href="#">{{$cat->name}}</a>
                                            	<ul class="sub-menu">
                                                @foreach ($cat->products as $prod)
												<li class="cat-item has-children"><a href="{{url('/products/details', $cat->name.'_'.encrypt($prod->id))}}">{{$prod->name}}</a>
                                                <ul class="sub-menu">
												<li><a href="{{url('/products/details', $cat->name.'_'.encrypt($prod->id))}}"><img src="{{asset('/frontend/image/products/product-1.jpg')}}" alt="">
                                                <span class="font-bold text-center">{{$prod->name}} </span> <br> 
                                                <span>₦{{number_format($prod->price,2)}} 1 copy</span> 
                                                <span class="btn-primary w-100 text-center"> Order Now</span>
                                                </a>
                                                </li>
									        	</ul>
                                                </li>
                                                 @endforeach
											</ul>
                                             
                                        </li>                   
                                    @endforeach
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="col-lg-5">
                            <div class="header-search-block">
                                <input type="text" placeholder="Search entire store here">
                                <button>Search</button>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="main-navigation flex-lg-right">
                                <div class="cart-widget">
                                @guest
                                    <div class="login-block">
                                        <a href="{{route('login')}}" class="font-weight-bold">Login</a> <br>
                                        <span>or</span><a href="{{route('register')}}">Register</a>
                                    </div>
                                    @else
                                     <div class="login-block">
                                     <span class="spinner-grow spinner-grow-sm text-success __web-inspector-hide-shortcut__" role="status">
                                        <span class="sr-only"></span>
                                        </span>
                                        <a href="" class="font-weight-bold">Welcome</a>  <br>
                                        <a href="">{{strtoupper(auth()->user()->name)}}</a>
                                    </div>

                                     @endguest
                                    <div class="cart-block">
                                        <div class="cart-total ">
                                           <a href="{{route('carts.index')}}"> <span class="text-number cartReload">
                                              @if(Cart::count()> 0){{Cart::count()}}  @else 0 @endif
                                            </span>
                                            <span class="text-item">
                                                Shopping Cart
                                            </span>
                                            <span class="price cartPrice">
                                                @if(Cart::count() > 0)₦{{number_format(Cart::priceTotalfloat())}} @endif
                                                
                                            </span></a>
                                        </div>
                            
                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-mobile-menu">
            <header class="mobile-header d-block d-lg-none pt--10 pb-md--10">
                <div class="container">
                    <div class="row align-items-sm-end align-items-center">
                        <div class="col-md-4 col-7">
                            <a href="{{route('index')}}" class="site-brand">
                                <img src="{{asset('/frontend/image/logo.png')}}" alt="">
                            </a>
                        </div>
                        <div class="col-md-5 order-3 order-md-2">
                            <nav class="category-nav   ">
                                <div>
                                    <a href="javascript:void(0)" class="category-trigger"><i
                                            class="fa fa-bars"></i>Browse
                                        categories</a>
                            <ul class="category-menu">
                                    @foreach( $menu_categories as $cat )
                                        <li class="cat-item has-children">
                                            <a href="#">{{$cat->name}}</a>
                                            	<ul class="sub-menu">
                                                @foreach ($cat->products as $prod)
												<li class="cat-item has-children"><a href="{{url('/products/details', $cat->name.'_'.encrypt($prod->id))}}">{{$prod->name}}</a>
                                                <ul class="sub-menu">
												<li><a href="{{url('/products/details', $cat->name.'_'.encrypt($prod->id))}}"><img src="{{asset('/frontend/image/products/product-1.jpg')}}" alt="">
                                                <span class="font-bold text-center">{{$prod->name}} </span> <br> 
                                                <span>₦{{number_format($prod->price,2)}} 1 copy</span> 
                                                <span class="btn-primary w-100 text-center"> Order Now</span>
                                                </a>
                                                </li>
									        	</ul>
                                                </li>
                                                 @endforeach
											</ul>
                                             
                                        </li>                   
                                    @endforeach
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="col-md-3 col-5  order-md-3 text-right">
                            <div class="mobile-header-btns header-top-widget">
                                <ul class="header-links">
                                    <li class="sin-link">
                                        <a href="{{route('carts.index')}}"> <span style="font-size:12px; color:red" class="cartReload">
                                              @if(Cart::count()> 0){{Cart::count()}}  @else 0 @endif
                                            </span>
                                            <i class="ion-bag"></i></a>
                                    </li>
                                    <li class="sin-link">
                                        <a href="javascript:" class="link-icon hamburgur-icon off-canvas-btn"><i
                                                class="ion-navicon"></i></a>
                                    </li>
                                     
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!--Off Canvas Navigation Start-->
            <aside class="off-canvas-wrapper">
                <div class="btn-close-off-canvas">
                    <i class="ion-android-close"></i>
                </div>
                <div class="off-canvas-inner">
                    <!-- search box start -->
                    <div class="search-box offcanvas">
                        <form>
                            <input type="text" placeholder="Search Here">
                            <button class="search-btn"><i class="ion-ios-search-strong"></i></button>
                        </form>
                    </div>
                    <!-- search box end -->
                    <!-- mobile menu start -->
                    <div class="mobile-navigation">
                        <!-- mobile menu navigation start -->
                        <nav class="off-canvas-nav">
                            <ul class="mobile-menu main-mobile-menu">
                              
                              @foreach ($menu as $menus ) 
                                <li class="menu-item">
                                    <a href="#">{{$menus->name}}</a>
                                   
                                </li>
                                 @endforeach
                               
                            </ul>
                        </nav>
                        <!-- mobile menu navigation end -->
                    </div>
                    <!-- mobile menu end -->
                    <nav class="off-canvas-nav">
                        <ul class="mobile-menu menu-block-2">
                            <li class="menu-item-has-children">
                                <a href="#">Currency - NGN <i class="fas fa-angle-down"></i></a>
                                <ul class="sub-menu">
                                  
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Lang - Eng<i class="fas fa-angle-down"></i></a>
                                <ul class="sub-menu">
                                    <li>Eng</li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">My Account <i class="fas fa-angle-down"></i></a>
                                <ul class="sub-menu">
                                   <li> <a href="{{route('user.account')}}">My Account</a></li>
                                   <li> <a href="{{route('user.account')}}">Order History</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    {{-- <div class="off-canvas-bottom">
                        <div class="contact-list mb--10">
                            <a href="#" class="sin-contact"><i class="fas fa-mobile-alt"></i>(12345) 78790220</a>
                            <a href="#" class="sin-contact"><i class="fas fa-envelope"></i>examle@handart.com</a>
                        </div>
                        <div class="off-canvas-social">
                            <a href="#" class="single-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="single-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="single-icon"><i class="fas fa-rss"></i></a>
                            <a href="#" class="single-icon"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="single-icon"><i class="fab fa-google-plus-g"></i></a>
                            <a href="#" class="single-icon"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div> --}}
                </div>
            </aside>
            <!--Off Canvas Navigation End-->
        </div>
        <div class="sticky-init fixed-header common-sticky">
            <div class="container d-none d-lg-block">
                <div class="row align-items-center">
                    <div class="col-lg-2">
                        <a href="{{route('index')}}" class="site-brand">
                            <img src="{{asset('/frontend/image/logo.png')}}" alt="">
                        </a>
                    </div>
                    <div class="col-lg-10">
                        <div class="main-navigation flex-lg-right">
                            <ul class="main-menu menu-right ">
                               @foreach ($menu as $menus )
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0)" style="font-size:14px; font-weight:bold" >{{$menus->name}} </a>
                                </li>
                                  @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        