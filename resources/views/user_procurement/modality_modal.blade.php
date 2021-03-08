<style type="text/css">
	.modal .modal-content, .modal .modal-header, .modal .modal-footer{
	  border-radius: 0px !important;
	}

	.modal-body{
		padding: 16px !important;
	}
</style>

<!-- Modal -->
<div class="modal fade" id="modality_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg rounded-0" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<!-- SP TITLE -->
        <h5 class="modal-title" id="exampleModalLabel"> <span ng-bind="specific_sp_data.sp[0].sp_title"></span> <br>
        	<span class="font-weight-light" style="font-size: 18px;">SP ID:</span> <span class="font-weight-light text-primary" style="font-size: 18px;" ng-bind="specific_sp_data.sp[0].sp_id"> </span>
        </h5>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-lg-12">
        		<p>Last updated on: Monday Sept 28, 2019</p>
      		</div>

      		<div class="col-lg-6">
				<small> <b>Groupings</b> </small>
        		<p>
        			<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 1">
        				KKB
        			</span>

        			<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 2">
        				MAKILAHOK
        			</span>

        			<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 3">
        				NCDDP
        			</span>

        			<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 4">
        				IP CDD
        			</span>

        			<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 5">
        				CCL
        			</spa n>

        			<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 6">
        				L&E
        			</span>
        		</p>

				<small> <b>Province</b> </small>
        		<p ng-bind="specific_sp_data.sp[0].sp_province">SURIGAO DEL SUR</p>
        		
				<small> <b>Municipality</b> </small>
        		<p ng-bind="specific_sp_data.sp[0].sp_municipality">Marihatag</p>
        		
				<small> <b>Barangay</b> </small>
        		<p ng-bind="specific_sp_data.sp[0].sp_brgy">AMONTAY</p>
        		
				<small> <b>RFR 1st Tranch Date Downloaded	</b> </small>
        		<p ng-bind="specific_sp_data.sp[0].sp_rfr_first_tranche_date | date:'fullDate'">0000-00-00</p>
      		</div>

      		<div class="col-lg-6">
				<small> <b>Sp Category</b> </small>
        		<p ng-bind="specific_sp_data.sp[0].sp_category.category">Enterprise</p>

				<small> <b>Sp Type</b> </small>
        		<p ng-bind="specific_sp_data.sp[0].sp_type.type">Others</p>

				<small> <b>Physical target</b> </small>
        		<p ng-bind="specific_sp_data.sp[0].sp_physical_target">Others</p>

				<small> <b>Total Project Cost</b> </small>
        		<p ng-bind="specific_sp_data.sp[0].sp_project_cost | currency:'₱'">Others</p>

				<small> <b>Building Permit</b> </small> <br>
        		<p ng-if="update_sp_data == false && specific_sp_data.sp[0].sp_building_permit == 0">
        			<span>NOT APPLICABLE</span>
        		</p>
        		<a ng-if="update_sp_data == false && specific_sp_data.sp[0].sp_building_permit != 0" href="" >Click here to download</a>
				<div class="custom-file-container" data-upload-id="buildingpermit_id" ng-show="update_sp_data == true" ng-cloak>
				    <label>Upload File <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">&times;</a></label>
				    <label class="custom-file-container__custom-file" >
				        <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" multiple aria-label="Choose File">
				        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
				        <span class="custom-file-container__custom-file__custom-file-control"></span>
				    </label>
				    <div class="custom-file-container__image-preview"></div>
				</div>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<div class="row">
      				<div class="col-lg-4">
						<small> <b>Date started</b> </small>
        				<p ng-bind="specific_sp_data.sp[0].sp_date_started | date:'fullDate'">0000-00-00</p>
      				</div>
      				<div class="col-lg-4">
						<small> <b>Estimated duration</b> </small>
        				<p ng-bind="(specific_sp_data.sp[0].sp_estimated_duration) + ' Days'"></p>
      				</div>
      				<div class="col-lg-4">
						<small> <b>Target date of completion</b> </small>
        				<p ng-bind="specific_sp_data.sp[0].sp_target_date_of_completion | date:'fullDate'">0000-00-00</p>
      				</div>
      				<div class="col-lg-4">
						<small> <b>Days suspended</b> </small>
						<p ng-bind="(specific_sp_data.sp[0].sp_days_suspended) + ' Days'"></p>
      				</div>
      				<div class="col-lg-4">
						<small> <b>Actual date completed</b> </small>
        				<p ng-bind="specific_sp_data.sp[0].sp_actual_date_completed | date:'fullDate'">0000-00-00</p>
      				</div>
      				<div class="col-lg-4">
						<small> <b>Date of turn over</b> </small>
        				<p ng-bind="specific_sp_data.sp[0].sp_date_of_turnover | date:'fullDate'">0000-00-00</p>
      				</div>
      			</div>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<div class="row">
					<div class="col-lg-4" ng-if="update_sp_data == false" ng-cloak>
						<small> <b>Planned</b> </small>
              			<div ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
							<span ng-show="$last" ng-bind="(logs_planned.sp_logs_planned) +'%'"></span>
              			</div>
		      		</div>
					
					<div class="col-lg-4" ng-show="update_sp_data == true" ng-cloak>
						<div class="form-group">
							<label><small> <b>Planned</b> </small></label>
							<input type="text" class="form-control">
						</div>
					</div>
					
					<div class="col-lg-4" ng-if="update_sp_data == false" ng-cloak>
						<small> <b>Actual</b> </small>
              			<div ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
							<span ng-show="$last" ng-bind="(logs_planned.sp_logs_actual) +'%'"></span>
              			</div>
		      		</div>

					<div class="col-lg-4" ng-show="update_sp_data == true" ng-cloak>
						<div class="form-group">
							<label><small> <b>Actual</b> </small></label>
							<input type="text" class="form-control">
						</div>
					</div>

					<div class="col-lg-4" ng-if="update_sp_data == false" ng-cloak>
						<small> <b>Slippage</b> </small>
              			<div ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
							<span ng-show="$last" ng-bind="(logs_planned.sp_logs_slippage) +'%'"></span>
              			</div>
		      		</div>

					<div class="col-lg-4" ng-show="update_sp_data == true" ng-cloak>
						<div class="form-group">
							<label><small> <b>Slippage</b> </small></label>
							<input type="text" class="form-control" disabled>
						</div>
					</div>

      			</div>
      			<hr>
      		</div>


      		<div class="col-lg-6">
				<small> <b>Variation order</b> </small>
      			<div ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
					<span ng-if="logs_planned.sp_logs_variation_order != ''" ng-show="$last" ng-bind="logs_planned.sp_logs_variation_order"></span>
					<span ng-if="logs_planned.sp_logs_variation_order == '' || logs_planned.sp_logs_variation_order == null" ng-show="$last">NOT APPLICABLE</span>
      			</div>
      		</div>

      		<div class="col-lg-6">
				<small> <b>Fullblown Proposal</b> </small>
				<br>
				<a href="" ng-if="specific_sp_data.sp[0].sp_fullblown_proposal == 1">Click here to download</a>
				<p ng-if="!specific_sp_data.sp[0].sp_fullblown_proposal"> NOT APPLICABLE </p>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<div class="row">

					<div class="col-lg-4">
						<small> <b>ESMR</b> </small> <br>
						<div ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
							<span ng-if="logs_planned.sp_logs_esmr != 0" ng-show="$last" ng-bind="logs_planned.sp_logs_esmr"></span>
							<a href="" ng-show="$last" ng-if="logs_planned.sp_logs_esmr == 0 || logs_planned.sp_logs_esmr == null">Click here to download</a>
              			</div>
						<!-- <img src="{{ asset('images/sample.jpg') }}" style="width: 70px;height: 70px;object-fit: cover; border-radius: 15px;" ng-if="update_sp_data == false" ng-cloak> -->
						<div class="custom-file-container" data-upload-id="esmr_id" ng-show="update_sp_data == true" ng-cloak>
						    <label>Upload File <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">&times;</a></label>
						    <label class="custom-file-container__custom-file" >
						        <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" multiple aria-label="Choose File">
						        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
						        <span class="custom-file-container__custom-file__custom-file-control"></span>
						    </label>
						    <div class="custom-file-container__image-preview"></div>
						</div>
		      		</div>

					<div class="col-lg-4">
						<small> <b>SPCR</b> </small> <br>
						<div ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
							<span ng-if="logs_planned.sp_logs_spcr != 0" ng-show="$last" ng-bind="logs_planned.sp_logs_spcr"></span>
							<a href="" ng-show="$last" ng-if="logs_planned.sp_logs_spcr == 0 || logs_planned.sp_logs_spcr == null">Click here to download</a>
              			</div>
						<!-- <img src="{{ asset('images/sample.jpg') }}" style="width: 70px;height: 70px;object-fit: cover; border-radius: 15px;" ng-if="update_sp_data == false" ng-cloak> -->
						<div class="custom-file-container" data-upload-id="spcr_id" ng-show="update_sp_data == true" ng-cloak>
						    <label>Upload File <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">&times;</a></label>
						    <label class="custom-file-container__custom-file" >
						        <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" multiple aria-label="Choose File" >
						        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
						        <span class="custom-file-container__custom-file__custom-file-control"></span>
						    </label>
						    <div class="custom-file-container__image-preview"></div>
						</div>
		      		</div>

					<div class="col-lg-4">
						<small> <b>CSR</b> </small> <br>
						<div ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
							<span ng-if="logs_planned.sp_logs_csr != 0" ng-show="$last" ng-bind="logs_planned.sp_logs_csr"></span>
							<a href="" ng-show="$last" ng-if="logs_planned.sp_logs_csr == 0 || logs_planned.sp_logs_csr == null">Click here to download</a>
              			</div>
						<div class="custom-file-container" data-upload-id="csr_id" ng-show="update_sp_data == true" ng-cloak>
						    <label>Upload File <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">&times;</a></label>
						    <label class="custom-file-container__custom-file" >
						        <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" multiple aria-label="Choose File" ng-model="Upload_files" onchange="angular.element(this).scope().fileChanged(this)">
						        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
						        <span class="custom-file-container__custom-file__custom-file-control"></span>
						    </label>
						    <div class="custom-file-container__image-preview"></div>
						</div>
		      		</div>
      			</div>
      		</div>

      		<div class="col-lg-12">
      			<hr>
				<small> <b> Issues/Problem Encountered </b> </small>
        		<p ng-if="update_sp_data == false" ng-cloak>
          			<div ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
						<span ng-show="$last" ng-if="logs_planned.sp_logs_issues != null" ng-bind="logs_planned.sp_logs_issues"></span>
						<p ng-show="$last" ng-if="logs_planned.sp_logs_issues == null">NOT APPLICABLE</p>
          			</div>
        		</p>
        		<textarea class="form-control text_area" id="msg" rows="8" maxlength="255" style="resize: NOT APPLICABLE;overflow-x: auto;" ng-if="update_sp_data == true"></textarea>
        		<br>
      		</div>

			<div class="col-lg-12">
				<small> <b> Analysis </b> </small>
        		<p ng-if="update_sp_data == false" ng-cloak>
          			<div ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
						<span ng-show="$last" ng-if="logs_planned.sp_logs_analysis != null" ng-bind="logs_planned.sp_logs_analysis"></span>
						<p ng-show="$last" ng-if="logs_planned.sp_logs_analysis == null">NOT APPLICABLE</p>
          			</div>
        		</p>
        		<textarea class="form-control text_area" id="msg" rows="8" maxlength="255" style="resize: NOT APPLICABLE;overflow-x: auto;" ng-if="update_sp_data == true"></textarea>
        		<br>
      		</div>

			<div class="col-lg-12">
				<small> <b> Remarks </b> </small>
        		<p ng-if="update_sp_data == false" ng-cloak>
          			<div ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
						<span ng-show="$last" ng-if="logs_planned.sp_logs_remarks != null" ng-bind="logs_planned.sp_logs_remarks"></span>
						<p ng-show="$last" ng-if="logs_planned.sp_logs_remarks == null">NOT APPLICABLE</p>
          			</div>
        		</p>
        		<textarea class="form-control text_area" id="msg" rows="8" maxlength="255" style="resize: NOT APPLICABLE;overflow-x: auto;" ng-if="update_sp_data == true"></textarea>
        		<br>
      		</div>
      	</div>

      	<!-- EDIT INPUTS -->
		<!-- 		
      		<div class="col-lg-6">
				<small> <b>Sp Category</b> </small>
				<select class="custom-select mb-2" id="spcategory">
					<option value="0" selected> Choose... </option>
					<option value="1"> Public Goods </option>
					<option value="2"> Environmental Protection and Conservation </option>
					<option value="3"> Enterprise </option>
					<option value="4"> Human Resource Development </option>
				</select>

				<br>
				
				<small> <b>Sp Type</b> </small>
				<select class="custom-select mb-2" id="spcategory">
					<option value="0" selected> Choose... </option>
					<option value="1"> protection dike </option>
					<option value="2"> river dike </option>
					<option value="3"> stairway </option>
					<option value="4"> wharf </option>
					<option value="5"> rice mill </option>
					<option value="6"> riverbank </option>
					<option value="7"> latrine </option>
					<option value="8"> learning center </option>
					<option value="9"> multi purpose building </option>
					<option value="10"> water system </option>
					<option value="11"> roads </option>
					<option value="12"> drainage </option>
					<option value="13"> pathway </option>
					<option value="14"> school building </option>
					<option value="15"> tribal center </option>
					<option value="16"> bhs </option>
					<option value="17"> dcc </option>
					<option value="18"> culverts </option>
					<option value="19"> footbridge </option>
					<option value="20"> spsl </option>
					<option value="21"> epsl </option>
					<option value="22"> solar dryer </option>
					<option value="23"> rain water harvester </option>
					<option value="24"> bridges </option>
					<option value="25"> slope protection </option>
					<option value="26"> flood control </option>
					<option value="27"> sea wall </option>
					<option value="28"> evacuation center </option>
					<option value="29"> riverbank </option>
					<option value="30"> others </option>
				</select>
      	</div> -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal"> <i class="fa fa-list-alt"></i> View Track History</button>
        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal"> <i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>
<!-- REPORTS MODAL -->

<!-- Completed -->
<div class="modal fade" id="reports_modality_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md rounded-0" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span ng-bind="specific_sp_data.sp_title"></span> <br>
        	<span class="font-weight-light">SP ID:</span> <span class="font-weight-light text-primary" ng-bind="specific_sp_data.sp_id"> </span>
        </h5>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-lg-12">
        		<p>Last updated on: Monday Sept 28, 2019</p>
      		</div>

      		<div class="col-lg-6">
				<small> <b>Groupings</b> </small>
        		<p>
        			<span ng-if="specific_sp_data.sp_groupings.id == 1">
        				KKB
        			</span>

        			<span ng-if="specific_sp_data.sp_groupings.id == 2">
        				MAKILAHOK
        			</span>

        			<span ng-if="specific_sp_data.sp_groupings.id == 3">
        				NCDDP
        			</span>

        			<span ng-if="specific_sp_data.sp_groupings.id == 4">
        				IP CDD
        			</span>

        			<span ng-if="specific_sp_data.sp_groupings.id == 5">
        				CCL
        			</span>

        			<span ng-if="specific_sp_data.sp_groupings.id == 6">
        				L&E
        			</span>
        		</p>

				<small> <b>Province</b> </small>
        		<p ng-bind="specific_sp_data.sp_province">SURIGAO DEL SUR</p>
        		
				<small> <b>Municipality</b> </small>
        		<p ng-bind="specific_sp_data.sp_municipality">Marihatag</p>
        		
				<small> <b>Barangay</b> </small>
        		<p ng-bind="specific_sp_data.sp_brgy">AMONTAY</p>
        		
				<small> <b>RFR 1st Tranch Date Downloaded	</b> </small>
        		<p ng-bind="specific_sp_data.sp_rfr_first_tranche_date | date:'fullDate'">0000-00-00</p>
      		</div>

      		<div class="col-lg-6">
				<small> <b>Sp Category</b> </small>
        		<p ng-bind="specific_sp_data.sp_category.category">Enterprise</p>

				<small> <b>Sp Type</b> </small>
        		<p ng-bind="specific_sp_data.sp_type.type">Others</p>

				<small> <b>Physical target</b> </small>
        		<p ng-bind="specific_sp_data.sp_physical_target">Others</p>

				<small> <b>Total Project Cost</b> </small>
        		<p ng-bind="specific_sp_data.sp_project_cost | currency:'₱'">Others</p>

				<small> <b>Building Permit</b> </small> <br>
        		<p ng-if="update_sp_data == false && specific_sp_data.sp_building_permit == 0">
        			<span>NOT APPLICABLE</span>
        		</p>
        		<a ng-if="update_sp_data == false && specific_sp_data.sp_building_permit != 0" href="" >Click here to download</a>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<div class="row">
      				<div class="col-lg-4">
						<small> <b>Date started</b> </small>
        				<p ng-bind="specific_sp_data.sp_date_started | date:'fullDate'">0000-00-00</p>
      				</div>
      				<div class="col-lg-4">
						<small> <b>Estimated duration</b> </small>
        				<p ng-bind="specific_sp_data.sp_estimated_duration"></p>
      				</div>
      				<div class="col-lg-4">
						<small> <b>Target date of completion</b> </small>
        				<p ng-bind="specific_sp_data.sp_target_date_of_completion | date:'fullDate'">0000-00-00</p>
      				</div>
      				<div class="col-lg-4">
						<small> <b>Days suspended</b> </small>
						<p ng-bind="(specific_sp_data.sp_days_suspended) + ' Days'"></p>
      				</div>
      				<div class="col-lg-4">
						<small> <b>Actual date completed</b> </small>
        				<p ng-bind="specific_sp_data.sp_actual_date_completed | date:'fullDate'">0000-00-00</p>
      				</div>
      				<div class="col-lg-4">
						<small> <b>Date of turn over</b> </small>
        				<p ng-bind="specific_sp_data.sp_date_of_turnover | date:'fullDate'">0000-00-00</p>
      				</div>
      			</div>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<div class="row">

					<div class="col-lg-4" ng-if="update_sp_data == false" ng-cloak>
						<small> <b>Planned</b> </small>
              			<div ng-repeat="logs_planned in specific_sp_data.sp_logs track by $index">
							<span ng-show="$last" ng-bind="logs_planned.sp_logs_planned"></span>
              			</div>
		      		</div>
					
					<div class="col-lg-4" ng-show="update_sp_data == true" ng-cloak>
						<div class="form-group">
							<label><small> <b>Planned</b> </small></label>
							<input type="text" class="form-control">
						</div>
					</div>
					
					<div class="col-lg-4" ng-if="update_sp_data == false" ng-cloak>
						<small> <b>Actual</b> </small>
              			<div ng-repeat="logs_planned in specific_sp_data.sp_logs track by $index">
							<span ng-show="$last" ng-bind="logs_planned.sp_logs_actual"></span>
              			</div>
		      		</div>

					<div class="col-lg-4" ng-show="update_sp_data == true" ng-cloak>
						<div class="form-group">
							<label><small> <b>Actual</b> </small></label>
							<input type="text" class="form-control">
						</div>
					</div>

					<div class="col-lg-4" ng-if="update_sp_data == false" ng-cloak>
						<small> <b>Slippage</b> </small>
              			<div ng-repeat="logs_planned in specific_sp_data.sp_logs track by $index">
							<span ng-show="$last" ng-bind="logs_planned.sp_logs_slippage"></span>
              			</div>
		      		</div>

					<div class="col-lg-4" ng-show="update_sp_data == true" ng-cloak>
						<div class="form-group">
							<label><small> <b>Slippage</b> </small></label>
							<input type="text" class="form-control" disabled>
						</div>
					</div>

      			</div>
      			<hr>
      		</div>


      		<div class="col-lg-6">
				<small> <b>Variation order</b> </small>
      			<div ng-repeat="logs_planned in specific_sp_data.sp_logs track by $index">
					<span ng-if="logs_planned.sp_logs_variation_order != ''" ng-show="$last" ng-bind="logs_planned.sp_logs_variation_order"></span>
					<span ng-if="logs_planned.sp_logs_variation_order == '' || logs_planned.sp_logs_variation_order == null" ng-show="$last">NOT APPLICABLE</span>
      			</div>
      		</div>

      		<div class="col-lg-6">
				<small> <b>Fullblown Proposal</b> </small>
				<br>
				<a href="" ng-if="specific_sp_data.sp_fullblown_proposal == 1">Click here to download</a>
				<p ng-if="!specific_sp_data.sp_fullblown_proposal"> NOT APPLICABLE </p>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<div class="row">

					<div class="col-lg-4">
						<small> <b>ESMR</b> </small> <br>
						<div ng-repeat="logs_planned in specific_sp_data.sp_logs track by $index">
							<span ng-if="logs_planned.sp_logs_esmr != 0" ng-show="$last" ng-bind="logs_planned.sp_logs_esmr"></span>
							<a href="" ng-show="$last" ng-if="logs_planned.sp_logs_esmr == 0 || logs_planned.sp_logs_esmr == null">Click here to download</a>
              			</div>
		      		</div>

					<div class="col-lg-4">
						<small> <b>SPCR Submission (30 Days)</b> </small> <br>
						<div ng-repeat="logs_planned in specific_sp_data.sp_logs track by $index">
							<span ng-if="logs_planned.sp_logs_spcr != 0" ng-show="$last" ng-bind="logs_planned.sp_logs_spcr"></span>
							<a href="" ng-show="$last" ng-if="logs_planned.sp_logs_spcr == 0 || logs_planned.sp_logs_spcr == null">Click here to download</a>
              			</div>
		      		</div>

					<div class="col-lg-4">
						<small> <b>CSR</b> </small> <br>
						<div ng-repeat="logs_planned in specific_sp_data.sp_logs track by $index">
							<span ng-if="logs_planned.sp_logs_csr != 0" ng-show="$last" ng-bind="logs_planned.sp_logs_csr"></span>
							<a href="" ng-show="$last" ng-if="logs_planned.sp_logs_csr == 0 || logs_planned.sp_logs_csr == null">Click here to download</a>
              			</div>
		      		</div>
      			</div>
      		</div>

      		<div class="col-lg-12">
      			<hr>
				<small> <b> Issues/Problem Encountered </b> </small>
        		<p ng-if="update_sp_data == false" ng-cloak>
          			<div ng-repeat="logs_planned in specific_sp_data.sp_logs track by $index">
						<span ng-show="$last" ng-bind="logs_planned.sp_logs_issues"></span>
          			</div>
          			<p ng-if="!logs_planned.sp_logs_issues">
          				NOT APPLICABLE
          			</p>
        		</p>
      		</div>

			<div class="col-lg-12">
				<small> <b> Analysis </b> </small>
        		<p ng-if="update_sp_data == false" ng-cloak>
          			<div ng-repeat="logs_planned in specific_sp_data.sp_logs track by $index">
						<span ng-show="$last" ng-bind="logs_planned.sp_logs_analysis"></span>
          			</div>
          			<p ng-if="!logs_planned.sp_logs_analysis">
          				NOT APPLICABLE
          			</p>
        		</p>
      		</div>

			<div class="col-lg-12">
				<small> <b> Remarks </b> </small>
        		<p ng-if="update_sp_data == false" ng-cloak>
          			<div ng-repeat="logs_planned in specific_sp_data.sp_logs track by $index">
						<span ng-show="$last" ng-bind="logs_planned.sp_logs_remarks"></span>
          			</div>

          			<p ng-if="!logs_planned.sp_logs_remarks">
          				NOT APPLICABLE
          			</p>
        		</p>
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal"> <i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Planned -->
<div class="modal fade" id="planned_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Planned Schedule for SP ID: <span ng-bind="specific_sp_data.sp_id"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @verbatim
		<div class="row" ng-repeat="p_data in planned_data track by $index">
			<div class="col">
			  <small>Planned Percentage (Week <span ng-bind="$index + 1"></span>)</small> <br>
			  <input id="percentage" type="text" class="form-control" ng-model="p_data.percentage">
			</div>
			<div class="col">
			  <small>Target Date</small> <br>
			  <input id="target_date" type="date" class="form-control" ng-model="p_data.target_date">
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col">
				<button type="button" class="btn btn-success btn-block" ng-click="add_planned()"> Add </button>
			</div>
			<div class="col">
				<button type="button" class="btn btn-secondary btn-block" ng-click="remove_planned()"> Remove </button>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="collapse" data-target="#collapseExample{{collapse_id}}" ng-click="create_planned_logs(planned_data,specific_sp_data.sp_id)">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        @endverbatim
      </div>
    </div>
  </div>
</div>

<!-- Plan history -->
<div class="modal fade" id="plan_history" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Track history for SP ID: <span ng-bind="specific_sp_data.sp_id"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    		<div class="row" ng-repeat="p_data in planned_sched track by $index">
    			<div class="col-lg-12">
    			  <small class="text-dark font-weight-bold">Target Date</small> <br>
    			  <span style="font-weight: bold;" class="text-primary" id="target_date" ng-bind="p_data.sp_logs_planned_target_date | date: 'fullDate'"></span>
    			</div>


    			<div class="col-lg-4">
    			  <small class="text-dark font-weight-bold">Planned (Week <span ng-bind="$index + 1 +')'"></span> </small> <br>
    			  <span style="font-weight: bold;" class="text-primary" id="percentage" ng-bind="(p_data.sp_logs_planned) + '%'"></span>
    			</div>

    			<div class="col-lg-4">
    			  <small class="text-dark font-weight-bold">Actual</small> <br>
    			  <span style="font-weight: bold;" class="text-primary pulsate" id="target_date" ng-if="p_data.sp_logs_actual == null">
    			  	NOT APPLICABLE
    			  </span>
    			  <span style="font-weight: bold;" class="text-primary" id="target_date" ng-if="p_data.sp_logs_actual != null" ng-bind="(p_data.sp_logs_actual) + '%'"></span>
    			</div>

    			<div class="col-lg-4">
    			  <small class="text-dark font-weight-bold">Slippage</small> <br>
    			  <span style="font-weight: bold;" class="text-primary pulsate" id="target_date" ng-if="p_data.sp_logs_slippage == null">
    			  	NOT APPLICABLE
    			  </span>
    			  <span style="font-weight: bold;" class="text-success" id="target_date" ng-if="p_data.sp_logs_slippage >= 0 && p_data.sp_logs_slippage != null" ng-bind="(p_data.sp_logs_slippage) + '%'"></span>
    			  <span style="font-weight: bold;" class="text-danger" id="target_date" ng-if="p_data.sp_logs_slippage < 0 && p_data.sp_logs_slippage != null" ng-bind="(p_data.sp_logs_slippage) + '%'"></span>
    			</div>
          
          @verbatim
          <div class="col-lg-3">
    				<small class="text-dark font-weight-bold">Variation order</small> <br>
            <!-- <h2 ng-bind="p_data.sp_logs_variation_order"></h2> -->
    				<span style="font-weight: bold;" ng-if="p_data.sp_logs_variation_order == 0" class="text-primary pulsate" id="target_date"> NOT APPLICABLE </span>
    				<a style="font-weight: bold;" ng-if="p_data.sp_logs_variation_order != 0" href="http://kce_v2.caraga.dswd.gov.ph/dac/routes/show_file">Go to downloadables <i class="fa fa-download"></i></a>
          </div>

    			<div class="col-lg-3">
    				<small class="text-dark font-weight-bold">ESMR</small> <br>
    				<span style="font-weight: bold;" ng-if="p_data.sp_logs_variation_order == 0 || p_data.sp_logs_variation_order == '0'" class="text-primary pulsate" id="target_date"> NOT APPLICABLE </span>
    				<a style="font-weight: bold;" ng-if="p_data.sp_logs_esmr != 0 || p_data.sp_logs_esmr != '0'" href="http://kce_v2.caraga.dswd.gov.ph/dac/routes/show_file">Go to downloadables <i class="fa fa-download"></i></a>

          </div>

    			<div class="col-lg-3">
    				<small class="text-dark font-weight-bold">CSR</small> <br>
    				<span style="font-weight: bold;" class="text-primary pulsate" id="target_date" ng-if="p_data.sp_logs_csr == 0 || p_data.sp_logs_csr == '0'">NOT APPLICABLE</span>
    				<a style="font-weight: bold;" ng-if="p_data.sp_logs_csr != 0 || p_data.sp_logs_csr != '0'"  href="http://kce_v2.caraga.dswd.gov.ph/dac/routes/show_file">Go to downloadables <i class="fa fa-download"></i></a>
          </div>

          <div class="col-lg-3">
            <small class="text-dark font-weight-bold">MATERIALS TESTING</small> <br>
            <span style="font-weight: bold;" class="text-primary pulsate" id="target_date" ng-if="p_data.sp_logs_mt == 0 || p_data.sp_logs_mt == '0'">NOT APPLICABLE</span>
            <a style="font-weight: bold;" ng-if="p_data.sp_logs_mt != 0"  href="http://kce_v2.caraga.dswd.gov.ph/dac/routes/show_file">Go to downloadables <i class="fa fa-download"></i></a>
          </div>
          @endverbatim

          <div class="col-lg-12">
            <small class="text-dark font-weight-bold"> Issues/Problem Encountered </small>
            <br>
            <span style="font-weight: bold;" ng-if="p_data.sp_logs_issues != '0' && p_data.sp_logs_issues != 0" class="text-primary" ng-bind="p_data.sp_logs_issues"></span>
            <span style="font-weight: bold;" ng-if="p_data.sp_logs_issues == '0' || p_data.sp_logs_issues == 0" class="text-primary pulsate">NOT APPLICABLE</span>
          </div>

          <div class="col-lg-12">
            <small class="text-dark font-weight-bold"> Analysis </small>
            <br>
            <span style="font-weight: bold;" class="text-primary" ng-if="p_data.sp_logs_analysis != '0' && p_data.sp_logs_analysis != 0" class="text-primary" ng-bind="p_data.sp_logs_analysis"></span>
            <span style="font-weight: bold;" class="text-primary pulsate" ng-if="p_data.sp_logs_analysis == '0' || p_data.sp_logs_analysis == 0">NOT APPLICABLE</span>
              </div>

          <div class="col-lg-12">
            <small class="text-dark font-weight-bold"> Remarks </small>
            <br>
            <span style="font-weight: bold;" ng-if="p_data.sp_logs_remarks != '0' && p_data.sp_logs_remarks != 0" class="text-primary" ng-bind="p_data.sp_logs_remarks"></span>
            <span style="font-weight: bold;" ng-if="p_data.sp_logs_remarks == '0' || p_data.sp_logs_remarks == 0" class="text-primary pulsate">NOT APPLICABLE</span>
          </div>
          <div class="col-lg-12"> <hr> </div>
    		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close <i class="fa fa-times-circle"></i></button>
      </div>
    </div>
  </div>
</div>

<!-- RFR Tracking -->
<div class="modal fade" id="rfr_tracking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg rounded-0" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<!-- SP TITLE -->
        <span>
        	<p class="text-success mb-0">RFR TRACKING</p>
	        <p class="text-primary my-0 font-weight-bold" class="text-info" ng-bind="rfr_data.sp_title"></p>
	        <p class="text-primary my-0 font-weight-bold" class="text-info" ng-bind="(rfr_data.sp_brgy) +' '+(rfr_data.sp_municipality) +', '+ (rfr_data.sp_province)"></p>
        </span>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-lg-3">
      			<label style="font-size: .8em; font-weight:bold; ">TRANCHE</label>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.tranche"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.tranche"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.tranche"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.tranche"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.tranche"></span>
        		</p>

        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.tranche"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.tranche"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.tranche"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.tranche"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.tranche"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.tranche"></span>
        		</p>
      		</div>

      		<div class="col-lg-3">
      			<label style="font-size: .8em; font-weight:bold; ">CADT</label>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.cadt"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.cadt"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.cadt"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.cadt"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.cadt"></span>
        		</p>

        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.cadt"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.cadt"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.cadt"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.cadt"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.cadt"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.cadt"></span>
        		</p>
      		</div>

      		<div class="col-lg-3">
      			<label style="font-size: .8em; font-weight:bold; ">MBIF</label>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.mibf_date"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.mibf_date"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.mibf_date"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.mibf_date"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.mibf_date"></span>
        		</p>

        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.mibf_date"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.mibf_date"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.mibf_date"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.mibf_date"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.mibf_date"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.mibf_date"></span>
        		</p>
      		</div>

      		<div class="col-lg-3">
      			<label style="font-size: .8em; font-weight:bold; ">GRANT ALLOCATION</label>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.date_encoded | date:'fullDate'"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.date_encoded | date:'fullDate'"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.date_encoded | date:'fullDate'"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.date_encoded | date:'fullDate'"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.date_encoded | date:'fullDate'"></span>
        		</p>

        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.date_encoded | date:'fullDate'"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.date_encoded | date:'fullDate'"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.date_encoded | date:'fullDate'"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.date_encoded | date:'fullDate'"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.date_encoded | date:'fullDate'"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.date_encoded | date:'fullDate'"></span>
        		</p>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      		</div>
      		
      		<div class="col">
      			<label style="font-size: .8em; font-weight:bold; ">GRANTS</label>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.grant | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.grant | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.grant | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.grant | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.grant | currency: '₱ '"></span>
        		</p>

        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.grant | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.grant | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.grant | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.grant | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.grant | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.grant | currency: '₱ '"></span>
        		</p>
      		</div>
      		<div class="col">
      			<label style="font-size: .8em; font-weight:bold; ">LCC</label>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_LCC | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_LCC | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_LCC | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_LCC | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_LCC | currency: '₱ '"></span>
        		</p>

        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_LCC | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_LCC | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_LCC | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_LCC | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_LCC | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_LCC | currency: '₱ '"></span>
        		</p>

      		</div>
      		<div class="col">
      			<label style="font-size: .8em; font-weight:bold; ">TPC</label>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_cost_ni | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_cost_ni | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_cost_ni | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_cost_ni | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_cost_ni | currency: '₱ '"></span>
        		</p>

        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_cost_ni | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_cost_ni | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_cost_ni | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_cost_ni | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_cost_ni | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null">
        			<span class="text-info" ng-bind="rfr_data.total_cost_ni | currency: '₱ '"></span>
        		</p>
      		</div>
      		<div class="col">
      			<label style="font-size: .8em; font-weight:bold; ">RFR AMOUNT</label>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.amount | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.amount | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.amount | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.amount | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.amount | currency: '₱ '"></span>
        		</p>

        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
        		</p>
      		</div>
      		<div class="col">
      			<label style="font-size: .8em; font-weight:bold; ">CURRENT LOCATION</label>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.current_location1 | uppercase"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.current_location1 | uppercase"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.current_location1 | uppercase"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.current_location1 | uppercase"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.current_location1 | uppercase"></span>
        		</p>

        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.current_location1 | uppercase"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.current_location1 | uppercase"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.current_location1 | uppercase"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.current_location1 | uppercase"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.current_location1 | uppercase"></span>
        		</p>
        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.current_location1 | uppercase"></span>
        		</p>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<h4>RPMO</h4>
      			<div class="row">
      				<div class="col-lg-3">
      					<label style="font-size: .8em; font-weight:bold; ">DATE RECEIVED</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
      				</div>
      				<div class="col">
      					<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_rpmo,rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_rpmo,rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_rpmo,rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_rpmo,rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_rpmo,rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_rpmo,rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_rpmo,rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_rpmo,rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_rpmo,rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_rpmo,rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_rpmo,rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
      				</div>
      			</div>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<h4>SOCIALS</h4>
      			<div class="row">
      				<div class="col-lg-3">
      					<label style="font-size: .8em; font-weight:bold; ">DATE RECEIVED</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_socials | date: 'fullDate'"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_socials | date: 'fullDate'"></span>
		        		</p>
      				</div>
      				<div class="col">
      					<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_socials,rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_socials,rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_socials,rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_socials,rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_socials,rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_socials,rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_socials,rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_socials,rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_socials,rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_socials,rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_socials,rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
      				</div>
      				<div class="col-lg-7">
      					<label style="font-size: .8em; font-weight:bold; ">FINDINGS</label>
						<ul class="list-group">
						  <li class="list-group-item"ng-repeat="data in rfr_data_findings[1]">
						  	<p class="my-0" ng-class="{ 'text-green': data.complied == 1, 'text-warning': data.complied == 0}"  ng-bind="data.finding"></p>
						  </li>
						</ul>
      				</div>
      			</div>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<h4>ENGINEERING</h4>
      			<div class="row">
      				<div class="col-lg-3">
      					<label style="font-size: .8em; font-weight:bold; ">DATE RECEIVED</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_engineering | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_engineering | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_engineering | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_engineering | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_engineering | date: 'fullDate'"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_engineering | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_engineering | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_engineering | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_engineering | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_engineering | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_engineering | date: 'fullDate'"></span>
		        		</p>
      				</div>
      				<div class="col">
      					<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_engineering,rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_engineering,rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_engineering,rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_engineering,rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_engineering,rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_engineering,rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_engineering,rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_engineering,rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_engineering,rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_engineering,rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_engineering,rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
      				</div>

      				<div class="col-lg-7" ng-if="rfr_data_findings[2].length > 0">
      					<label style="font-size: .8em; font-weight:bold; ">FINDINGS</label>
						<ul class="list-group">
							@verbatim
							<div id="accordion">
							  <div class="card" ng-repeat="data in rfr_data_findings[2]">
							    <div class="card-header" id="headingOne">
							    	<p class="my-0" ng-class="{ 'text-green': data.complied == 1, 'text-warning': data.complied == 0}"  ng-bind="data.finding" ></p>
							    	<small ng-bind="data.date_complied"></small> <br>

							    	<a href="" style="cursor: pointer;" class="text-secondary mt-2" data-toggle="collapse" data-target="#collapse{{data.id}}" aria-expanded="true" aria-controls="collapse{{data.id}}"><b>Edit</b> <i class="fa fa-pencil"></i></a>

					        		<a ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>

					        		<a ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
							    </div>

							    <div id="collapse{{data.id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
							      <div class="card-body" style="padding: 5px !important;">
							      	<textarea ng-model="edited_rfr_eng_findings" maxlength="1000" rows="4" cols="50" class="form-control" style="resize: none; border-top: none !important; border-left: none !important; border-right: none !important;"></textarea>

					        		<!-- Submit -->
					        		<button ng-click="update_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.id,'bub','2015',edited_rfr_eng_findings)" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.id,'bub','2016',edited_rfr_eng_findings)" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.id,'bub','2017',edited_rfr_eng_findings)" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.id,'bub','2018',edited_rfr_eng_findings)" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.id,'bub','2020',edited_rfr_eng_findings)" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>

					        		<button ng-click="update_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.id,'ncddp','2015',edited_rfr_eng_findings)" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.id,'ncddp','2016',edited_rfr_eng_findings)" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.id,'ncddp','2017',edited_rfr_eng_findings)" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.id,'ncddp','2018',edited_rfr_eng_findings)" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.id,'ncddp','2019',edited_rfr_eng_findings)" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.id,'ncddp','2020',edited_rfr_eng_findings)" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>

							      </div>
							    </div>

							    <div id="collapseComplied{{data.id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
									<div class="card-body" style="padding: 5px !important;">
										<div class="form-group">
											<label style="font-size: .8em; font-weight:bold; ">DATE COMPLIED</label>
											<input  type="date" class="form-control" ng-model="set_findings_date_complied">
										</div>
			        					<div class="col-lg-12 mt-2 px-0">
								        		<a ng-click="set_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.id,'bub','2015', set_findings_date_complied)" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.id,'bub','2016', set_findings_date_complied)" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.id,'bub','2017', set_findings_date_complied)" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.id,'bub','2018', set_findings_date_complied)" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.id,'bub','2020', set_findings_date_complied)" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>

								        		<a ng-click="set_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.id,'ncddp','2015', set_findings_date_complied)" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.id,'ncddp','2016', set_findings_date_complied)" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.id,'ncddp','2017', set_findings_date_complied)" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.id,'ncddp','2018', set_findings_date_complied)" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.id,'ncddp','2019', set_findings_date_complied)" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied(data.id,rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.id,'ncddp','2020', set_findings_date_complied)" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
			        					</div>

									</div>
							    </div>


							  </div>
							</div>
							@endverbatim
						</ul>

      				</div>

        			<div class="col-lg-7" ng-if="!rfr_data_findings[2] || rfr_data_findings[2].length == 0">

        				<div class="form-group" ng-repeat="findings in rfr_findings track by $index">
	      					<label style="font-size: .8em; font-weight:bold; ">FINDINGS <span>No. <span ng-bind="$index + 1"></span></span></label>
							<textarea ng-model="findings.rfr_eng_findings" maxlength="1000" rows="4" cols="50" class="form-control" style="resize: none;"></textarea>

							<label style="font-size: .8em; font-weight:bold; ">DATE COMPLIED</label>
							<input  type="date" class="form-control" ng-model="findings.date_complied">

							<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS TO COMPLY</label>
							<input  type="text" class="form-control" ng-model="findings.days">
        				</div>

        				<div class="row">
        					<div class="col">
								<button class="btn btn-success btn-block" type="button" ng-click="add_rfr_findings()"> <i class="fa fa-plus"></i> Add </button>
        					</div>
        					<div class="col">
								<button class="btn btn-danger btn-block" type="button" ng-click="remove_add_rfr_findings()"> <i class="fa fa-minus"></i> Delete </button>
        					</div>

        					<div class="col-lg-12 mt-2">
				        		<button ng-click="submit_rfr_findings(rfr_findings,rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.id,'bub','2015')" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null && rfr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_rfr_findings(rfr_findings,rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.id,'bub','2016')" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null && rfr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_rfr_findings(rfr_findings,rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.id,'bub','2017')" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null && rfr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_rfr_findings(rfr_findings,rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.id,'bub','2018')" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null && rfr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_rfr_findings(rfr_findings,rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.id,'bub','2020')" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null && rfr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>

				        		<button ng-click="submit_rfr_findings(rfr_findings,rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.id,'ncddp','2015')" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null && rfr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_rfr_findings(rfr_findings,rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.id,'ncddp','2016')" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null && rfr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_rfr_findings(rfr_findings,rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.id,'ncddp','2017')" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null && rfr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_rfr_findings(rfr_findings,rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.id,'ncddp','2018')" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null && rfr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_rfr_findings(rfr_findings,rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.id,'ncddp','2019')" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null && rfr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_rfr_findings(rfr_findings,rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.id,'ncddp','2020')" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null && rfr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
        					</div>

        				</div>
							
        			</div>

      			</div>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<h4>FINANCE</h4>
      			<div class="row">
      				<div class="col-lg-3">
      					<label style="font-size: .8em; font-weight:bold; ">DATE RECEIVED</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_finance | date: 'fullDate'"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_finance | date: 'fullDate'"></span>
		        		</p>
      				</div>
      				<div class="col">
      					<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_finance,rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_finance,rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_finance,rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_finance,rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_finance,rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_finance,rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_finance,rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_finance,rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_finance,rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_finance,rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_finance,rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
      				</div>
      				<div class="col-lg-7">
      					<label style="font-size: .8em; font-weight:bold; ">FINDINGS</label>
						<ul class="list-group">
						  <li class="list-group-item"ng-repeat="data in rfr_data_findings[3]">
						  	<p class="my-0" ng-class="{ 'text-green': data.complied == 1, 'text-warning': data.complied == 0}"  ng-bind="data.finding"></p>
						  </li>
						</ul>
      				</div>
      			</div>
      		</div>
      		
      		<div class="col-lg-12">
      			<hr>
      		</div>
      		
      		<div class="col-lg-4">
      			<h4>ACCOUNTING</h4>
      			<div class="row">
      				<div class="col-lg-12">
      					<label style="font-size: .8em; font-weight:bold; ">DV No.</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.dv_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.dv_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.dv_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.dv_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.dv_number"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.dv_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.dv_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.dv_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.dv_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.dv_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.dv_number"></span>
		        		</p>
      				</div>
      				<div class="col-lg-12">
      					<label style="font-size: .8em; font-weight:bold; ">DV DATE</label>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.incoming_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.incoming_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.incoming_date | date: 'fullDate'"></span>
		        			</span>

		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.incoming_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.incoming_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.incoming_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.incoming_date)  == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.incoming_date)  == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.incoming_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.incoming_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.incoming_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.incoming_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.incoming_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.incoming_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.incoming_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.incoming_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.incoming_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.incoming_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.incoming_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.incoming_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.incoming_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.incoming_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.incoming_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.incoming_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.incoming_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.incoming_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.incoming_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.incoming_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.incoming_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.incoming_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.incoming_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.incoming_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.incoming_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
      				</div>
      				<div class="col-lg-12">
      					<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.incoming_date,rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.incoming_date,rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.incoming_date,rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.incoming_date,rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.incoming_date,rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.incoming_date,rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.incoming_date,rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.incoming_date,rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.incoming_date,rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.incoming_date,rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.incoming_date,rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
      				</div>
      			</div>
      		</div>

      		<div class="col-lg-4">
      			<h4>BUDGET</h4>
      			<div class="row">
      				<div class="col-lg-12">
      					<label style="font-size: .8em; font-weight:bold; ">OBR NO.</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.ors_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.ors_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.ors_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.ors_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.ors_number"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.ors_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.ors_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.ors_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.ors_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.ors_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.ors_number"></span>
		        		</p>
      				</div>
      				<div class="col-lg-12">
      					<label style="font-size: .8em; font-weight:bold; ">OBR DATE</label>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.obligation_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.obligation_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.obligation_date | date: 'fullDate'"></span>
		        			</span>

		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.obligation_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.obligation_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.obligation_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.obligation_date)  == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.obligation_date)  == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.obligation_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.obligation_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.obligation_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.obligation_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.obligation_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.obligation_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.obligation_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.obligation_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.obligation_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.obligation_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.obligation_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.obligation_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.obligation_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.obligation_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.obligation_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.obligation_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.obligation_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.obligation_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.obligation_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.obligation_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.obligation_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.obligation_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.obligation_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.obligation_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.obligation_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
      				</div>

      				<div class="col-lg-12">
      					<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.obligation_date,rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.obligation_date,rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.obligation_date,rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.obligation_date,rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.obligation_date,rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.obligation_date,rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.obligation_date,rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.obligation_date,rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.obligation_date,rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.obligation_date,rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.obligation_date,rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
      				</div>
      			</div>
      		</div>

      		<div class="col-lg-4">
      			<h4>CASH</h4>
      			<div class="row">
      				<div class="col-lg-12">
      					<label style="font-size: .8em; font-weight:bold; ">CHECK NO.</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.check_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.check_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.check_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.check_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.check_number"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.check_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.check_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.check_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.check_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.check_number"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.check_number"></span>
		        		</p>
      				</div>
      				<div class="col-lg-12">
      					<label style="font-size: .8em; font-weight:bold; ">CHECK DATE</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.cash_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.cash_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.cash_date | date: 'fullDate'"></span>
		        			</span>

		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.cash_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.cash_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.cash_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.cash_date)  == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.cash_date)  == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.cash_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.cash_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.cash_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.cash_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.cash_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.cash_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.cash_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.cash_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.cash_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.cash_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.cash_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.cash_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.cash_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.cash_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.cash_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.cash_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.cash_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.cash_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.cash_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.cash_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.cash_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.cash_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.cash_date) == false">
		        				NOT APPLICABLE
		        			</span>
		        			<span class="text-info" ng-if="check_isDate(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.cash_date) == true">
		        				<span class="text-info" ng-bind="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.cash_date | date: 'fullDate'"></span>
		        			</span>
		        		</p>
      				</div>
      				<div class="col-lg-12">
      					<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS</label>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.cash_date,rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.cash_date,rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.cash_date,rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.cash_date,rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.cash_date,rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.date_encoded)"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.cash_date,rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.cash_date,rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.cash_date,rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.cash_date,rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.cash_date,rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
		        			<span class="text-info" ng-bind="days(rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.cash_date,rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.date_encoded)"></span>
		        		</p>
      				</div>
      			</div>
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal"> <i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>

<!-- SPCR Tracking -->
<div class="modal fade" id="spcr_tracking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg rounded-0" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<!-- SP TITLE -->
        <span>
        	<p class="text-success mb-0">SPCR TRACKING</p>
	        <p class="text-primary my-0 font-weight-bold" class="text-info" ng-bind="spcr_data.sp_title"></p>
	        <p class="text-primary my-0 font-weight-bold" class="text-info" ng-bind="(spcr_data.sp_brgy) +' '+(spcr_data.sp_municipality) +', '+ (spcr_data.sp_province)"></p>
        </span>
      </div>
      <div class="modal-body">
      	<div class="row">

			<div class="col">
				<label style="font-size: .8em; font-weight:bold; ">GRANTS</label>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.grant | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.grant | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.grant | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.grant | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.grant | currency: '₱ '"></span>
				</p>

				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.grant | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.grant | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.grant | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.grant | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.grant | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.grant | currency: '₱ '"></span>
				</p>
			</div>

			<div class="col">
				<label style="font-size: .8em; font-weight:bold; ">LCC</label>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_LCC | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_LCC | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_LCC | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_LCC | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_LCC | currency: '₱ '"></span>
				</p>

				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_LCC | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_LCC | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_LCC | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_LCC | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_LCC | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_LCC | currency: '₱ '"></span>
				</p>

			</div>
			<div class="col">
				<label style="font-size: .8em; font-weight:bold; ">TPC</label>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_cost_ni | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_cost_ni | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_cost_ni | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_cost_ni | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_cost_ni | currency: '₱ '"></span>
				</p>

				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_cost_ni | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_cost_ni | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_cost_ni | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_cost_ni | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_cost_ni | currency: '₱ '"></span>
				</p>
				<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null">
					<span class="text-info" ng-bind="spcr_data.total_cost_ni | currency: '₱ '"></span>
				</p>
			</div>

      		<div class="col-lg-12">
      			<h4>RPMO</h4>
      			<div class="row">
      				<div class="col-lg-3">
      					<label style="font-size: .8em; font-weight:bold; ">DATE RECEIVED</label>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_rpmo | date: 'fullDate'"></span>
		        		</p>
      				</div>
      				<div class="col">
      					<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS</label>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_rpmo,spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_rpmo,spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_rpmo,spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_rpmo,spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_rpmo,spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_rpmo,spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_rpmo,spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_rpmo,spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_rpmo,spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_rpmo,spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_rpmo,spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
      				</div>
      			</div>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<h4>SOCIALS</h4>
      			<div class="row">
      				<div class="col-lg-3">
      					<label style="font-size: .8em; font-weight:bold; ">DATE RECEIVED</label>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_socials | date: 'fullDate'"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_socials | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_socials | date: 'fullDate'"></span>
		        		</p>
      				</div>
      				<div class="col">
      					<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS</label>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_socials,spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_socials,spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_socials,spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_socials,spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_socials,spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_socials,spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_socials,spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_socials,spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_socials,spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_socials,spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_socials,spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
      				</div>
      				<div class="col-lg-7">
      					<label style="font-size: .8em; font-weight:bold; ">FINDINGS</label>
						<ul class="list-group">
						  <li class="list-group-item"ng-repeat="data in spcr_data_findings[1]">
						  	<p class="my-0" ng-class="{ 'text-green': data.complied == 1, 'text-warning': data.complied == 0}"  ng-bind="data.finding"></p>
						  </li>
						</ul>
      				</div>
      			</div>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<h4>FINANCE</h4>
      			<div class="row">
      				<div class="col-lg-3">
      					<label style="font-size: .8em; font-weight:bold; ">DATE RECEIVED</label>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_finance | date: 'fullDate'"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_finance | date: 'fullDate'"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_finance | date: 'fullDate'"></span>
		        		</p>
      				</div>
      				<div class="col">
      					<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS</label>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_finance,spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_finance,spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_finance,spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_finance,spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_finance,spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.date_encoded)"></span>
		        		</p>

		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_finance,spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_finance,spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_finance,spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_finance,spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_finance,spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
		        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r != null">
		        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_finance,spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
		        		</p>
      				</div>
      				<div class="col-lg-7">
      					<label style="font-size: .8em; font-weight:bold; ">FINDINGS</label>
						<ul class="list-group">
						  <li class="list-group-item" ng-repeat="data in spcr_data_findings[3]">
						  	<p class="my-0" ng-class="{ 'text-green': data.complied == 1, 'text-warning': data.complied == 0}"  ng-bind="data.finding"></p>
						  </li>
						</ul>
      				</div>
      			</div>
      		</div>

      		<div class="col-lg-12">
      			<hr>
      			<h4>ENGINEERING</h4>
      			<div class="row">
      				<div class="col-lg-3">
      					<label style="font-size: .8em; font-weight:bold; ">DATE RECEIVED</label>

      					<div ng-if="spcr_data_findings[3] || spcr_data_findings[3].length > 0">
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r != null">
			        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_engineering | date: 'fullDate'"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r != null">
			        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_engineering | date: 'fullDate'"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r != null">
			        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_engineering | date: 'fullDate'"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r != null">
			        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_engineering | date: 'fullDate'"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r != null">
			        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_engineering | date: 'fullDate'"></span>
			        		</p>

			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r != null">
			        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_engineering | date: 'fullDate'"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r != null">
			        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_engineering | date: 'fullDate'"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r != null">
			        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_engineering | date: 'fullDate'"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r != null">
			        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_engineering | date: 'fullDate'"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r != null">
			        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_engineering | date: 'fullDate'"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r != null">
			        			<span class="text-info" ng-bind="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_engineering | date: 'fullDate'"></span>
			        		</p>
      					</div>

      					<p class="text-danger" ng-if="!spcr_data_findings[3] || spcr_data_findings[3].length == 0">
      						Not applicable, needs the finance unit's findings first.
      					</p>
      				</div>
      				<div class="col">
      					<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS</label>

      					<div  ng-if="spcr_data_findings[3] || spcr_data_findings[3].length > 0">
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r != null">
			        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_engineering,spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.date_encoded)"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r != null">
			        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_engineering,spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.date_encoded)"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r != null">
			        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_engineering,spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.date_encoded)"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r != null">
			        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_engineering,spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.date_encoded)"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r != null">
			        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_engineering,spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.date_encoded)"></span>
			        		</p>

			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r != null">
			        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_engineering,spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r != null">
			        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_engineering,spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r != null">
			        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_engineering,spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r != null">
			        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_engineering,spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r != null">
			        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_engineering,spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
			        		</p>
			        		<p class="pb-0 mb-0" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r != null">
			        			<span class="text-info" ng-bind="days(spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_engineering,spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.date_encoded)"></span>
			        		</p>
      					</div>

      					<p class="text-danger" ng-if="!spcr_data_findings[3] || spcr_data_findings[3].length == 0">
      						Not applicable, needs the finance unit's findings first.
      					</p>

      				</div>

      				<div class="col-lg-7" ng-if="spcr_data_findings[2].length > 0">
      					<label style="font-size: .8em; font-weight:bold; ">FINDINGS</label>
						<ul class="list-group">
							@verbatim
							<div id="accordion">
							  <div class="card" ng-repeat="data in spcr_data_findings[2]">
							    <div class="card-header" id="headingOne">
							    	<p class="my-0" ng-class="{ 'text-green': data.complied == 1, 'text-warning': data.complied == 0}"  ng-bind="data.finding" ></p>
							    	<small ng-bind="data.date_complied"></small> <br>

							    	<a href="" style="cursor: pointer;" class="text-secondary mt-2" data-toggle="collapse" data-target="#collapse{{data.id}}" aria-expanded="true" aria-controls="collapse{{data.id}}"><b>Edit</b> <i class="fa fa-pencil"></i></a>

					        		<a ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>

					        		<a ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
					        		<a ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r != null && data.complied == 0" class="mt-2" data-toggle="collapse" data-target="#collapseComplied{{data.id}}" aria-expanded="true" aria-controls="collapseComplied{{data.id}}">
					        			<b>Set as Complied</b> <i class="fa fa-thumbs-o-up"></i>
					        		</a>
							    </div>

							    <div id="collapse{{data.id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
							      <div class="card-body" style="padding: 5px !important;">
							      	<textarea ng-model="edited_rfr_eng_findings" maxlength="1000" rows="4" cols="50" class="form-control" style="resize: none; border-top: none !important; border-left: none !important; border-right: none !important;"></textarea>

					        		<!-- Submit -->
					        		<button ng-click="update_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.sp_id,'bub','2015',edited_rfr_eng_findings)" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.sp_id,'bub','2016',edited_rfr_eng_findings)" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.sp_id,'bub','2017',edited_rfr_eng_findings)" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.sp_id,'bub','2018',edited_rfr_eng_findings)" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.sp_id,'bub','2020',edited_rfr_eng_findings)" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>

					        		<button ng-click="update_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2015',edited_rfr_eng_findings)" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2016',edited_rfr_eng_findings)" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2017',edited_rfr_eng_findings)" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2018',edited_rfr_eng_findings)" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2019',edited_rfr_eng_findings)" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>
					        		<button ng-click="update_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2020',edited_rfr_eng_findings)" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r != null" class="mt-2 btn btn-success" type="button">
					        			Update <i class="fa fa-refresh"></i>
					        		</button>

							      </div>
							    </div>

							    <div id="collapseComplied{{data.id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
									<div class="card-body" style="padding: 5px !important;">
										<div class="form-group">
											<label style="font-size: .8em; font-weight:bold; ">DATE COMPLIED</label>
											<input  type="date" class="form-control" ng-model="set_findings_date_complied">
										</div>
			        					<div class="col-lg-12 mt-2 px-0">
								        		<a ng-click="set_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.sp_id,'bub','2015', set_findings_date_complied)" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.sp_id,'bub','2016', set_findings_date_complied)" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.sp_id,'bub','2017', set_findings_date_complied)" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.sp_id,'bub','2018', set_findings_date_complied)" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.sp_id,'bub','2020', set_findings_date_complied)" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>

								        		<a ng-click="set_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2015', set_findings_date_complied)" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2016', set_findings_date_complied)" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2017', set_findings_date_complied)" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2018', set_findings_date_complied)" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2019', set_findings_date_complied)" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
								        		<a ng-click="set_findings_complied_spcr(data.id,spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2020', set_findings_date_complied)" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r != null && data.complied == 0" class="btn btn-primary btn-block text-light mt-2">
								        			<b>Submit</b> <i class="fa fa-thumbs-o-up"></i>
								        		</a>
			        					</div>

									</div>
							    </div>


							  </div>
							</div>
							@endverbatim
						</ul>

      				</div>

        			<div class="col-lg-7" ng-if="!spcr_data_findings[2] || spcr_data_findings[2].length == 0">
      					<label ng-if="!spcr_data_findings[3] || spcr_data_findings[3].length == 0" style="font-size: .8em; font-weight:bold; ">FINDINGS</label>
      					<p class="text-danger" ng-if="!spcr_data_findings[3] || spcr_data_findings[3].length == 0">
      						Not applicable, needs the finance unit's findings first.
      					</p>

        				<div class="form-group" ng-repeat="findings in spcr_findings track by $index">
	      					<label style="font-size: .8em; font-weight:bold; ">FINDINGS <span>No. <span ng-bind="$index + 1"></span></span></label>
							<textarea ng-model="findings.rfr_eng_findings" maxlength="1000" rows="4" cols="50" class="form-control" style="resize: none;"></textarea>

							<label style="font-size: .8em; font-weight:bold; ">DATE COMPLIED</label>
							<input  type="date" class="form-control" ng-model="findings.date_complied">

							<label style="font-size: .8em; font-weight:bold; ">NO. OF DAYS TO COMPLY</label>
							<input  type="text" class="form-control" ng-model="findings.days">
        				</div>

        				<div class="row">
        					<div class="col">
								<button ng-disabled="!spcr_data_findings[3] || spcr_data_findings[3].length == 0" class="btn btn-success btn-block" type="button" ng-click="add_spcr_findings()"> <i class="fa fa-plus"></i> Add </button>
        					</div>
        					<div class="col">
								<button ng-disabled="!spcr_data_findings[3] || spcr_data_findings[3].length == 0" class="btn btn-danger btn-block" type="button" ng-click="remove_add_spcr_findings()"> <i class="fa fa-minus"></i> Delete </button>
        					</div>

        					<div class="col-lg-12 mt-2">
				        		<button ng-click="submit_spcr_findings(spcr_findings,spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.sp_id,'bub','2015')" ng-if="spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r != null && spcr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_spcr_findings(spcr_findings,spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.sp_id,'bub','2016')" ng-if="spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r != null && spcr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_spcr_findings(spcr_findings,spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.sp_id,'bub','2017')" ng-if="spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r != null && spcr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_spcr_findings(spcr_findings,spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.sp_id,'bub','2018')" ng-if="spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r != null && spcr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_spcr_findings(spcr_findings,spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.sp_id,'bub','2020')" ng-if="spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r != null && spcr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>

				        		<button ng-click="submit_spcr_findings(spcr_findings,spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2015')" ng-if="spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r != null && spcr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_spcr_findings(spcr_findings,spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2016')" ng-if="spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r != null && spcr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_spcr_findings(spcr_findings,spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2017')" ng-if="spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r != null && spcr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_spcr_findings(spcr_findings,spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2018')" ng-if="spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r != null && spcr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_spcr_findings(spcr_findings,spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2019')" ng-if="spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r != null && spcr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
				        		<button ng-click="submit_spcr_findings(spcr_findings,spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.sp_id,'ncddp','2020')" ng-if="spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r != null && spcr_findings.length > 0" class="mt-2 btn btn-primary btn-block" type="button">
				        			Submit <i class="fa fa-paper-plane-o"></i>
				        		</button>
        					</div>

        				</div>
							
        			</div>

      			</div>
      		</div>
      		
      		<div class="col-lg-12">
      			<hr>
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal"> <i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>

<!-- FILTER MODAL -->
<div class="modal inmodal fade" id="filterModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header py-2 px-3 text-left">
              <span style="font-size: 1.3em;" class="py-0 my-0">
                Filter Modalities
              </span>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
          <div class="modal-body" style="padding-top: 10px;padding-bottom: 10px;" ng-cloak>
            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> Modality </small> </small></label>
              <select class="form-control" id="modality" ng-model="search_modality">
                <option value="1" selected>KKB</option>
                <option value="2">MAKILAHOK</option>
                <option value="3">NCDDP</option>
                <option value="4">IP CDD</option>
                <option value="5">CCL</option>
                <option value="6">L&E</option>
              </select>
            </div>
        
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group mb-2">
                  <label><small class="col-form-label"> <small class="font-weight-bold"> Year </small> </small></label>
                  <select class="form-control" id="year" ng-model="search_year">
                    <option value="2014" selected> 2014 </option>
                    <option value="2015"> 2015 </option>
                    <option value="2016"> 2016 </option>
                    <option value="2017"> 2017 </option>
                    <option value="2018"> 2018 </option>
                    <option value="2019"> 2019 </option>
                    <option value="2020"> 2020 </option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group mb-2">
                  <label><small class="col-form-label"> <small class="font-weight-bold"> Cycle </small> </small></label>
                  <select class="form-control" id="cycle" ng-model="search_cycle">
                    <option value="1" selected> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group mb-2">
                  <label><small class="col-form-label"> <small class="font-weight-bold"> Batch </small> </small></label>
                  <select class="form-control" id="batch" ng-model="search_batch">
                    <option value="1" selected> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> Province </small> </small></label>
              <select class="form-control" ng-model="province_data" ng-options="prov_data.name for prov_data in reg" ng-change="fetch_municipality(province_data.prov_code)">
              </select>
            </div>
            
            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> Municipality </small> </small></label>
              <select class="form-control" ng-model="municipality_data" ng-options="muni_data.name for muni_data in muni" ng-change="fetch_brgy(municipality_data.mun_code)">
              </select>
            </div>
            
            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> Brgy </small> </small></label>
              <select class="form-control" ng-model="brgy_data" ng-options="b_data.name for b_data in brgy">
              </select>
            </div>

            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> SP Title </small> </small></label>
              <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Ex. FISH CAGE CULTURE..." ng-model="search_title">
            </div>

            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> SP ID </small> </small></label>
              <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Ex. 201804000..." ng-model="search_sp_id">
            </div>
            </div>
          <div class="modal-footer">
        <button class="btn btn-primary" type="button" data-dismiss="modal" ng-click="search_data_modal(search_modality,search_year,search_cycle,search_batch,province_data,municipality_data,brgy_data,search_title,search_sp_id)">Generate <i class="fa fa-gears "></i></button>
        <button class="btn btn-white" type="button" data-dismiss="modal">Cancel <i class="fa fa-times"></i></button>
          </div>
        </div>
    </div>
</div>

<!-- CREATE PMR -->
<div class="modal fade" id="add_pmr_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="padding: 20px 30px 0px !important;">
        <div class="row">
          <div class="col-lg-12">
            <h2 class="font-weight-bold my-0">PMR for SP ID: <span ng-bind="specific_sp_data.sp_id"></span></h2>
          </div>
          <div class="col-lg-12">
            <span ng-bind="specific_sp_data.sp[0].sp_title"></span>
            <span ng-if="all_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p != null">
              <span ng-bind="all_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.sp_title | uppercase"></span>
            </span>
            <span ng-if="all_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p != null">
              <span ng-bind="all_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.sp_title | uppercase"></span>
            </span>
            <span ng-if="all_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p != null">
              <span ng-bind="all_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.sp_title | uppercase"></span>
            </span>
            <span ng-if="all_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p != null">
              <span ng-bind="all_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.sp_title | uppercase"></span>
            </span>
            <span ng-if="all_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p != null">
              <span ng-bind="all_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.sp_title | uppercase"></span>
            </span>

            <!-- NCDDP -->
            <span ng-if="all_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
              <span ng-bind="all_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.sp_title | uppercase"></span>
            </span>
            <span ng-if="all_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null">
              <span ng-bind="all_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.sp_title | uppercase"></span>
            </span>
            <span ng-if="all_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null">
              <span ng-bind="all_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.sp_title | uppercase"></span>
            </span>
            <span ng-if="all_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null">
              <span ng-bind="all_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.sp_title | uppercase"></span>
            </span>
            <span ng-if="all_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null">
              <span ng-bind="all_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.sp_title | uppercase"></span>
            </span>
            <span ng-if="all_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null">
              <span ng-bind="all_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.sp_title | uppercase"></span>
            </span>
          </div>
        </div>
      </div>
      <div class="modal-body pb-0">
        <div class="row">
          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Mode of Procurement </small> </small></label>
              <select class="form-control" id="batch" ng-model="mode_of_procurement">
                  <option value="COMPETITIVE BIDDING - FOR GOODS" selected="true"> COMPETITIVE BIDDING - FOR GOODS </option>
                  <option value="COMPETITIVE BIDDING - FOR INFRASTRUCTURE"> COMPETITIVE BIDDING - FOR INFRASTRUCTURE </option>
                  <option value="NP-53.1 TWO FAILED BIDDINGS"> NP-53.1 TWO FAILED BIDDINGS </option>
                  <option value="NP-53.2 EMERGENCY CASES"> NP-53.2 EMERGENCY CASE </option>
                  <option value="NP-53.5 AGENCY-TO-AGENCY"> NP-53.5 AGENCY-TO-AGENCY </option>
                  <option value="NP-53.9 SMALL VALUE PROCUREMENT"> NP-53.9 SMALL VALUE PROCUREMENT </option>
                  <option value="NP-53.12 COMMUNITY PARTICIPATION"> NP-53.12 COMMUNITY PARTICIPATION </option>
                  <option value="SHOPPING"> SHOPPING </option>
              </select>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> CODE (PAP) </small> </small></label>
              <input ng-model="code" type="text" class="form-control" aria-describedby="codepap" placeholder="Ex. Lot 1...">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Nature of Procurement </small> </small></label>
              <select class="form-control" id="batch" ng-model="nature_of_procurement">
                  <option value="GOODS" selected="true"> GOODS </option>
                  <option value="INFRASTRUCTURE"> INFRASTRUCTURE </option>
                  <option value="LABOR"> LABOR </option>
                  <option value="RENTAL"> RENTAL </option>
              </select>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Source of Funds (WB/GOP) </small> </small></label>
              <select class="form-control" id="batch" ng-model="fund_source">
                  <option value="WB" selected="true"> WB </option>
                  <option value="GOP"> GOP </option>
              </select>
            </div>
          </div>  
          
          <div class="col-lg-12">
            <hr class="my-2">
          </div>       
        </div>

        <div class="row">
          <div class="col-lg-12">
            <h3>Actual Procurement Activity</h3>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Pre-Proc Conference </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined" ng-model="apa_pre_proc_con" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Ads/Post of IAEB </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'SHOPPING' || mode_of_procurement == 'NP-53.2 EMERGENCY CASES' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="apa_ads" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Pre-bid Conf </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.1 TWO FAILED BIDDINGS' || mode_of_procurement == 'NP-53.9 SMALL VALUE PROCUREMENT' || mode_of_procurement == 'SHOPPING' || mode_of_procurement == 'NP-53.2 EMERGENCY CASES' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY' || mode_of_procurement == 'NP-53.12 COMMUNITY PARTICIPATION'" ng-model="apa_prebid_con" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Eligibility Check </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.9 SMALL VALUE PROCUREMENT' || mode_of_procurement == 'SHOPPING' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="apa_eligibility_check" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Sub/Open of Bids </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="apa_open_of_bids" type="date" class="form-control">
            </div>
          </div>


          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Bid Evaluation </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined  || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="apa_bid_eval" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Post Qual </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.9 SMALL VALUE PROCUREMENT' || mode_of_procurement == 'SHOPPING' || mode_of_procurement == 'NP-53.2 EMERGENCY CASES' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY' || mode_of_procurement == 'NP-53.12 COMMUNITY PARTICIPATION'" ng-model="apa_post_qual" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold">BAC Reso. Recom. Award </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="bac_reso_recom_award" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Notice of Award </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'SHOPPING' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="apa_notice_of_award" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Contract Signing </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'SHOPPING' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="apa_contract_signing" type="date" class="form-control">
            </div>
          </div>


          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Notice to Proceed </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.9 SMALL VALUE PROCUREMENT' || mode_of_procurement == 'SHOPPING' || mode_of_procurement == 'NP-53.2 EMERGENCY CASES' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="apa_notice_to_proceed" type="date" class="form-control">
            </div>
          </div>

          <!-- PhilGEPS -->
          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> PhilGEPS (NOA)</small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'SHOPPING'" ng-model="date_of_posting_philgeps_noa" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Contract Review Date </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.9 SMALL VALUE PROCUREMENT' || mode_of_procurement == 'SHOPPING' || mode_of_procurement == 'NP-53.12 COMMUNITY PARTICIPATION' || mode_of_procurement == 'NP-53.2 EMERGENCY CASES' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="apa_contract_review_date" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Target Date of Completion </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'SHOPPING'" ng-model="apa_target_date_completion" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Delivery/ Completion </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'SHOPPING'" ng-model="apa_delivery" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Acceptance/ Turnover </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'SHOPPING'" ng-model="apa_acceptance" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Contractors Eval Conducted </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'SHOPPING'" ng-model="apa_contractors_eval_conducted" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Material Delivery Percentage </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined" ng-model="delivery_percentage" type="text" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" price>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Early Procurement Activity? </small> </small></label>
              <select class="form-control" ng-disabled="mode_of_procurement == undefined" ng-model="early_procurement_activity">
                  <option value="YES" selected="true"> YES </option>
                  <option value="NO"> NO </option>
              </select>
            </div>
          </div>

          <div class="col-lg-12">
            <hr class="my-2">
          </div> 
        </div>

        <!-- ABC -->
        <div class="row">
          <div class="col-lg-12">
            <h3>Approved Budget Cost (Php)</h3>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <!-- abc_total -->
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Total = MOOE + CO </small> </small></label>
              @verbatim
              <input value="{{ (abc_co + abc_mooe) | currency : '₱ ' }}"  type="text" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readOnly="true">
              @endverbatim
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> MOOE </small> </small></label>
              <input ng-init="abc_mooe=0" type="text" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readOnly="true">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> CO </small> </small></label>
              <input ng-model="abc_co" type="text" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" price>
            </div>
          </div>
        </div>

        <!-- CONTRACT COST -->
        <div class="row">
          <div class="col-lg-12">
            <h3>Contract Cost (Php)</h3>
          </div>
          
          <div class="col-lg-4">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Total = MOOE + CO </small> </small></label>
              @verbatim
              <input value="{{ (contract_cost_mooe + contract_cost_co) | currency : '₱ ' }}" type="text" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readOnly="true">
              @endverbatim
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> MOOE </small> </small></label>
              <input ng-init="contract_cost_mooe=0" type="text" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" readOnly="true">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> CO </small> </small></label>
              <input ng-model="contract_cost_co" type="text" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" price>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> List of Invited Obervers </small> </small></label> <br>
              <input ng-model="list_of_invited" class="form-control tagsinput" type="text" style="width: 100% !important;border-radius: 0px !important;">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <h3>Date of Receipt of Invitation of Observers</h3>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Pre-bid Conf </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.1 TWO FAILED BIDDINGS' || mode_of_procurement == 'NP-53.12 COMMUNITY PARTICIPATION' || mode_of_procurement == 'NP-53.2 EMERGENCY CASES' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="io_prebid_con" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Eligibility Check </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.1 TWO FAILED BIDDINGS' || mode_of_procurement == 'NP-53.12 COMMUNITY PARTICIPATION' || mode_of_procurement == 'NP-53.2 EMERGENCY CASES' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="io_eligibility_check" type="date" class="form-control">
            </div>
          </div>


          <div class="col-lg-4">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Sub/Open of Bids </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.1 TWO FAILED BIDDINGS' || mode_of_procurement == 'NP-53.12 COMMUNITY PARTICIPATION' || mode_of_procurement == 'NP-53.2 EMERGENCY CASES' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="io_open_of_bids" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Bid Evaluation </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.1 TWO FAILED BIDDINGS' || mode_of_procurement == 'NP-53.12 COMMUNITY PARTICIPATION' || mode_of_procurement == 'NP-53.2 EMERGENCY CASES' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="io_bid_eval" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Post Qual </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.1 TWO FAILED BIDDINGS' || mode_of_procurement == 'NP-53.12 COMMUNITY PARTICIPATION' || mode_of_procurement == 'NP-53.2 EMERGENCY CASES' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="io_post_qual" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-4">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Delivery/ Accept </small> </small></label>
              <input ng-disabled="mode_of_procurement == undefined || mode_of_procurement == 'NP-53.1 TWO FAILED BIDDINGS' || mode_of_procurement == 'NP-53.12 COMMUNITY PARTICIPATION' || mode_of_procurement == 'NP-53.2 EMERGENCY CASES' || mode_of_procurement == 'NP-53.5 AGENCY-TO-AGENCY'" ng-model="delivery" type="date" class="form-control">
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group">
              <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> Remarks (Explaining changes from the APP) </small> </small></label>
              <textarea ng-model="remarks" maxlength="2500" rows="10" cols="50" class="form-control" style="resize: none;"></textarea>
            </div>
          </div>
        </div>


      </div>
      <div class="modal-footer justify-content-between" style="padding: 20px 30px 30px 30px !important;">
        <button type="button" class="btn rounded-0 btn-outline-success mr-auto" ng-click="add_pmr(specific_sp_data.sp_id)">Submit <i class="fa fa-paper-plane-o"></i></button>
        <button type="button" class="btn rounded-0 btn-outline-secondary" data-dismiss="modal">Close <i class="fa fa-times-circle"></i></button>
      </div>
    </div>
  </div>
</div>

<!-- pmr HISTORY -->
<div class="modal fade" id="pmr_history_modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
			<div class="modal-header border-bottom-0">
				<h3 class="modal-title text-left" id="exampleModalLabel">
		        	PMR History <br>
		        	<span class="font-weight-light" ng-bind="specific_sp_data.sp_title"></span>
		        </h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
			</div>
			<div class="modal-body container-fluid">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
						<th scope="col">Created</th>
						<th scope="col">Mode of Procurement</th>
						<th scope="col">Code</th>
						<th scope="col">Status</th>
						<th scope="col">Updated</th>
						<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="data in pmr_data track by $index" style="cursor: pointer;" >
							<th ng-bind="data.created_at | date:'shortDate'"></th>
							<td ng-bind="data.mode_of_procurement"></td>
							<td ng-bind="data.code"></td>
							<td ng-class="{'text-success' : data.status == 'Approved'}" ng-bind="data.status"></td>
							<td ng-bind="data.updated_at | date:'shortDate'"></td>
							<td>
								<button class="btn btn-outline-primary rounded-0" ng-click="fetch_specific_pmr_data(data)" data-dismiss="modal">View <i class="fa fa-eye"></i></button>

								<button class="btn btn-outline-danger rounded-0" ng-click="pmr_delete_lot(data.id)">Delete <i class="fa fa-trash"></i></button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary rounded-0" type="button" data-dismiss="modal">Close <i class="fa fa-times"></i></button>
			</div>
        </div>
    </div>
</div>

<!-- SPECIFIC PMR VIEW -->
<div class="modal fade" id="pmr_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
			    <h2 class="font-weight-bold my-0">PMR for SP ID: <span ng-bind="specific_pmr_data.sp_id"></span> <br>
			    </h2>
			    <h5 class="mb-0 font-weight-light">STATUS: <span style="color:#007bff;" ng-bind="specific_pmr_data.status | uppercase"></span></h5>
			</div>
			<div class="modal-body pb-0">
				<div class="row">
				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Mode of Procurement </small> </label>
				      <p class="mb-0" ng-bind="specific_pmr_data.mode_of_procurement"></p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> CODE (PAP) </small> </label>
				      <p class="mb-0" ng-bind="specific_pmr_data.code"></p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> NATURE OF PROCUREMENT </small> </label>
				      <p class="mb-0" ng-bind="specific_pmr_data.nature_of_procurement"></p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Source of Funds (WB/GOP) </small> </label>
				      <p class="mb-0" ng-bind="specific_pmr_data.fund_source"></p>
				    </div>
				  </div>  
				  
				  <div class="col-lg-12">
				    <hr class="my-2">
				  </div>       
				</div>

				<div class="row">
				  <div class="col-lg-12">
				    <h3>Actual Procurement Activity</h3>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Pre-Proc Conference </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_pre_proc_con != null" ng-bind="specific_pmr_data.apa_pre_proc_con | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_pre_proc_con == null">NOT APPLICABLE</p>
				    </div>
				  </div>    


				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Ads/Post of IAEB </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_ads" ng-bind="specific_pmr_data.apa_ads | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_ads == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Pre-bid Conf </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_prebid_con" ng-bind="specific_pmr_data.apa_prebid_con | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_prebid_con == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Eligibility Check </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_eligibility_check" ng-bind="specific_pmr_data.apa_eligibility_check | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_eligibility_check == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Sub/Open of Bids </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_open_of_bids" ng-bind="specific_pmr_data.apa_open_of_bids | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_open_of_bids == null">NOT APPLICABLE</p>
				    </div>
				  </div>


				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Bid Evaluation </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_bid_eval" ng-bind="specific_pmr_data.apa_bid_eval | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_bid_eval == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Post Qual </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_post_qual" ng-bind="specific_pmr_data.apa_post_qual | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_post_qual == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-3">
					<div class="form-group">
				      <label style="color: #007bff !important;"> <small class="font-weight-bold">BAC Reso. Recom. Award </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.bac_reso_recom_award" ng-bind="specific_pmr_data.bac_reso_recom_award | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.bac_reso_recom_award == null">NOT APPLICABLE</p>
					</div>
				</div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Notice of Award </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_notice_of_award" ng-bind="specific_pmr_data.apa_notice_of_award | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_notice_of_award == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Contract Signing </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_contract_signing" ng-bind="specific_pmr_data.apa_contract_signing | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_contract_signing == null">NOT APPLICABLE</p>
				    </div>
				  </div>


				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Notice to Proceed </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_notice_to_proceed" ng-bind="specific_pmr_data.apa_notice_to_proceed | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_notice_to_proceed == null">NOT APPLICABLE</p>
				    </div>
				  </div>

			      <!-- PhilGEPS -->
			      <div class="col-lg-3">
			        <div class="form-group">
			          <label style="color: #007bff !important;"><small class="col-form-label"> <small class="font-weight-bold"> PhilGEPS (NOA)</small> </small></label>

			          <p class="mb-0" ng-if="philgeps == true" ng-bind="specific_pmr_data.date_of_posting_philgeps_noa | date: 'mediumDate'"></p>

			          <p class="mb-0" ng-if="specific_pmr_data.date_of_posting_philgeps_noa == null || specific_pmr_data.mode_of_procurement == 'SHOPPING' || philgeps == false" >NOT APPLICABLE</p>
			        </div>
			      </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Contract Review Date </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_contract_review_date" ng-bind="specific_pmr_data.apa_contract_review_date | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_contract_review_date == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Target Date of Completion </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_target_date_completion" ng-bind="specific_pmr_data.apa_target_date_completion | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_target_date_completion == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Delivery/ Completion </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_delivery" ng-bind="specific_pmr_data.apa_delivery | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_delivery == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Acceptance/ Turnover </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_acceptance" ng-bind="specific_pmr_data.apa_acceptance | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_acceptance == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Contractors Eval Conducted </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_contractors_eval_conducted" ng-bind="specific_pmr_data.apa_contractors_eval_conducted | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.apa_contractors_eval_conducted == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Material Delivery Percentage </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.delivery_percentage" ng-bind="specific_pmr_data.delivery_percentage | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.delivery_percentage == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-3">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Early Procurement Activity? </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.early_procurement_activity" ng-bind="specific_pmr_data.early_procurement_activity | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.early_procurement_activity == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-12">
				    <hr class="my-2">
				  </div> 
				</div>

				<!-- ABC -->
				<div class="row">
				  <div class="col-lg-12">
				    <h3>Approved Budget Cost (Php)</h3>
				  </div>

				  <div class="col-lg-4">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Total </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.abc_total" ng-bind="specific_pmr_data.abc_total | currency:'₱ '"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.abc_total == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-4">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> MOOE </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.abc_mooe" ng-bind="specific_pmr_data.abc_mooe | currency:'₱ '"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.abc_mooe == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-4">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> CO </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.abc_co" ng-bind="specific_pmr_data.abc_co | currency:'₱ '"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.abc_co == null">NOT APPLICABLE</p>
				    </div>
				  </div>
				</div>

				<!-- CONTRACT COST -->
				<div class="row">
				  <div class="col-lg-12">
				    <h3>Contract Cost (Php)</h3>
				  </div>
				  
				  <div class="col-lg-4">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Total </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.contract_cost_total" ng-bind="specific_pmr_data.contract_cost_total | currency:'₱ '"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.contract_cost_total == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-4">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> MOOE </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.contract_cost_mooe" ng-bind="specific_pmr_data.contract_cost_mooe | currency:'₱ '"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.contract_cost_mooe == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-4">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> CO </small> </label>
				      <p class="mb-0" ng-if="specific_pmr_data.contract_cost_co" ng-bind="specific_pmr_data.contract_cost_co | currency:'₱ '"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.contract_cost_co == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-12">
				    <div class="form-group">
				    	<label style="color:#007bff;"> <small class="font-weight-bold"> List of Invited Obervers </small> </label>
				    	<div class="row">
				    		<div class="col-lg-3" ng-repeat="data in list_of_invited_array track by $index">
								<p class="mb-0" ng-bind="data">
								</p>
				    		</div>
				    	</div>
				    </div>
				  </div>
				</div>

				<div class="row">
				  <div class="col-lg-12">
				    <h3>Date of Receipt of Invitation of Observers</h3>
				  </div>

				  <div class="col-lg-4">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Pre-bid Conf </small> </label>
				      <p class="mb-0" ng-bind="specific_pmr_data.io_prebid_con | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.io_prebid_con == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-4">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Eligibility Check </small> </label>
				      <p class="mb-0" ng-bind="specific_pmr_data.io_eligibility_check | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.io_eligibility_check == null">NOT APPLICABLE</p>
				    </div>
				  </div>


				  <div class="col-lg-4">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Sub/Open of Bids </small> </label>
				      <p class="mb-0" ng-bind="specific_pmr_data.io_open_of_bids | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.io_open_of_bids == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-4">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Bid Evaluation </small> </label>
				      <p class="mb-0" ng-bind="specific_pmr_data.io_bid_eval | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.io_bid_eval == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-4">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Post Qual </small> </label>
				      <p class="mb-0" ng-bind="specific_pmr_data.io_post_qual | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.io_post_qual == null">NOT APPLICABLE</p>
				    </div>
				  </div>

				  <div class="col-lg-4">
				    <div class="form-group">
				      <label style="color:#007bff;"> <small class="font-weight-bold"> Delivery/ Accept </small> </label>
				      <p class="mb-0" ng-bind="specific_pmr_data.delivery | date: 'fullDate'"></p>
				      <p class="mb-0" ng-if="specific_pmr_data.delivery == null">NOT APPLICABLE</p>
				    </div>
				  </div>
				</div>

				<div class="row">
		          <div class="col-lg-12">
		            <div class="form-group">
		              <label style="color:#007bff;"> <small class="font-weight-bold"> Remarks (Explaining changes from the APP) </small> </label>
		              <!-- <p class="mb-0" ng-bind="specific_pmr_data.remarks | uppercase"></p> -->
		              <!-- <p class="mb-0" ng-if="specific_pmr_data.remarks == null">NOT APPLICABLE</p> -->

					<table class="table table-hover" >
						<thead>
						  <tr>
						    <th scope="col">Date</th>
						    <th scope="col">Event</th>
						    <th scope="col">Comments/Issues/Concern/Remarks</th>
						  </tr>
						</thead>
						<tbody>
						  <tr ng-repeat="data in specific_pmr_data.sp_pmr_remarks_logs">
						    <th ng-bind="data.created_at | date:'medium'"></th>
						    <td>
		                      <span ng-if="data.updated_field == 'apa_pre_proc_con'">
		                        ACTUAL PROCUREMENT ACTIVITY - PRE-PROC CONFERENCE
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_ads'">
		                        ACTUAL PROCUREMENT ACTIVITY - ADS/POST of IAEB
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_prebid_con'">
		                        ACTUAL PROCUREMENT ACTIVITY - PRE-BID CONFERENCE
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_eligibility_check'">
		                        ACTUAL PROCUREMENT ACTIVITY - ELIGIBILITY CHECK
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_open_of_bids'">
		                        ACTUAL PROCUREMENT ACTIVITY - OPEN OF BIDS
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_bid_eval'">
		                        ACTUAL PROCUREMENT ACTIVITY - BID EVALUATION
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_post_qual'">
		                        ACTUAL PROCUREMENT ACTIVITY - POST QUAL
		                      </span>
		                      <span ng-if="data.updated_field == 'bac_reso_recom_award'">
		                        ACTUAL PROCUREMENT ACTIVITY - BAC RESOLUTION RECOMMENDING AWARD
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_notice_of_award'">
		                        ACTUAL PROCUREMENT ACTIVITY - NOTICE OF AWARD
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_contract_signing'">
		                        ACTUAL PROCUREMENT ACTIVITY - CONTRACT SIGNING
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_notice_to_proceed'">
		                        ACTUAL PROCUREMENT ACTIVITY - NOTICE TO PROCEED
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_contract_review_date'">
		                        ACTUAL PROCUREMENT ACTIVITY - CONTRACT REVIEW
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_target_date_completion'">
		                        ACTUAL PROCUREMENT ACTIVITY - TARGET DATE OF COMPLETION
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_delivery'">
		                        ACTUAL PROCUREMENT ACTIVITY - DELIVERY/COMPLETION
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_acceptance'">
		                        ACTUAL PROCUREMENT ACTIVITY - ACCEPTANCE
		                      </span>
		                      <span ng-if="data.updated_field == 'io_prebid_con'">
		                        INVITATION OF OBSERVERS - BPRE-BID CONFERENCE
		                      </span>
		                      <span ng-if="data.updated_field == 'io_eligibility_check'">
		                        INVITATION OF OBSERVERS - ELIGIBILITY CHECK
		                      </span>
		                      <span ng-if="data.updated_field == 'io_open_of_bids'">
		                        INVITATION OF OBSERVERS - OPEN OF BIDS
		                      </span>
		                      <span ng-if="data.updated_field == 'io_bid_eval'">
		                        INVITATION OF OBSERVERS - BID EVALUATION
		                      </span>
		                      <span ng-if="data.updated_field == 'io_post_qual'">
		                        INVITATION OF OBSERVERS - POST QUAL
		                      </span>
		                      <span ng-if="data.updated_field == 'delivery'">
		                        INVITATION OF OBSERVERS - DELIVERY/COMPLETION
		                      </span>
		                      <span ng-if="data.updated_field == 'date_of_posting_philgeps_noa'">
		                        ACTUAL PROCUREMENT ACTIVITY - DATE OF POSTING TO PHILGEPS (NOA)
		                      </span>
		                      <span ng-if="data.updated_field == 'apa_contractors_eval_conducted'">
		                        ACTUAL PROCUREMENT ACTIVITY - CONTRACTORS EVALUATION CONDUCTED
		                      </span>
						    </td>
						    <td ng-bind="data.pmr_remarks"></td>
						  </tr>
						</tbody>
					</table>

		            </div>
		          </div>
				</div>

				<div class="row" ng-if="pmr_view_comments_div == true">
					<div class="col mt-2">
						<h3>Procurement Focal Comments/Issues/Concern/Remarks</h3>
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">Created</th>
									<th scope="col">Comments/Issues/Concern/Remarks</th>
									<th scope="col">Status</th>
									<th scope="col">Complied</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="data in specific_pmr_data.sp_pmr_logs">
									<th ng-bind="data.created_at | date:'medium'"></th>
									<td ng-bind="data.pmr_comments"></td>
									<td>
										<div class="btn-group" role="group" aria-label="Basic example">
										  <button type="button" class="btn btn-outline-secondary" ng-class="{'active' : data.status == 'Pending'}">Pending</button>
										  <button type="button" class="btn btn-outline-success" ng-class="{'active' : data.status == 'Complied'}" ng-click="set_pmr_comments_to_complied(data.id,specific_pmr_data.sp_id)">Complied</button>
										</div>
									</td>
									<td ng-bind="data.updated_at | date:'medium'"></td>
								</tr>
							</tbody>
						</table>
						<hr>
					</div>
				</div>


				<div class="row" ng-if="pmr_forupdate_comments_div == true">
					<div class="col mt-2">
						<h3>Procurement Focal Comments/Issues/Concern/Remarks</h3>
						<textarea ng-model="pmr_forupdate_comments" class="form-control text_area" rows="10" maxlength="2500" style="resize: none;overflow-x: auto;"></textarea>
						<br>
						<button ng-show="pmr_forupdate_comments_div == true && pmr_forupdate_comments.length > 0" type="button" class="btn rounded-0 btn-outline-success" ng-click="submit_pmr_focal_comments(specific_pmr_data.id,specific_pmr_data.sp_id,pmr_forupdate_comments)" data-dismiss="modal">Submit <i class="fa fa-paper-plane-o"></i></button>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button ng-if="pmr_view_comments_div == true" type="button" class="btn rounded-0 btn-outline-secondary" ng-click="pmr_forupdate(2)">Back <i class="fa fa-chevron-left"></i></button>

				<button ng-if="pmr_forupdate_comments_div == true" type="button" class="btn rounded-0 btn-outline-secondary" ng-click="pmr_forupdate(2)">Back <i class="fa fa-chevron-left"></i></button>

				<!-- before click sa for update -->
				<div class="form-inline approve_pmr_btn" ng-hide="specific_pmr_data.status == 'Approved'">
					<input type="checkbox" class="form-check-input" id="exampleCheck1" ng-model="checkbox_pmr">
					<label class="form-check-label" for="exampleCheck1"> Approved PMR? </label>
				</div>

				<button ng-hide="specific_pmr_data.status == 'Approved'" ng-disabled="checkbox_pmr == false || checkbox_pmr == NULL"  type="button" class="btn rounded-0 btn-outline-success approve_pmr_btn" ng-click="pmr_approve(specific_pmr_data.id,specific_pmr_data.sp_id)">Approved <i class="fa fa-thumbs-o-up"></i></button>

				<!-- viewing sa comments -->
				<button ng-if="pmr_forupdate_comments_div == false && specific_pmr_data.sp_pmr_logs.length > 0"  type="button" class="btn rounded-0 btn-outline-primary" id="view_comments" ng-click="pmr_view_comments()">View Comments <i class="fa fa-comments"></i></button>
				<!-- viewing sa comments -->

				<button ng-hide="specific_pmr_data.status == 'Approved'" ng-if="pmr_forupdate_comments_div == false || specific_pmr_data.status != 'Approved'"  type="button" class="btn rounded-0 btn-outline-warning" ng-click="pmr_forupdate(1)">Request Update <i class="fa fa-refresh"></i></button>
				<!-- after click sa for update -->

				<!-- ng-if="pmr_forupdate_comments_div == true && pmr_forupdate_comments.length > 0" -->

				<button type="button" class="btn rounded-0 btn-outline-secondary" data-dismiss="modal" ng-click="pmr_forupdate(2)">Close <i class="fa fa-times-circle"></i></button>
			</div>
		</div>
	</div>
</div>