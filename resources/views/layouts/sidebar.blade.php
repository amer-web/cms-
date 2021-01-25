<!-- Sidebar-right-->
		<div class="sidebar sidebar-left sidebar-animate">
			<div class="panel panel-primary card mb-0 box-shadow">
				<div class="tab-menu-heading border-0 p-3">
					<div class="card-title mb-0">Notifications</div>
					<div class="card-options mr-auto">
						<a href="#" class="sidebar-remove"><i class="fe fe-x"></i></a>
					</div>
				</div>
				<div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
					<div class="tabs-menu ">
						<!-- Tabs -->
						<ul class="nav panel-tabs">
							<li><a href="#side1" data-toggle="tab" class="active"><i class="ion ion-md-contacts tx-18 ml-2"></i> Friends</a></li>
						</ul>
					</div>
					<div class="tab-content">
						<div class="tab-pane  active" id="side1">
                            <div class="list-group list-group-flush ">
                                @foreach($userAdmins as $admin)
                                    @if(auth()->id() != $admin->id)
                                <div class="list-group-item d-flex  align-items-center" id="{{ $admin->username }}">
                                    <div  class="ml-2">
                                        <span class="avatar avatar-md brround cover-image" data-image-src="{{ asset('assets/img/faces/9.jpg') }}"><span class="avatar-status"></span></span>
                                    </div>
                                    <div class="">
                                        <div class="font-weight-semibold text-capitalize ml-1" data-toggle="modal" data-target="#chatmodel">{{ $admin->username }}</div>
                                    </div>
                                    <div class="mr-auto">
                                        <a href="#" class="btn btn-sm btn-light" data-toggle="modal" data-target="#chatmodel" ><i class="fab fa-facebook-messenger"></i></a>
                                    </div>
                                </div>
                                    @endif
                                @endforeach
                            </div>


						</div>
					</div>
				</div>
			</div>
		</div>
<!--/Sidebar-right-->
