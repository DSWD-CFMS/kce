<style type="text/css">
	.pulsate {
	    -webkit-animation: pulsate 3s ease-out;
	    -webkit-animation-iteration-count: infinite; 
	    opacity: 0.5;
	}
	@-webkit-keyframes pulsate {
	    0% { 
	        opacity: 0.5;
		    color: #dc3545;
	    }
	    50% { 
	        opacity: 1.0;
		    color: #e6505f;
	    }
	    100% { 
	        opacity: 0.5;
	    	color: #e26f7b;
	    }
	}

	.text-label-blue{
		color: #007bff !important;
	}

	.table-bordered1 tr {
	  border-top: .1px solid #000 !important;
	}

	tr {
	  display:flex;
	  flex-wrap:wrap; /* allow to wrap on multiple rows */
	}
	td,th {
	  display:block;
	  flex:1 /* to evenly distributs flex elements */
	}

	.collapsed_td {
	  width:100%; /* fill entire width,row */
	  flex:auto; /* reset the flex properti to allow width take over */
	}

</style>
<div class="row wrapper border-bottom white-bg page-heading justify-content-end animated fadeInRight" ng-init="show_profile()">
	<div class="col-lg-8">
	  <h2> Modality </h2>
	  <ol class="breadcrumb">
	      <li class="breadcrumb-item">
	        <a href="{{ url('/dac/routes') }}" >Dashboard</a>
	      </li>
	      <li class="breadcrumb-item">
	          <strong> Modality </strong>
	      </li>
	  </ol>
	</div>

	<div class="col-lg-4" style="margin-top: 40px;">
		<div class="input-group">
			<div class="input-group-prepend">
			  <a class="btn btn-outline-secondary rounded-0" href="{{ url('/dac/routes/show_modality') }}"> <i class="fa fa-refresh"></i> </a>
			</div>
			<input class="form-control nav-item nav-link" style="border: 1px solid;" type="text" name="" placeholder="Search..." ng-model="search_data_modality.$" ng-change="hideCollapse()">
		</div>
	</div>
</div>
@include('user_dac.subprojects')