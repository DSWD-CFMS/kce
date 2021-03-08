    <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/js/lightbox/lightbox.css') }}" rel="stylesheet">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                @if(\Session::has('error'))
                <h1 class="text-danger" style="margin-top: 100px;">
                    {{\Session::get('error')}}
                </h1>
                <h4 class="text-secondary"> You are unauthorize to access this page. Please be advised that you will be redicrected to your assigned route in <span id="countdown">5</span> seconds</h4>

                <p style="font-size: 130px;">
                    <i class="fa fa-qrcode fa-5x"></i>
                </p>
                    @if(Auth()->user()->role == 'ADMIN')
                    <script type="text/javascript">
                        // Total seconds to wait
                        var seconds = 5;
                        
                        function countdown() {
                            seconds = seconds - 1;
                            if (seconds < 0) {
                                // Chnage your redirection link here
                                window.location.href="/"+"admin/routes";
                            } else {
                                // Update remaining seconds
                                document.getElementById("countdown").innerHTML = seconds;
                                // Count down using javascript
                                window.setTimeout("countdown()", 1000);
                            }
                        }
                        
                        // Run countdown function
                        countdown();
                    </script>
                    @elseif(Auth::user()->role == 'RPMO')
                    <script type="text/javascript">
                        // Total seconds to wait
                        var seconds = 5;
                        
                        function countdown() {
                            seconds = seconds - 1;
                            if (seconds < 0) {
                                // Chnage your redirection link here
                                window.location.href="/"+"rpmo/routes";
                            } else {
                                // Update remaining seconds
                                document.getElementById("countdown").innerHTML = seconds;
                                // Count down using javascript
                                window.setTimeout("countdown()", 1000);
                            }
                        }
                        
                        // Run countdown function
                        countdown();

                        // window.location.href="/"+"rpmo/routes";
                    </script>
                    @elseif(Auth::user()->role == 'DAC')
                    <script type="text/javascript">
                        // Total seconds to wait
                        var seconds = 5;
                        
                        function countdown() {
                            seconds = seconds - 1;
                            if (seconds < 0) {
                                // Chnage your redirection link here
                                window.location.href="/"+"dac/routes";
                            } else {
                                // Update remaining seconds
                                document.getElementById("countdown").innerHTML = seconds;
                                // Count down using javascript
                                window.setTimeout("countdown()", 1000);
                            }
                        }
                        
                        // Run countdown function
                        countdown();
                    </script>
                    @elseif(Auth::user()->role=='ADMIN_RCIS' || Auth::user()->role=='RFA' || Auth::user()->role=='RPO' || Auth::user()->role=='RMES' || Auth::user()->role=='RCBS' || Auth::user()->role=='RCDS')
                    <script type="text/javascript">
                        // Total seconds to wait
                        var seconds = 5;
                        
                        function countdown() {
                            seconds = seconds - 1;
                            if (seconds < 0) {
                                // Chnage your redirection link here
                                window.location.href="/"+"admin_rcis/routes";
                            } else {
                                // Update remaining seconds
                                document.getElementById("countdown").innerHTML = seconds;
                                // Count down using javascript
                                window.setTimeout("countdown()", 1000);
                            }
                        }
                        
                        // Run countdown function
                        countdown();
                    </script>
                    @elseif(Auth::user()->role == 'MAINSTREAM')
                    <script type="text/javascript">
                        // Total seconds to wait
                        var seconds = 5;
                        
                        function countdown() {
                            seconds = seconds - 1;
                            if (seconds < 0) {
                                // Chnage your redirection link here
                                window.location.href="/"+"mainstream/routes";
                            } else {
                                // Update remaining seconds
                                document.getElementById("countdown").innerHTML = seconds;
                                // Count down using javascript
                                window.setTimeout("countdown()", 1000);
                            }
                        }
                        
                        // Run countdown function
                        countdown();
                    </script>
                    @elseif(Auth::user()->role == 'PROCUREMENT')
                    <script type="text/javascript">
                        // Total seconds to wait
                        var seconds = 5;
                        
                        function countdown() {
                            seconds = seconds - 1;
                            if (seconds < 0) {
                                // Chnage your redirection link here
                                window.location.href="/"+"procurement/routes";
                            } else {
                                // Update remaining seconds
                                document.getElementById("countdown").innerHTML = seconds;
                                // Count down using javascript
                                window.setTimeout("countdown()", 1000);
                            }
                        }
                        
                        // Run countdown function
                        countdown();
                    </script>
                    @else
                    @endif

                @else
                    @if(Auth()->user()->role == 'ADMIN')
                    <script type="text/javascript">
                        window.location.href="/"+"admin/routes";
                    </script>
                    @elseif(Auth::user()->role == 'RPMO')
                    <script type="text/javascript">
                        window.location.href="/"+"rpmo/routes";
                    </script>
                    @elseif(Auth::user()->role == 'DAC')
                    <script type="text/javascript">
                        window.location.href="/"+"dac/routes";
                    </script>
                    @elseif(Auth::user()->role == 'ADMIN_RCIS')
                    <script type="text/javascript">
                        window.location.href="/"+"admin_rcis/routes";
                    </script>
                    @elseif(Auth::user()->role == 'MAINSTREAM')
                    <script type="text/javascript">
                        window.location.href="/"+"mainstream/routes";
                    </script>
                    @elseif(Auth::user()->role == 'PROCUREMENT')
                    <script type="text/javascript">
                        window.location.href="/"+"procurement/routes";
                    </script>
                    @else
                    @endif
                    
                @endif

            </div>
        </div>
    </div>
<script type="text/javascript" src="{{ asset('/js/jquery/jquery-3.4.1.js') }}"></script>
<script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}" defer></script>
<script type="text/javascript" src="{{ asset('/js/lightbox/lightbox.min.js') }}"></script>