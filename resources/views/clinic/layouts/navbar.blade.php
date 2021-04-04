<div class="navbar navbar-expand-md navbar-dark fixed-top">
	<div class="navbar-brand  text-center" style="font-size: 18px;color: #6d6d6d">
    <h4 style="text-align: right;line-height: 1.0;padding-right: 25px;">لوحة تحكم العيادات</h4>
        <h6 style="text-align: right;line-height: 1.0;padding-right: 25px;    color: #fca87e;">{{auth()->user()->clinic->name_ar}}</h6>
	</div>

	<div class="d-md-none">
{{--		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">--}}
{{--			<i class="icon-tree5"></i>--}}
{{--		</button>--}}
		<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
			<i class="icon-paragraph-justify3"></i>
		</button>
	</div>

	<div class="collapse navbar-collapse" id="navbar-mobile">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
					<i class="icon-paragraph-justify3"></i>
				</a>
			</li>
		</ul>

		<ul class="navbar-nav ml-auto">




            <a href="/" class="d-inline-block">
                <img src="{{asset('portal/assets/images/logo.svg')}}" alt="" style="    height: 70px;">
            </a>




		</ul>
	</div>
</div>
