@extends('layouts.master')
@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
<!-- Internal Morris Css-->
<link href="{{URL::asset('assets/plugins/morris.js/morris.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="left-content">
						<div>
						  <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1 text-capitalize">Hi {{ auth()->user()->username }}, welcome back!</h2>
						</div>
					</div>
				</div>
				<!-- /breadcrumb -->
@endsection
@section('content')
                <!-- statics for users and posts -->
				<!-- row -->
				<div class="row row-sm">
					<div class="col-lg-6 col-xl-3 col-md-6 col-12">
						<div class="card bg-primary-gradient text-white ">
							<div class="card-body">
								<div class="row">
									<div class="col-6">
										<div class="icon1 mt-2 text-center">
											<i class="fe fe-users tx-40"></i>
										</div>
									</div>
									<div class="col-6">
										<div class="mt-0 text-center">
											<span class="text-white">All Users</span>
											<h2 class="text-white mb-0">{{ $users }}</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-xl-3 col-md-6 col-12">
						<div class="card bg-success-gradient text-white">
							<div class="card-body">
								<div class="row">
									<div class="col-6">
										<div class="icon1 mt-2 text-center">
											<i class="fe fe-bar-chart-2 tx-40"></i>
										</div>
									</div>
									<div class="col-6">
										<div class="mt-0 text-center">
											<span class="text-white">Active Posts</span>
											<h2 class="text-white mb-0">{{ $activePosts }}</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-6 col-lg-6 col-sm-6">
						<div class="card">
							<div class="card-body">
								<div class="plan-card text-center">
									<i class="fas fa-comments plan-icon text-primary"></i>
									<h6 class="text-drak text-uppercase mt-2">Total Comments</h6>
									<h2 class="mb-2">{{ $comments }}</h2>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-6 col-sm-6">
						<div class="card">
							<div class="card-body">
								<div class="plan-card text-center">
									<i class="fas fa-mail-bulk plan-icon text-primary"></i>
									<h6 class="text-drak text-uppercase mt-2">Total Contact Unread</h6>
									<h2 class="mb-2">{{ $contact }}</h2>
								</div>
							</div>
						</div>
					</div>
				</div>
                <!-- row closed -->
                <div class="row row-sm">
					<div class="col-sm-12">
						<div class="card overflow-hidden">
							<div class="card-body">
								<div class="main-content-label mg-b-5">
									Line Chart
								</div>
								<p class="mg-b-20">Basic Charts Of Valex template.</p>
								<div class="chartjs-wrapper-demo">
									<canvas id="chartLine1"></canvas>
								</div>
							</div>
						</div>
					</div><!-- col-6 -->
                </div>

                <div class="row row-sm">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="main-content-label mg-b-5">
                                Donut Chart
                            </div>
                            <p class="mg-b-20">Basic Charts Of Valex template.</p>
                            <div class="morris-donut-wrapper-demo" id="morrisDonut2"></div>
                        </div>
                    </div>
                </div><!-- col-6 -->
                </div>


               <!-- latest posts and comments -->
				<!-- row opened -->
				<div class="row row-sm row-deck">
					<div class="col-md-12 col-xl-6">
						<div class="card card-table-two">
							<div class="d-flex justify-content-between">
								<h4 class="card-title mb-3">Latest Posts</h4>
							</div>
							<div class="table-responsive country-table">
								<table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
									<thead>
										<tr>
											<th class="wd-lg-25p">Title</th>
											<th class="wd-lg-25p ">Comments</th>
											<th class="wd-lg-25p">Status</th>
											<th class="wd-lg-25p">Date</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach ($last_posts as $last_post)
                                            <tr>
                                                <td>
                                                @permission('update_post')
                                                    <a href="{{ route('admin.posts.edit', $last_post->slug) }}">{{ $last_post->title }}</a>
                                                @else
                                                    {{ $last_post->title }}
                                                @endpermission
                                                </td>
                                                <td class="">{{ $last_post->comments->count() }}</td>
                                                <td>{{ $last_post->status }}</td>
                                                <td>{{ $last_post->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
                    <div class="col-md-12 col-xl-6">
						<div class="card card-table-two">
							<div class="d-flex justify-content-between">
								<h4 class="card-title mb-3">Latest Comments</h4>
							</div>
							<div class="table-responsive country-table">
								<table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
									<thead>
										<tr>
											<th class="wd-lg-25p">Name</th>
											<th class="wd-lg-25p">Comment</th>
											<th class="wd-lg-25p">Status</th>
											<th class="wd-lg-25p">Date</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach ($last_comments as $last_comment)
                                            <tr>
                                                <td>
                                                    @permission('update_comment')
                                                        <a href="{{ route('admin.comments.edit', $last_comment->id) }}">{{ $last_comment->name }} </a>
                                                    @else
                                                        {{ $last_comment->name }}
                                                    @endpermission
                                                </td>
                                                <td>{{ Str::limit($last_comment->comment, 20, '...')  }}</td>
                                                <td>{{ ($last_comment->status == 1)? 'Active' : 'InActive' }}</td>
                                                <td class="">{{ $last_comment->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
		</div>
		<!-- Container closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<!-- chart js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!--Internal  Flot js-->
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/plugins/morris.js/morris.min.js')}}"></script>
<!--Internal Apexchart js-->
{{-- <script src="{{URL::asset('assets/js/apexcharts.js')}}"></script> --}}
<!-- Internal Map -->
{{-- <script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script> --}}
{{-- <script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script> --}}
<script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>
@endsection
