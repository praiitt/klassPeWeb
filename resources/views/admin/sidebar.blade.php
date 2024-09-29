<ul class="sidebar navbar-nav" id="menu">
    <div id="single_menu">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/subject') }}">
                <i class="fa fa-book "></i>
                <span>Subject</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/standard') }}">
                <i class="fas fa-sort-numeric-down "></i>
                <span>Standard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/fees') }}">
                <i class="fa fa-credit-card "></i>
                <span>Add Fees</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/hours_availability') }}">
                <i class="fa fa-credit-card "></i>
                <span>Add Hours Availability</span>
            </a>
        </li>
        <li class="nav-item dropdown menuHeader">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-file"></i>
                <span>Report</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="{{ url('admin/view_user') }}">View User</a>
                <a class="dropdown-item" href="{{ url('admin/view_request') }}">View request</a>
                <a class="dropdown-item" href="{{ url('admin/view_monthly_fees') }}">View Monthly Fees</a>
                <a class="dropdown-item" href="{{ url('admin/view_payment') }}">View Payment</a>
                <a class="dropdown-item" href="{{ url('admin/view_payment_percentage') }}">Payment Percentage</a>
            </div>
        </li>
        <div id="single_menu">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/setting') }}">
                    <i class="fa fa-cog"></i>
                    <span>Setting</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/Send_Notification') }}">
                    <i class="fa fa-bell "></i>
                    <span>Send Notification</span>
                </a>
            </li>
        </div>
</ul>