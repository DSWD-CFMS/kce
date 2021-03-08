<!-- UPLOAD -->
<style type="text/css">
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
  height: 38px;
  font-size: 16px;
  color:#007bff;
  line-height: 32px;
  content: 'Drop/Click here to upload files' !important;
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
</style>
<div class="row wrapper white-bg page-heading justify-content-center animated fadeInRight" ng-init="show_profile()">
	<div class="col-lg-9">
		<h2> Uploads </h2>
		<ol class="breadcrumb">
		  <li class="breadcrumb-item">
		    <a href="{{ url('/rpmo/routes') }}" >Dashboard</a>
		  </li>
		  <li class="breadcrumb-item">
		      <strong> Uploads </strong>
		  </li>
		</ol>
	</div>

	<div class="col-lg-3">
		<h3> &nbsp; </h3>
		<div class="input-group">
			<div class="input-group-prepend">
			  <a class="btn btn-outline-secondary rounded-0" href="{{ url('/rpmo/routes/files/myfiles') }}"> My files <i class="fa fa-inbox"></i> </a>
			</div>
			<a class="btn btn-outline-secondary rounded-0" href="{{ url('/rpmo/routes/files/allfiles') }}"> All files <i class="fa fa-files-o"></i> </a>
		</div>
	</div>

	<div class="col-lg-6">
		<div class="py-5 shadow1" style="border-radius: 0.25rem;">
			<div class="form-group">
				<label class="mb-0" for="inputState">Category</label>
				<small id="emailHelp" class="form-text text-muted">These tags helps in grouping your uploaded files</small>
				<select id="inputState" class="form-control" ng-model="uploaded_category">
					<option value="SP_files_BP"> SP files | Building Permit</option>
					<option value="SP_files_FP"> SP files | Fullblown Proposal</option>
					<option value="SP_files_VO"> SP files | Variation Order</option>
					<option value="SP_files_MT"> SP files | Materials Testing</option>
					<option value="SP_files_EMSR"> SP files | ESMR </option>
					<option value="SP_files_CSR"> SP files | CSR </option>
					<option value="SP_files_SPCR"> SP files | SPCR </option>
					<option value="Standard Drawing Plans"> Standard Drawing Plans </option>
					<option value="O&M Feedback Report"> O&M Feedback Report </option>
					<option value="Procurement Documents"> Procurement Documents </option>
					<option value="O&M Blgu certificate"> O&M Blgu certificate </option>
					<option value="O&M Billboard"> O&M Billboard </option>

					<option value="O&M"> O&M </option>
					<option value="Geo-Tagged Photos"> Geo-Tagged Photos </option>
					<option value="Publication"> Publication </option>
					<option value="Monitoring"> Monitoring </option>
					<option value="SI Report"> SI Report </option>

					<option value="Photo Documents"> Photo Documents </option>
					<option value="Field Report"> Field Report </option>
					<option value="Site Validation"> Site Validation </option>
					<option value="Presentation"> Presentation </option>
					<option value="Resolution"> Resolution </option>

					<option value="Spotcheck"> Spotcheck </option>
					<option value="Manuals"> Manuals </option>
					<option value="Letters"> Letters </option>
					<option value="Reports"> Reports </option>
					<option value="Minutes"> Minutes </option>

					<option value="LARR"> LARR </option>
					<option value="Policy"> Policy </option>
					<option value="Video"> Video </option>
					<option value="Memos"> Memos </option>
					<option value="Forms"> Forms </option>

					<option value="NOL"> NOL </option>
					<option value="Monthly Plan"> Monthly Plan </option>
					<option value="Accomplishments"> Accomplishments </option>
					<option value="Others"> Others </option>
				</select>
			</div>

		  <div class="form-group mb-5" ng-show="uploaded_category == 'SP_files_BP' || uploaded_category == 'SP_files_FP' || uploaded_category == 'SP_files_VO' || uploaded_category == 'SP_files_MT' || uploaded_category == 'SP_files_EMSR' || uploaded_category == 'SP_files_CSR' || uploaded_category == 'SP_files_SPCR'">
		    <label for="inputState">Subproject ID</label>
		    <input type="text" class="form-control" ng-model="file_sp_id" name="">
		  </div>

		  <div class="form-group mb-5">
		    <div class="text-center">
		      <input id="customFile" type="file" multiple ng-model="Upload_files" onchange="angular.element(this).scope().fileChanged(this)">
		      <hr>
		      <ul class="list-group mt-3" id="preview" style="max-height: 300px; overflow-y: auto;">
		      </ul>
		    </div>
		  </div>

		  <div class="form-group">
		    <button class="btn btn-primary btn-block" style="border-radius: 0px;" ng-disabled="uploaded_category == null || uploaded_category == '' || file_upload.length == 0 || file_upload.length == null" ng-click="upload_file(uploaded_category,file_sp_id)"> <i class="fa fa-upload"></i> Upload</button>
		  </div>
		</div>
	</div>
</div>

