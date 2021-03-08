<style type="text/css">
  body.modal-open {
    padding-right: 0 !important;
  }

  .modal{
    padding-right: 0px !important;
  }
  
  .modal-full {
      min-width: 100%;
      margin: 0;
  }

  .modal-full .modal-content {
      min-height: 100vh !important;
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
        			</span>

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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal"> <i class="fa fa-list-alt"></i> View Track History</button>
        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal"> <i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>

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
  <div class="modal-dialog modal-full" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><span ng-bind="(specific_sp_data.sp_title) +' - '+ (specific_sp_data.sp_brgy) +', '+ (specific_sp_data.sp_municipality)"></span></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <canvas id="myChart" style="width: 100%; height: 200px;"></canvas>
        <div class="table-responsive" style="height: 35px;">
          <table class="table" style="margin-bottom: 0px !important;overflow: none !important;">
              <thead class="thead-dark">
                <tr style="font-size: 10px;">
                  <th scope="col" style="">DATE</th>
                  <th scope="col" style="">STATS</th>
                  <th scope="col">ISSUES/PROBLEM</th>
                  <th scope="col">ANALYSIS</th>
                  <th scope="col">REMARKS</th>
                </tr>
              </thead>
              <tbody style="overflow: none !important;">
              </tbody>
          </table>
        </div>

        <div class="table-responsive" style="height: 290px;">
          <table class="table" style="margin-bottom: 0px !important;overflow: none !important;">
              <tbody style="overflow: auto !important;">
                <tr ng-repeat="p_data in planned_sched track by $index">
                  <td>
                    <small class="text-dark font-weight-bold">Target Date</small> <br>
                    <small style="font-weight: bold;" class="text-primary" id="target_date" ng-bind="p_data.sp_logs_planned_target_date | date: 'yyyy/MM/dd'"></small>
                  </td>
                  <td>
                    <small>
                      <span> PLANNED: </span> <b style="color: #fd7e14;" ng-bind="p_data.sp_logs_planned + '%'"></b> <br>
                      <span> ACTUAL: </span> <b ng-if="p_data.sp_logs_actual != null" style="color: #007bff;" ng-bind="p_data.sp_logs_actual + '%'"></b> <br>
                      <span> SLIPPAGE: </span> <b ng-if="p_data.sp_logs_slippage != null" style="color: #dc3545;" ng-bind="p_data.sp_logs_slippage"></b>
                    </small>
                  </td>
                  <td>
                    <small style="font-weight: bold;" ng-if="p_data.sp_logs_issues != '0' && p_data.sp_logs_issues != 0" class="text-success" ng-bind="p_data.sp_logs_issues"></small>
                    <small style="font-weight: bold;" ng-if="p_data.sp_logs_issues == '0' || p_data.sp_logs_issues == 0" class="text-yellow pulsate">NOT APPLICABLE</small>
                  </td>
                  <td>
                    <small style="font-weight: bold;" class="text-success" ng-if="p_data.sp_logs_analysis != '0' && p_data.sp_logs_analysis != 0" ng-bind="p_data.sp_logs_analysis"></small>
                    <small style="font-weight: bold;" class="text-yellow pulsate" ng-if="p_data.sp_logs_analysis == '0' || p_data.sp_logs_analysis == 0">NOT APPLICABLE</small>
                  </td>
                  <td>
                    <small style="font-weight: bold;" ng-if="p_data.sp_logs_remarks != '0' && p_data.sp_logs_remarks != 0" class="text-success" ng-bind="p_data.sp_logs_remarks"></small>
                    <small style="font-weight: bold;" ng-if="p_data.sp_logs_remarks == '0' || p_data.sp_logs_remarks == 0" class="text-yellow pulsate">NOT APPLICABLE</small>
                  </td>
                </tr>
              </tbody>
          </table>
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