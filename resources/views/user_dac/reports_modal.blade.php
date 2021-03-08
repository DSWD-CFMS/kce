<div class="modal fade" id="filter_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header px-5" style="border-bottom: none !important;">
      	<h5 class="modal-title">Search filters</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="fa fa-times"></i>
        </button>
      </div>
      <div class="modal-body px-5">
      	  <div class="form-group">
				<label><small class="font-weight-bold text-secondary"> Modality </small></label>
				<select class="custom-select" id="modality">
					<option value="KKB" selected>KKB</option>
					<option value="MAKILAHOK">MAKILAHOK</option>
					<option value="NCDDP">NCDDP</option>
					<option value="IP CDD">IP CDD</option>
					<option value="CCL">CCL</option>
					<option value="L&E">L&E</option>
				</select>
			</div>
			
			<div class="form-group">
				<label><small class="font-weight-bold text-secondary"> Year </small></label>
				<select class="custom-select" id="year">
					<option value="2014" selected> 2014 </option>
					<option value="2015"> 2015 </option>
					<option value="2016"> 2016 </option>
					<option value="2017"> 2017 </option>
					<option value="2018"> 2018 </option>
					<option value="2019"> 2019 </option>
					<option value="2020"> 2020 </option>
				</select>
			</div>
			
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label><small class="font-weight-bold text-secondary"> Cycle </small></label>
						<select class="custom-select" id="cycle">
							<option value="1" selected> 1 </option>
							<option value="2"> 2 </option>
							<option value="3"> 3 </option>
							<option value="4"> 4 </option>
							<option value="5"> 5 </option>
						</select>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label><small class="font-weight-bold text-secondary"> Batch </small></label>
						<select class="custom-select" id="batch">
							<option value="1" selected> 1 </option>
							<option value="2"> 2 </option>
							<option value="3"> 3 </option>
							<option value="4"> 4 </option>
							<option value="5"> 5 </option>
						</select>
					</div>
				</div>

			

			</div>
			
			<div class="form-group">
				<label><small class="font-weight-bold text-secondary"> Province </small></label>
				<select class="custom-select" ng-model="province_data" ng-options="prov_data.name for prov_data in reg" ng-change="fetch_municipality(province_data.prov_code)">
				</select>
			</div>
			
			<div class="form-group">
				<label><small class="font-weight-bold text-secondary"> Municipality </small></label>
				<select class="custom-select" ng-model="municipality_data" ng-options="muni_data.name for muni_data in muni" ng-change="fetch_brgy(municipality_data.mun_code)">
				</select>
			</div>
			
			<div class="form-group">
				<label><small class="font-weight-bold text-secondary"> Brgy </small></label>
				<select class="custom-select" ng-model="brgy_data" ng-options="b_data.name for b_data in brgy">
				</select>
			</div>

			<div class="form-group">
				<label><small class="font-weight-bold text-secondary"> SP Title </small></label>
				<input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Ex. FISH CAGE CULTURE...">
			</div>

			<div class="form-group">
				<label><small class="font-weight-bold text-secondary"> SP ID </small></label>
				<input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Ex. 201804000...">
			</div>

		  </div>
		<div class="modal-footer">
        	<button type="button" class="btn btn-primary btn-block btn-lg" data-dismiss="modal" style="border-radius:50px !important;"> <i class="fa fa-gears"></i> Generate Report</button>
      	</div>
      </div>
    </div>
  </div>
</div>




<!--  REPORTS MODAL  -->