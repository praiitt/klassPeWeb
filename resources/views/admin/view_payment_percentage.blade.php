<!DOCTYPE html>
<html lang="en">
    <!-- Head-->
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="In This Web Inventory(Web Apps) in Admin can create multiple roles & permissions for users. ">
        <meta name="author" content="Web Inventory">
        <meta http-equiv="X-Frame-Options" content="deny">
        <meta http-equiv="X-XSS-Protection" content="0">
        <meta content="text/html; charset=UTF-8; X-Content-Type-Options=nosniff" http-equiv="Content-Type" />
        <title>Payment Percentage List</title>

        <!-- Custom fonts for this template-->
        <link href="{{ asset('public/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('public/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Page level plugin CSS-->
        <link href="{{ asset('public/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
        <link href="{{ asset('public/vendor/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="{{ asset('public/css/sb-admin.css') }}" rel="stylesheet">
        <style>
            #CalendarControlIFrame {  
                display: none;  left: 0px;  position: absolute;  top: 0px;  height: 250px;  width: 250px;  z-index: 99;
            }
            #CalendarControl {  
                position:absolute;  background-color:#d1e3f9;  margin:0;  padding:0;  display:none;  z-index: 100;
            }
            #CalendarControl table {  
                font-family: arial, verdana, helvetica, sans-serif;  font-size: 8pt;
            }
            #CalendarControl th {
                font-weight: normal;
            }
            #CalendarControl th a {  
                font-weight: normal;  text-decoration: none;  color: #000;  padding: 1px;
            }
            #CalendarControl td {  
                text-align: center;
            }
            #CalendarControl .cal_header {  
                background-color: #eceeed;  color:#000;  height:30px;
            }
            #CalendarControl .weekday {  
                background-color: #d1e3f9;  color: #000;
            }
            #CalendarControl .weekend {  
                background-color: #f5f5e0;  color: #000;
            }
            #CalendarControl .current { 
                background-color: #696969;  color: #FFF;
            }
            #CalendarControl .weekday,#CalendarControl .weekend,#CalendarControl .current {  
                display: block;  text-decoration: none;  line-height:25px;    padding:8px;
            }
            #CalendarControl .cl_header { 
                text-align:  center; background: #eceeed; line-height:25px;
            } 
            #CalendarControl .weekday:hover,#CalendarControl .weekend:hover,#CalendarControl .current:hover {  
                color: #FFF;  background-color: #696969;
            }
            #CalendarControl .previous,#CalendarControl .next {  
                padding: 1px 3px 1px 3px;  font-size: 1.4em;
            }
            #CalendarControl .previous a,#CalendarControl .next a {  
                color:#000;  text-decoration: none;  font-weight: bold;  font-size:14px;
            }
            #CalendarControl .title { 
                text-align: center;  font-weight: bold;  color: #000;  font-size:14px;
            }
            #CalendarControl .empty {  
                background-color: #d1e3f9;
            }
            .CalenderButton{	
                margin-top:0px;
            }
            #dpMonthYear { 	
                width: calc(100% - 30px);
            }
        </style>
    </head>
    <!-- //Head-->
    <body id="page-top">
        <!-- Topbar -->
        @include('admin/topbar')
        <div id="wrapper">

            <!-- Sidebar -->
            @include('admin/sidebar')
            <!-- content-wrapper -->
            <div id="content-wrapper">

                <div class="container-fluid mb-5">

                    <!-- Breadcrumbs-->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="">Payment Percentage List</a>
                        </li>

                    </ol>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="col-lg-12" align="right">
                                <td><a href = '#addinstruction' style="color: black;" data-toggle = 'modal'><i class="fa fa-info-circle "></i></a>
                            </div>
                            <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  
                                <div class="form-group row">
                                    <label for="ticket-name" class="col-sm-1 control-label" id="lblpartydate">Month</label>
                                    <div class="col-sm-3" id="partydue">
                                        <input  id="current_month"  name="current_month" id="from_date"  class="form-control" placeholder="Month" value="<?php echo isset($_GET['current_month']) ? $_GET['current_month'] : '' ?>" onclick="showCalendarControl('current_month');">
                                    </div>

                                    <div class = "button-items">
                                        <button type = "submit" id="btn_go" class = "btn btn-primary waves-effect waves-light"  onclick="getSummary();"><i class="fa fa-search" ></i></button>
                                    </div>

                                </div>
                            </form>


                        </div>
                    </div>
                    <!-- Icon Cards-->
                    <div class="card mb-5 mt-5">
                        <div class="card-header">
                            <i class="fas fa-table"></i>&nbsp;View Payment Percentage List
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tutor Email</th>
                                            <th>Total Amount</th>
                                            <th>Commission Amount</th>
                                            <th>Remain Payment Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($month_payment))
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach ($month_payment as $request)
                                        @php
                                        $per = ($request->amount) * ($percentage[0]->percentage/100);
                                        @endphp
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $request->tutor_email }}</td>
                                            <td>{{ $request->amount }}</td>
                                            <td>{{ $per }}</td>
                                            <td>{{ ($request->amount - $per) }}</td>
                                        </tr>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal fade" id="addinstruction" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <!-- modal-dialog -->
                        <div class="modal-dialog modal-dialog-centered">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0 ml-2">Instruction</h5>
                                    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <p><i class="fa fa-hand-point-right"></i> Search by month: You must select the month, and then you can find the Payment reports for that month.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
                <!-- /.container-fluid -->

                <!-- Sticky Footer -->
                @include('admin/footer')
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /#wrapper -->


        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('public/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset('public/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

        <!-- Required datatable js -->
        <script src="{{ asset('public/vendor/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Buttons examples -->
        <script src="{{ asset('public/vendor/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/jszip.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/buttons.print.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/buttons.colVis.min.js') }}"></script>
        <!-- Responsive examples -->
        <script src="{{ asset('public/vendor/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/responsive.bootstrap4.min.js') }}"></script>

        <script src="{{ asset('public/js/datatable-buttons.js') }}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset('public/js/sb-admin.min.js') }}"></script>
        <script src="{{ asset('public/vendor/chart.js/Chart.min.js') }}"></script>

        <!-- Demo scripts for this page-->
        <script src="{{ asset('public/js/demo/datatables-demo.js') }}"></script>
        <script src="{{ asset('public/vendor/select2/select2.min.js') }}"></script>
        <script src="{{ asset('public/js/nav-heighlight.js') }}"></script>
        <script src="{{ asset('public/js/datatables.init.js') }}"></script>
        <script type="text/javascript">
                                            function positionInfo(object) {
                                                var p_elm = object;
                                                this.getElementLeft = getElementLeft;
                                                function getElementLeft() {
                                                    var x = 0;
                                                    var elm;
                                                    if (typeof (p_elm) == "object") {
                                                        elm = p_elm;
                                                    } else {
                                                        elm = document.getElementById(p_elm);
                                                    }
                                                    while (elm != null) {
                                                        x += elm.offsetLeft;
                                                        elm = elm.offsetParent;
                                                    }
                                                    return parseInt(x);
                                                }
                                                this.getElementWidth = getElementWidth;
                                                function getElementWidth() {
                                                    var elm;
                                                    if (typeof (p_elm) == "object") {
                                                        elm = p_elm;
                                                    } else {
                                                        elm = document.getElementById(p_elm);
                                                    }
                                                    return parseInt(elm.offsetWidth);
                                                }
                                                this.getElementRight = getElementRight;
                                                function getElementRight() {
                                                    return getElementLeft(p_elm) + getElementWidth(p_elm);
                                                }
                                                this.getElementTop = getElementTop;
                                                function getElementTop() {
                                                    var y = 0;
                                                    var elm;
                                                    if (typeof (p_elm) == "object") {
                                                        elm = p_elm;
                                                    } else {
                                                        elm = document.getElementById(p_elm);
                                                    }
                                                    while (elm != null) {
                                                        y += elm.offsetTop;
                                                        elm = elm.offsetParent;
                                                    }
                                                    return parseInt(y);
                                                }
                                                this.getElementHeight = getElementHeight;
                                                function getElementHeight() {
                                                    var elm;
                                                    if (typeof (p_elm) == "object") {
                                                        elm = p_elm;
                                                    } else {
                                                        elm = document.getElementById(p_elm);
                                                    }
                                                    return parseInt(elm.offsetHeight);
                                                }
                                                this.getElementBottom = getElementBottom;
                                                function getElementBottom() {
                                                    return getElementTop(p_elm) + getElementHeight(p_elm);
                                                }
                                            }
                                            function CalendarControl() {
                                                var calendarId = 'CalendarControl';
                                                var currentYear = 0;
                                                var currentMonth = 0;
                                                var currentDay = 0;
                                                var selectedYear = 0;
                                                var selectedMonth = 0;
                                                var selectedDay = 0;
                                                var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                var dateField = null;
                                                function getProperty(p_property) {
                                                    var p_elm = calendarId;
                                                    var elm = null;
                                                    if (typeof (p_elm) == "object") {
                                                        elm = p_elm;
                                                    } else {
                                                        elm = document.getElementById(p_elm);
                                                    }
                                                    if (elm != null) {
                                                        if (elm.style) {
                                                            elm = elm.style;
                                                            if (elm[p_property]) {
                                                                return elm[p_property];
                                                            } else {
                                                                return null;
                                                            }
                                                        } else {
                                                            return null;
                                                        }
                                                    }
                                                }
                                                function setElementProperty(p_property, p_value, p_elmId) {
                                                    var p_elm = p_elmId;
                                                    var elm = null;
                                                    if (typeof (p_elm) == "object") {
                                                        elm = p_elm;
                                                    } else {
                                                        elm = document.getElementById(p_elm);
                                                    }
                                                    if ((elm != null) && (elm.style != null)) {
                                                        elm = elm.style;
                                                        elm[ p_property ] = p_value;
                                                    }
                                                }
                                                function setProperty(p_property, p_value) {
                                                    setElementProperty(p_property, p_value, calendarId);
                                                }
                                                function getDaysInMonth(year, month) {
                                                    return [31, ((!(year % 4) && ((year % 100) || !(year % 400))) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month - 1];
                                                }
                                                this.clearDate = clearDate;
                                                function clearDate() {
                                                    dateField.value = '';
                                                    dateField.focus();
                                                    hide();
                                                }
                                                this.setDate = setDate;
                                                function setDate(year, month, day) {
                                                    if (dateField) {
                                                        if (day < 10) {
                                                            day = "0" + day;
                                                        }
                                                        if (month < 10) {
                                                            month = "0" + month;
                                                            //                                                                            alert(month);
                                                        }
                                                        var dateString = month + "-" + year;
                                                        dateField.value = dateString;
                                                        dateField.focus();
                                                        dateField.value += '';
                                                        if (dateField.onchange != null)
                                                            __doPostBack(dateField.id, '');
                                                        hide();
                                                    }
                                                    return;
                                                }
                                                this.changeMonth = changeMonth;
                                                function changeMonth(change) {
                                                    currentMonth += change;
                                                    currentDay = 0;
                                                    if (currentMonth > 12) {
                                                        currentMonth = 1;
                                                        currentYear++;
                                                    } else if (currentMonth < 1) {
                                                        currentMonth = 12;
                                                        currentYear--;
                                                    }
                                                    calendar = document.getElementById(calendarId);
                                                    calendar.innerHTML = calendarDrawTable();
                                                }
                                                this.changeYear = changeYear;
                                                function changeYear(change) {
                                                    currentYear += change;
                                                    currentDay = 0;
                                                    calendar = document.getElementById(calendarId);
                                                    calendar.innerHTML = calendarDrawTable();
                                                }
                                                function getCurrentYear() {
                                                    var year = new Date().getYear();
                                                    if (year < 1900)
                                                        year += 1900;
                                                    return year;
                                                }
                                                function getCurrentMonth() {
                                                    return new Date().getMonth() + 1;
                                                }
                                                function getCurrentDay() {
                                                    return new Date().getDate();
                                                }
                                                function calendarDrawTable() {
                                                    var css_class = null;
                                                    var table = "<table cellspacing='0' cellpadding='0' border='0'>";
                                                    table = table + "<tr class='cal_header'>";
                                                    table = table + "  <td colspan='1' class='previous'><a href='javascript:changeCalendarControlYear(-1);'>&lt;</a></td>";
                                                    table = table + "  <td colspan='1' class='title'>" + currentYear + "</td>";
                                                    table = table + "  <td colspan='1' class='next'><a href='javascript:changeCalendarControlYear(1);'>&gt;</a></td>";
                                                    table = table + "</tr>";
                                                    var incm = 0;
                                                    for (var mon = 0; mon < 4; mon++) {
                                                        table += "<tr>";
                                                        for (var mon1 = 0; mon1 < 3; mon1++) {
                                                            if (currentMonth == incm + 1)
                                                                css_class = 'current';
                                                            else
                                                                css_class = 'weekday';
                                                            table += "<td><a href='javascript:;' onclick=\"javascript:setCalendarControlDate(" + currentYear + "," + (incm + 1) + ",1)\" class='" + css_class + "'>" + months[incm] + "</a></td>";
                                                            incm++;
                                                        }
                                                        table += "</tr>";
                                                    }
                                                    table = table + "<tr class='cl_header'><th colspan='3' style='padding: 3px;'><a href='javascript:;' onclick='javascript:clearCalendarControl();'>Clear</a> | <a href='javascript:;' onclick='javascript:hideCalendarControl();'>Close</a></td></tr>";
                                                    table = table + "</table>";
                                                    return table;
                                                }
                                                this.show = show;
                                                function show(field, xp, yp) {
                                                    can_hide = 0;
                                                    if (dateField == field) {
                                                        return;
                                                    } else {
                                                        dateField = field;
                                                    }
                                                    if (dateField) {
                                                        try {
                                                            var dateString = new String(dateField.value);
                                                            var dateParts = dateString.split("-");
                                                            selectedDay = 1;
                                                            selectedMonth = parseInt(dateParts[0], 10);
                                                            selectedYear = parseInt(dateParts[1], 10);
                                                        } catch (e) {
                                                        }
                                                    }
                                                    if (!(selectedYear && selectedMonth && selectedDay)) {
                                                        selectedDay = getCurrentDay();
                                                        selectedMonth = getCurrentMonth();
                                                        selectedYear = getCurrentYear();
                                                    }
                                                    currentDay = selectedDay;
                                                    currentMonth = selectedMonth;
                                                    currentYear = selectedYear;
                                                    if (document.getElementById) {
                                                        calendar = document.getElementById(calendarId);
                                                        calendar.innerHTML = calendarDrawTable(currentYear, currentMonth);
                                                        setProperty('display', 'block');
                                                        var fieldPos = new positionInfo(dateField);
                                                        var calendarPos = new positionInfo(calendarId);
                                                        if (xp == 0) {
                                                            var x = fieldPos.getElementLeft();
                                                        } else
                                                            var x = xp;
                                                        if (yp == 0)
                                                            var y = fieldPos.getElementBottom();
                                                        else
                                                            var y = yp;
                                                        setProperty('left', x + "px");
                                                        setProperty('top', y + "px");
                                                        if (document.all) {
                                                            setElementProperty('display', 'block', 'CalendarControlIFrame');
                                                            setElementProperty('left', x + "px", 'CalendarControlIFrame');
                                                            setElementProperty('top', y + "px", 'CalendarControlIFrame');
                                                            setElementProperty('width', calendarPos.getElementWidth() + "px", 'CalendarControlIFrame');
                                                            setElementProperty('height', calendarPos.getElementHeight() + "px", 'CalendarControlIFrame');
                                                        }
                                                    }
                                                    dateField.focus();
                                                }
                                                this.hide = hide;
                                                function hide() {
                                                    if (dateField) {
                                                        setProperty('display', 'none');
                                                        setElementProperty('display', 'none', 'CalendarControlIFrame');
                                                        dateField = null;
                                                    }
                                                }
                                                this.visible = visible;
                                                function visible() {
                                                    return dateField
                                                }
                                                this.can_hide = can_hide;
                                                var can_hide = 0;
                                            }
                                            var calendarControl = new CalendarControl();
                                            function showCalendarControl(textField, x, y) {
                                                if (!x) {
                                                    x = 0
                                                }
                                                if (!y) {
                                                    y = 0
                                                }
                                                var field = document.getElementById(textField);
                                                calendarControl.show(field, x, y);
                                            }
                                            function clearCalendarControl() {
                                                calendarControl.clearDate();
                                            }
                                            function hideCalendarControl() {
                                                if (calendarControl.visible()) {
                                                    calendarControl.hide();
                                                }
                                            }
                                            function setCalendarControlDate(year, month, day) {
                                                calendarControl.setDate(year, month, day);
                                            }
                                            function changeCalendarControlYear(change) {
                                                calendarControl.changeYear(change);
                                            }
                                            function changeCalendarControlMonth(change) {
                                                calendarControl.changeMonth(change);
                                            }
                                            document.write("<iframe  id='CalendarControlIFrame' src='javascript:false;document.open();document.write(\"\");document.close();' frameBorder='0' scrolling='no'></iframe>");
                                            document.write("<div id='CalendarControl'></div>");
                                            window.addEventListener('click', function (e) {
                                                var cal = document.getElementById('CalendarControl').contains(e.target);
                                                var month = document.getElementById('current_month').contains(e.target);
                                                if ((cal) || (month)) {

                                                } else {
                                                    hideCalendarControl();
                                                }
                                            })
        </script>
    </body>

</html>
