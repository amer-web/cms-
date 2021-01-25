<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- JQuery min js -->
{{-- <script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script> --}}
<script src="{{ asset('js/app.js') }}"></script>
<!-- Bootstrap Bundle js -->
<script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/ionicons/ionicons.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>

<!-- Rating js-->
<script src="{{URL::asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{URL::asset('assets/plugins/rating/jquery.barrating.js')}}"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="{{URL::asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>
<!--Internal Sparkline js -->
<script src="{{URL::asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- right-sidebar js -->
<script src="{{URL::asset('assets/plugins/sidebar/sidebar-rtl.js')}}"></script>
<script src="{{URL::asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>
<!-- Eva-icons js -->
<script src="{{URL::asset('assets/js/eva-icons.min.js')}}"></script>
<!--Internal  Notify js -->
@yield('js')
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<!-- Sticky js -->
<script src="{{URL::asset('assets/js/sticky.js')}}"></script>
<!-- custom js -->
<script src="{{URL::asset('assets/js/custom.js')}}"></script><!-- Left-menu js-->
<script src="{{URL::asset('assets/plugins/side-menu/sidemenu.js')}}"></script>
<script>
    @if(Session::has('success'))
	notif({
		msg: "<b>Success:</b> {{ Session::get('success') }}",
		type: "success"
	});
    @endif

    @if(Session::has('error'))
	notif({
		type: "error",
		msg: "<b>Error: </b>{{ Session::get('error') }}.",
		position: "center",
	});
    @endif

    Echo.join(`status-friends`)
        .here((users) => {
            $.each(users,function (index ){
                let userOnline = users[index].username;
                $("#"+userOnline+" span.avatar-status").addClass('bg-success');
            });
        })
        .joining((user) => {
            let userJoining = user.username;
            $("#"+userJoining+" span.avatar-status").addClass('bg-success');
        })
        .leaving((user) => {
            let userLeave = user.username;
            $("#"+userLeave+" span.avatar-status").removeClass('bg-success');
        });
</script>
