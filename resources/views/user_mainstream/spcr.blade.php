<div class="row justify-content-center">
	<div class="col-lg-5">
		<h2 class="font-weight-bold">SPCR TRACKING</h2>
	</div>

	<div class="col-lg-4 mt-3 px-0">
		<input class="form-control nav-item nav-link" type="text" name="" placeholder="Search..." ng-model="search_data_modality.$">   
	</div>

	<div class="col-lg-1">
		<button class="btn btn-block btn-danger mt-3"> <i class="fa fa-eraser"></i> </button>
	</div>
	
	<div class="col-lg-2">
		<button class="btn btn-primary btn-block mt-3" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#filter_modal" style="border-radius:50px !important;"> <i class="fa fa-filter"></i> Filters </button>
	</div>

	<div class="col-lg-12">
		<span style="font-style: italic;" ng-bind="'Total Filtered Subprojects: ' + bars.length" ng-cloak></span>
	</div>

	<div class="col-lg-12 my-2">
		<label class="text-muted"><small size="1"><span ng-if="spcr_list.from!=null" ng-bind="'Showing records '+spcr_list.from+'-'+spcr_list.to+' out of '+spcr_list.total"></span></small></label>
		<!-- <label class="text-muted"><small> Displaying 10 out of 1080 items </small></label> -->
		  <ul class="pagination">

		  	  <!-- Pag previous sa page  -->
			<li class="page-item disabled" ng-if="spcr_list.current_page == 1">
				<a style="text-transform: none;" class="page-link text-secondary" href="">Previous</a>
			</li>
			<li class="page-item" ng-if="spcr_list.current_page!=1" ng-click="Previous_Pagination(spcr_list.prev_page_url)"><a style="text-transform: none;" class="page-link text-secondary" href="">Previous</a></li>

			<!-- Pag adto sa first page -->
			<li class="page-item" ng-class="{'invisible' : spcr_list.current_page == 1 || spcr_list.current_page == 2 || spcr_list.current_page == 3 || spcr_list.last_page> 3 && spcr_list.last_page < 6}" ng-click="Skip_To_Page(spcr_list.path,1)">
			<a style="text-transform: none;" class="page-link text-secondary" href="">1</a>
			</li>

			<!-- Mag add ug (...) if ang current page is 4 pataas -->
			<li class="page-item disabled" ng-class="{'invisible' : spcr_list.current_page == 1 || spcr_list.current_page == 2 || spcr_list.current_page == 3 ||spcr_list.last_page>3&&spcr_list.last_page<6}">
				<a style="text-transform: none;" class="page-link text-secondary" href="">...</a>
			</li>   

			<!-- Number of Pages -->
			<li ng-repeat="x in [].constructor(spcr_list.last_page) track by $index" ng-click="Skip_To_Page(spcr_list.path,$index+1)">
				<a style="text-transform: none;" ng-class="{'bg-success active text-light': $index+1 == spcr_list.current_page, 'invisible' : spcr_list.current_page+1 < $index && $index > 5 || spcr_list.current_page - 5 >$index && $index <spcr_list.last_page-5}"  class="page-link text-secondary" href="" ng-bind="$index+1"></a>
			</li>

			<!-- Pag add ug (...) -->
			<li class="page-item disabled" ng-class="{'invisible' : spcr_list.current_page == spcr_list.last_page || spcr_list.current_page == spcr_list.last_page-1 || spcr_list.current_page == spcr_list.last_page-2||spcr_list.last_page>3&&spcr_list.last_page<6}">
			<a style="text-transform: none;" class="page-link text-secondary" href="">...</a>
			</li>

			<!-- Pag adto sa last page last page -->
			<li class="page-item" ng-class="{'invisible' : spcr_list.current_page == spcr_list.last_page || spcr_list.current_page == spcr_list.last_page-1 || spcr_list.current_page == spcr_list.last_page-2 || spcr_list.last_page>3&&spcr_list.last_page<6}" ng-click="Skip_To_Page(spcr_list.last_page)">
			<a style="text-transform: none;" class="page-link text-secondary" href="" ng-bind="spcr_list.last_page"></a>
			</li>

			<!-- Pag Next sa Pages -->
			<li class="page-item disabled">
				<a style="text-transform: none;" class="page-link text-secondary" href="" ng-if="spcr_list.current_page == spcr_list.last_page">Next</a>
			</li>
			<li class="page-item">
				<a style="text-transform: none;" class="page-link text-secondary" href="" ng-if="spcr_list.current_page != spcr_list.last_page" ng-click="Next_Pagination(spcr_list.next_page_url)">Next</a></li>
		  </ul>
	</div>

	<!-- Paginated -->
	<div class="col-lg-12">
        <div class="row">
            <div class="col font-weight-bold border-bottom border-top py-3">LAST UPDATE</div>
            <div class="col font-weight-bold border-bottom border-top py-3">SP ID</div>
            <div class="col font-weight-bold border-bottom border-top py-3">TITLE</div>
            <div class="col font-weight-bold border-bottom border-top py-3">PROVINCE</div>
            <div class="col font-weight-bold border-bottom border-top py-3">MUNICIPALITY</div>
            <div class="col font-weight-bold border-bottom border-top py-3">BARANGAY</div>
            <div class="col font-weight-bold border-bottom border-top py-3">MODALITY</div>
        </div>

        <div id="accordion">
        	@verbatim
			<div class="row py-2 border-bottom" ng-repeat="all_data in bars = (spcr_list.data | filter: search_data_modality.$) track by $index" data-toggle="collapse" data-target="#collapse{{all_data.sp_id}}" aria-expanded="true" aria-controls="collapse{{all_data.sp_id}}" style="cursor: pointer;">
				<div class="col small" ng-bind="all_data.updated_at | date:'short'">LAST UPDATE</div>
				<div class="col small" ng-bind="all_data.sp_id">SP ID</div>
				<div class="col small" ng-bind="all_data.sp_title">TITLE</div>
				<div class="col small" ng-bind="all_data.sp_province">PROVINCE</div>
				<div class="col small" ng-bind="all_data.sp_municipality">MUNICIPALITY</div>
				<div class="col small" ng-bind="all_data.sp_brgy">BARANGAY</div>
				<div class="col small">
					<span ng-if="all_data.sp_groupings == 1">KKB</span>
					<span ng-if="all_data.sp_groupings == 2">MAKILAHOK</span>
					<span ng-if="all_data.sp_groupings == 3">NCDDP</span>
					<span ng-if="all_data.sp_groupings == 4">IP CDD</span>
					<span ng-if="all_data.sp_groupings == 5">CCL</span>
					<span ng-if="all_data.sp_groupings == 6">L&E</span>
				</div>

				<div class="col-sm-12 collapse border-top pt-1" id="collapse{{all_data.sp_id}}" aria-labelledby="collapse{{all_data.sp_id}}" data-parent="#accordion">
					<div class="row">
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-12">
									<label><b>SRPMO</b></label>
									<p class="my-0 " ng-bind="all_data.received_srpmo | date:'medium'"></p>
									<label> <small> <b> Fidnings </b> </small> </label>
								</div>

								<div class="col-sm-12">
									<label><b>SRPMO Socials</b></label>
									<p class="my-0 " ng-bind="all_data.received_srpmo_socials | date:'medium'"></p>
									<label> <small> <b> Fidnings </b> </small> </label>
								</div>

								<div class="col-sm-12">
									<label><b>SRPMO Finance</b></label>
									<p class="my-0 " ng-bind="all_data.received_srpmo_finance | date:'medium'"></p>
									<label> <small> <b> Fidnings </b> </small> </label>
								</div>

								<div class="col-sm-12">
									<label><b>SRPMO Engineering</b></label>
									<p class="my-0 " ng-bind="all_data.received_srpmo_engineering | date:'medium'"></p>
									<label> <small> <b> Fidnings </b> </small> </label>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-12">
									<label><b>RPMO</b></label>
									<p class="my-0 " ng-bind="all_data.received_rpmo | date:'medium'"></p>
								</div>

								<div class="col-sm-12">
									<label><b>RPMO Socials</b></label>
									<p class="my-0 " ng-bind="all_data.received_socials | date:'medium'"></p>
								</div>

								<div class="col-sm-12">
									<label><b>RPMO Finance</b></label>
									<p class="my-0 " ng-bind="all_data.received_finance | date:'medium'"></p>
								</div>

								<div class="col-sm-12">
									<label><b>RPMO Engineering</b></label>
									<p class="my-0 " ng-bind="all_data.received_engineering | date:'medium'"></p>
								</div>
							</div>
						</div>
					</div>
				</div>
<!-- 				<div class="card">
				    <div class="card-header" id="headingOne">
						<h5 class="mb-0">
						<button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{all_data.sp_id}}" aria-expanded="true" aria-controls="collapse{{all_data.sp_id}}">
						{{all_data.sp_id}}
						</button>
						
						</h5>
				    </div>

				    <div id="collapse{{all_data.sp_id}}" class="collapse show" aria-labelledby="collapse{{all_data.sp_id}}" data-parent=".accordion">
						<div class="card-body">

						</div>
				    </div>
				</div> -->
			</div>
			@endverbatim
        </div>  
	</div>
</div>
