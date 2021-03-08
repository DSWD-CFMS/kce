@extends('layouts.rpmo_nav')

@section('content')
<style type="text/css">
  .card, .card .card-footer{
    border-radius: 0px;
  }

  .orange{
    color: #fdab14;
  }

/*uploads css*/
input[type=file] {
  cursor: pointer;
  width: 100%;
  height: 42px;
  overflow: hidden;
  color:transparent;
}

input[type=file]:before {
  width: 100%;
  height: 42px;
  font-size: 16px;
  color:#007bff;
  line-height: 32px;
  content: 'Select files to be uploaded';
  display: inline-block;
  background: white;
  border: 2px solid #007bff;
  border-radius: 26px;
  text-align: center;
  font-family: Helvetica, Arial, sans-serif;
}

input[type=file]::-webkit-file-upload-button {
  visibility: hidden !important;
}

.bd-placeholder-img{
  object-fit: cover;
}
</style>

<div id="page-wrapper" class="gray-bg dashbard-1">
  <div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">
          <a class="navbar-minimalize minimalize-styl-2 py-0 text-secondary" style="text-transform: none !important; text-decoration: none !important; border-radius: 100px;" href="" ng-click="mini_navbar = !mini_navbar">
            
            <i ng-class="{'fa fa-chevron-circle-right fa-2x': mini_navbar == true, 'fa fa-chevron-circle-left fa-2x': mini_navbar == false}"></i>
          </a>
          <h4 class="minimalize-styl-2 mx-0 px-0 pb-0 mb-0" href="#">
            KCE WebApp v2.0
          </h4>
      </div>
      <ul class="nav navbar-top-links navbar-right">
          <li>
              <a href="#exampleModal" data-toggle="modal">
                  <i class="fa fa-sign-out"></i> Sign out
              </a>
          </li>
      </ul>
    </nav>
  </div>
  
  <!-- Render tanan contents -->
  <div ng-view></div>
</div>

<div class="modal inmodal fade" id="exampleModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header py-2 px-3">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
      		<div class="modal-body">
        		<p class="modal-title" id="exampleModalLabel">Ready to Leave?</p>
      			<h5>
      				Select "Sign out" below if you are ready to end your current session.
      			</h5>
      		</div>
	      <div class="modal-footer">
			<button class="btn btn-white" type="button" data-dismiss="modal">Cancel</button>
	        <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Sign out</a>
	    	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	      		@csrf
	    	</form>
	      </div>
        </div>
    </div>
</div>
@include('user_rpmo.reports_modal')
@endsection