@extends('admin::layouts.master')
@section('content')
<section class="gray-bg">
	<div class="container-fluid">
		<div class="row no-gutters">
			@include('admin::internals.dashboardtab')
			<div class="dashboard-tab-content padLR60">				
			    <div class="tab-content loaderParent">
				    <div id="loadingDiv">
						<div class="loader"></div>
					</div>
			    	<div class="tab-pane fade show active">
			    		<section>
					      	<h2>Dashboard</h2>
					      	<div class="row">
					      		<div class="box-INT-container">
							      	<div class="box-INT box-INT-white row align-items-center no-gutters">
							      		<div class="box-INT-left">
							      			<div class="box-I"><i class="fas fa-users"></i></div>
							      		</div>
							      		<div class="box-INT-right">
							      			<div class="box-N"><span>{{ $usersCount }}</span></div>
							      			<div class="box-T"><span>USERS</span></div>
							      		</div>
							      	</div>
							    </div>
					      		<div class="box-INT-container">
							      	<div class="box-INT box-INT-white row align-items-center no-gutters">
							      		<div class="box-INT-left">
							      			<div class="box-I"><i class="fas fa-home"></i></i></div>
							      		</div>
							      		<div class="box-INT-right">
							      			<div class="box-N"><span>{{ $parentsCount }}</span></div>
							      			<div class="box-T"><span>PARENTS</span></div>
							      		</div>
							      	</div>
							    </div>
							    <div class="box-INT-container">
							      	<div class="box-INT box-INT-white row align-items-center no-gutters">
							      		<div class="box-INT-left">
							      			<div class="box-I"><i class="fas fa-baby-carriage"></i></div>
							      		</div>
							      		<div class="box-INT-right">
							      			<div class="box-N"><span>{{ $nanniesCount }}</span></div>
							      			<div class="box-T"><span>NANNIES</span></div>
							      		</div>
							      	</div>
							    </div>
							    <div class="box-INT-container">
							      	<div class="box-INT box-INT-white row align-items-center no-gutters">
							      		<div class="box-INT-left">
							      			<div class="box-I"><i class="fas fa-chalkboard-teacher"></i></div>
							      		</div>
							      		<div class="box-INT-right">
							      			<div class="box-N"><span>{{ $mentorsCount }}</span></div>
							      			<div class="box-T"><span>MENTORS</span></div>
							      		</div>
							      	</div>
							    </div>
					      	</div>
					      	<div class="row">
					      		<div class="box-INT-container">
							      	<div class="box-INT box-INT-green row align-items-center no-gutters">
							      		<div class="box-INT-left">
							      			<div class="box-I"><i class="fas fa-medal"></i></div>
							      		</div>
							      		<div class="box-INT-right box-INT-right-colored">
							      			<div class="box-N"><span>{{ $premUsers }}</span></div>
							      			<div class="box-T"><span>PREMIUM USERS</span></div>
							      		</div>
							      	</div>
							    </div>
					      		<div class="box-INT-container">
							      	<div class="box-INT box-INT-green row align-items-center no-gutters">
							      		<div class="box-INT-left">
							      			<div class="box-I"><i class="fas fa-medal"></i></div>
							      		</div>
							      		<div class="box-INT-right box-INT-right-colored">
							      			<div class="box-N"><span>{{ $premParents }}</span></div>
							      			<div class="box-T"><span>PREMIUM PARENTS</span></div>
							      		</div>
							      	</div>
							    </div>
							    <div class="box-INT-container">
							      	<div class="box-INT box-INT-green row align-items-center no-gutters">
							      		<div class="box-INT-left">
							      			<div class="box-I"><i class="fas fa-medal"></i></div>
							      		</div>
							      		<div class="box-INT-right box-INT-right-colored">
							      			<div class="box-N"><span>{{ $premNannies }}</span></div>
							      			<div class="box-T"><span>PREMIUM NANNIES</span></div>
							      		</div>
							      	</div>
							    </div>							    
					      	</div>
					      	<div class="row">
					      		<div class="box-INT-container">
							      	<div class="box-INT box-INT-orange row align-items-center no-gutters">
							      		<div class="box-INT-left">
							      			<div class="box-I"><i class="fas fa-certificate"></i></div>
							      		</div>
							      		<div class="box-INT-right box-INT-right-colored">
							      			<div class="box-N"><span>{{ $freeUsers }}</span></div>
							      			<div class="box-T"><span>FREE USERS</span></div>
							      		</div>
							      	</div>
							    </div>
					      		<div class="box-INT-container">
							      	<div class="box-INT box-INT-orange row align-items-center no-gutters">
							      		<div class="box-INT-left">
							      			<div class="box-I"><i class="fas fa-certificate"></i></div>
							      		</div>
							      		<div class="box-INT-right box-INT-right-colored">
							      			<div class="box-N"><span>{{ $freeParents }}</span></div>
							      			<div class="box-T"><span>FREE PARENTS</span></div>
							      		</div>
							      	</div>
							    </div>
							    <div class="box-INT-container">
							      	<div class="box-INT box-INT-orange row align-items-center no-gutters">
							      		<div class="box-INT-left">
							      			<div class="box-I"><i class="fas fa-certificate"></i></div>
							      		</div>
							      		<div class="box-INT-right box-INT-right-colored">
							      			<div class="box-N"><span>{{ $freeNannies }}</span></div>
							      			<div class="box-T"><span>FREE NANNIES</span></div>
							      		</div>
							      	</div>
							    </div>
							    <div class="box-INT-container">
							      	<div class="box-INT box-INT-brown row align-items-center no-gutters">
							      		<div class="box-INT-left">
							      			<div class="box-I"><i class="fas fa-chart-bar"></i></div>
							      		</div>
							      		<div class="box-INT-right">
							      			<div class="box-N"><span>€ {{ $totalRevenue }}</span></div>
							      			<div class="box-T"><span>REVENUE</span></div>
							      		</div>
							      	</div>
							    </div>
					      	</div>
					    </section>
			    		<section>
					      	<h2>Revenue</h2>
					      	<div class="revenue-slider">	
					      		@foreach($revenues as $revenue)
						      	<div class="revenue-table marB50 revenue-slider-item">
						      		<div class="revenue-year pad20"><span class="prev-year"><</span><span class="year-output padLR10">{{ $revenue[0]->year }}</span><span class="next-year">></span></div>
									<table class="table dashboard-table table-responsive text-center">
										<thead>
											<tr>
												<th scope="col">Jan</th>
												<th scope="col">Feb</th>
												<th scope="col">Mar</th>
												<th scope="col">Apr</th>
												<th scope="col">May</th>
												<th scope="col">Jun</th>
												<th scope="col">Jul</th>
												<th scope="col">Aug</th>
												<th scope="col">Sep</th>
												<th scope="col">Oct</th>
												<th scope="col">Nov</th>
												<th scope="col">Dec</th>
												<th scope="col">Total</th>
											</tr>
											</thead>
											<tbody>
											
											<tr>
												<td>€ {{ $revenue[0]->jan }}</td>
												<td>€ {{ $revenue[0]->feb }}</td>
												<td>€ {{ $revenue[0]->mar }}</td>
												<td>€ {{ $revenue[0]->apr }}</td>
												<td>€ {{ $revenue[0]->may }}</td>
												<td>€ {{ $revenue[0]->jun }}</td>
												<td>€ {{ $revenue[0]->jul }}</td>
												<td>€ {{ $revenue[0]->aug }}</td>
												<td>€ {{ $revenue[0]->sep }}</td>
												<td>€ {{ $revenue[0]->oct }}</td>
												<td>€ {{ $revenue[0]->nov }}</td>
												<td>€ {{ $revenue[0]->dec }}</td>
												<td>€ {{ $revenue[0]->revenue }}</td>
											</tr>
											<tr>
												<td>€ {{ $revenue[1]->jan }}</td>
												<td>€ {{ $revenue[1]->feb }}</td>
												<td>€ {{ $revenue[1]->mar }}</td>
												<td>€ {{ $revenue[1]->apr }}</td>
												<td>€ {{ $revenue[1]->may }}</td>
												<td>€ {{ $revenue[1]->jun }}</td>
												<td>€ {{ $revenue[1]->jul }}</td>
												<td>€ {{ $revenue[1]->aug }}</td>
												<td>€ {{ $revenue[1]->sep }}</td>
												<td>€ {{ $revenue[1]->oct }}</td>
												<td>€ {{ $revenue[1]->nov }}</td>
												<td>€ {{ $revenue[1]->dec }}</td>
												<td>€ {{ $revenue[1]->revenue }}</td>
											</tr>
											
										</tbody>
									</table>
								</div>
								@endforeach
					      	</div>					      	
					    </section>
			    	</div>
			    </div>
		  	</div>
		</div>
	</div>
</section>
@endsection