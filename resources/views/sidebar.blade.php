<!--student-->
@if(session()->get('type') == 'student')
<div id="mySidenav" class="sidenav">
    <div class="textField-bg pt-5 d-flex align-items-center flex-column ml-n6">
        <a href="javascript:void(0)" class="closebtn " onclick="closeNav()">&times;</a>
        <a href="#" onclick="closeNav()" data-toggle="modal" data-target="#profileModal" data-whatever="">
            <img src="{{ (isset($side)) ? ((empty($side->image)) ? asset('public/assets/img/avatar.png') : asset($side->image) ) : asset('public/assets/img/avatar.png') }}" height="100px" width="100px" class="user-profile shadow  rounded-circle"/></a>
        <a href="#" onclick="closeNav()" data-toggle="modal" data-target="#profileModal" data-whatever="" class="text-blue">
            <small><p>Hi, {{ (isset($side)) ? (empty($side->username) ? 'Unnamed Student' : $side->username) : 'Unnamed Student' }}</p></small></a>
    </div>
    <div class="mt-2">
        <a href="{{ url('/') }}"><i class="bi bi-house-door h4 text-lighter mr-3"></i>Home</a>
        <a href="{{ url('Find_tutor') }}"><i class="bi bi-search h4 text-lighter mr-3"></i>Find Tutor</a>
        <a href="{{ url('My_tutor') }}"><svg class="h4 text-lighter mr-3" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2H2Z"/>
            </svg>My Tutor</a>
        <a href="{{ url('Send_request') }}"><svg class="h4 text-lighter mr-3" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
            </svg>Send Request</a>
        <a href="#" onclick="closeNav()" data-toggle="modal" data-target="#profileModal" data-whatever=""><i class="bi bi-person-circle h4 text-lighter mr-3"></i>My Profile</a>
        <a href="{{ url('About') }}"><i class="bi bi-info-circle-fill h4 text-lighter mr-3"></i>About Us</a>
        <a href="{{ url('Privacy') }}"><i class="bi bi-shield-fill-check h4 text-lighter mr-3"></i>Privacy Policy</a>
        <a href="{{ url('Logout') }}"><i class="bi bi-box-arrow-right text-lighter h4 mr-3"></i>Logout</a>
    </div>
</div>
@endif
<!--tutor-->
@if(session()->get('type') == 'tutor')
<div id="mySidenav" class="sidenav">
    <div class="textField-bg pt-5 d-flex align-items-center flex-column ml-n6">
        <a href="javascript:void(0)" class="closebtn " onclick="closeNav()">&times;</a>
        <a href="{{ url('Tutor_profile') }}" class="">
            <img src="{{ (isset($side)) ? ((empty($side->image)) ? asset('public/assets/img/avatar.png') : asset($side->image) ) : asset('public/assets/img/avatar.png') }}" class="user-profile shadow  rounded-circle"/></a>
        <a href="" class="text-blue text-left"><small><p>Hi,  {{ (isset($side)) ? (empty($side->username) ? 'Unnamed Tutor' : $side->username) : 'Unnamed Tutor' }}</p></small></a>
    </div>
    <div class="mt-2">
        <a href="{{ url('/') }}"><i class="bi bi-house-door h4 text-lighter mr-3"></i>Home</a>
        <a href="{{ url('Request_list') }}"><i class="bi bi-search h4 text-lighter mr-3"></i>Request List</a>
        <a href="{{ url('My_student') }}"><svg class="h4 text-lighter mr-3" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2H2Z"/>
            </svg>My Student</a>
        <a href="{{ url('Tutor_profile') }}"><i class="bi bi-person-circle h4 text-lighter mr-3"></i>My Profile</a>
        <a href="{{ url('About') }}"><i class="bi bi-info-circle-fill h4 text-lighter mr-3"></i>About Us</a>
        <a href="{{ url('Privacy') }}"><i class="bi bi-shield-fill-check h4 text-lighter mr-3"></i>Privacy Policy</a>
        <a href="{{ url('Logout') }}"><i class="bi bi-box-arrow-right text-lighter h4 mr-3"></i>Logout</a>
    </div>
</div>
@endif