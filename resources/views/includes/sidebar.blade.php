			<aside class="col-md-3 col-sm-4 col-xs-12 account-sidebar sidebar d-md-none d-sm-none">
						<h3 class="acc-title lg"><a href="{{route('user.index')}}" style="color:#fff"> Dashboard</a></h3>
							<ul>
							<li>
								<a href="{{route('user.account')}}" title="account dashboard">My Profile</a>
							</li>
							<li>
								<a href="{{route('user.orders')}}" title="My Orders">My Orders</a>
							</li>
							<li>
								<a href="{{route('user.transactions')}}" title="Transactions">Transactions</a>
							</li>
							<li>
								<a href="{{route('user.notification')}}" title="Notifications">Notification</a>
							</li>
							<li class="">
								<a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout').submit()" title="Logout">Logout</a>

								<form id="logout" action="{{route('logout')}}" method="post">
								@csrf
								</form>
							</li>
							
						</ul>
					</aside>