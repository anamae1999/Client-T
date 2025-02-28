<div class="dashboard-tab">
	@if(Auth::user()->role == 'sitter')
		@php
			$urlPre = 'nannies';
		@endphp
	@elseif(Auth::user()->role == 'parent')
		@php
			$urlPre = 'parents';
		@endphp
	@elseif(Auth::user()->role == 'mentor')
		@php
			$urlPre = 'mentors';
		@endphp
	@endif
	<div class="nav flex-column nav-pills" id="dashboard-tab" role="tablist" aria-orientation="vertical">
		<a class="nav-link" href="/{{$urlPre}}/dashboard"><i class="fas fa-user"></i><span>Profile</span></a>
		<a class="nav-link" href="/{{$urlPre}}/messages"><i class="fas fa-envelope"></i><span>Messages</span></a>
		@if(Auth::user()->role == 'mentor')
		<a class="nav-link" href="/mentors/agendas"><i class="fas fa-calendar"></i><span>Agendas</span></a>
		@endif
		<a class="nav-link" href="/{{$urlPre}}/settings"><i class="fas fa-cog"></i><span class="settings-label-lg">Account Settings</span><span class="settings-label-sm">Settings</span></a>
	</div>
</div>