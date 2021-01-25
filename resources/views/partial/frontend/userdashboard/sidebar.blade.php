<div class="blod-details-right-sidebar mrg-blog">

    <!-- Start Category Area -->
    <div class="our-category-area ">
        <h2 class="section-title-2">Dashboard</h2>
        <ul class="categore-menu">
            <li class="mb-3 mt-2 " style="text-align: center"><img src="{{ asset(auth()->user()->user_image) }}" alt="" width="80" ></li>
            <li class="text-capitalize text-dark mb-2 "><a href="{{ route('dashboard.index') }}">my posts</a></li>
            <li class="text-capitalize text-dark mb-2 "><a href="{{ route('dashboard.create') }}">create post</a></li>
            <li class="text-capitalize text-dark mb-2 "><a href="{{ route('comments.index') }}">manage comments</a></li>
            <li class="text-capitalize text-dark mb-2 "><a href="{{route('changePassword')}}">Change Password</a></li>
            <li class="text-capitalize text-dark mb-2 "><a href="#">update information</a></li>
            <li class="text-capitalize text-dark mb-2 "><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">logout</a></li>
        </ul>

    </div>
    <!-- End Category Area -->



</div>
