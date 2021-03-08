<!-- FILTER MODAL -->
<div class="modal inmodal fade" id="filter_modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header py-2 px-3 text-left">
                <span style="font-size: 1.3em;" class="py-0 my-0">
                    Filter Modalities
                </span>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body" style="padding-top: 10px;padding-bottom: 10px;">

                <div class="form-group mb-2">
                    <label><small class="col-form-label"> <small class="font-weight-bold"> Status </small> </small></label>
                    <select class="form-control" id="modality" ng-model="search_status">
                        <option value="NYS"> NYS (NOT YET STARTED)</option>
                        <option value="On-going"> ON-GOING </option>
                        <option value="Completed"> COMPLETED </option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label><small class="col-form-label"> <small class="font-weight-bold"> Modality </small> </small></label>
                    <select class="form-control" id="modality" ng-model="search_modality">
                        @verbatim
                        <option ng-repeat="data in Profile[0].assigned_grouping" value="{{data.sp_groupings[0].id}}">
                            {{data.sp_groupings[0].grouping}}
                        </option>
                        @endverbatim
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
                <button class="btn btn-primary" type="button" data-dismiss="modal" ng-click="search_data_modal(search_status,search_modality,search_year,search_cycle,search_batch,province_data,municipality_data,brgy_data,search_title,search_sp_id)">Generate <i class="fa fa-gears   "></i></button>
                <button class="btn btn-white" type="button" data-dismiss="modal">Cancel <i class="fa fa-times"></i></button>
              </div>
        </div>
    </div>
</div>

