<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| SMS API
|--------------------------------------------------------------------------
*/
// Route::post('/sms', 'SMS_Controller@smsapi');

/*
|--------------------------------------------------------------------------
| WELCOME AND GENERAL ROUTES
|--------------------------------------------------------------------------
*/
Route::view('/downloadables', 'downloadables')->name('downloadables');
Route::get('/downloadables/fetch_my_all_file', 'DAC_Controller@fetch_all_file');
Route::get('/download/{path}', 'Welcome_Controller@download');

Route::get('/Initial_sp_data', 'Welcome_Controller@Initial_sp_data');
Route::get('/get_modalities_sp', 'Welcome_Controller@get_modalities_sp');
Route::get('/show_summary', 'Welcome_Controller@show_summary');
Route::get('/show_summary_percentages/{modality}/{type}', 'Welcome_Controller@show_summary_percentages');

Route::get('/fetch_users_list', 'Users_Controller@fetch_users_list');
Route::view('/rcis', 'rcis')->name('rcis');
Route::view('/about', 'about')->name('about');
Route::view('/modality', 'modality')->name('modality');
Route::view('/summary', 'summary')->name('summary');

Route::get('/fetch_sms_list', 'SMS_Controller@sms_list');

Route::view('/whereabouts', 'whereabouts')->name('whereabouts');
Route::get('/fetch_whereabouts', 'Whereabouts_Controller@get_whereabouts')->name('fetch_whereabouts');
Route::get('/show_info/{id}', 'Whereabouts_Controller@show_info')->name('show_info');

Route::view('/gallery', 'gallery')->name('gallery');
Route::get('/fetch_gallery', 'Gallery_Controller@fetch_gallery')->name('fetch_gallery');
Route::get('/fetch_gallery_Image/{id}','Gallery_Controller@fetch_gallery_Image');

Route::get('/get_profile_photo/{photos_id}', 'Profile_Controller@get_profile_photo');
Route::get('/delete_file/{photos_id}', 'Profile_Controller@get_profile_photo');
/*
|--------------------------------------------------------------------------
| CMFS CONTROLLER ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/fetch_rfr/{sp_id}/{sp_groupings}', 'CMFS_Controller@fetch_rfr');
Route::post('/submit_rfr_findings', 'CMFS_Controller@submit_rfr_findings');
Route::post('/set_findings_complied', 'CMFS_Controller@set_findings_complied');
Route::post('/update_findings_complied', 'CMFS_Controller@update_findings_complied');

Route::get('/fetch_spcr/{sp_id}/{sp_groupings}', 'CMFS_Controller@fetch_spcr');
Route::post('/update_findings_complied_spcr', 'CMFS_Controller@update_findings_complied_spcr');
Route::post('/set_findings_complied_spcr', 'CMFS_Controller@set_findings_complied_spcr');
Route::post('/submit_spcr_findings', 'CMFS_Controller@submit_spcr_findings');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/loginsso/{username}/{oauth}', 'HomeController@loginsso');

Route::middleware(['admin'])->group(function () {

	// dashboard page
	// When
	Route::get('/admin/routes', 'ADMIN_Controller@index')->name('admin');
	// URL TEMPLATE
	Route::get('/admin/routes/dashboard_contents', function () {
		return view('user_admin.dashboard_contents');
	});
	Route::get('/admin/routes/fetch_admin_dashboard', 'ADMIN_Controller@fetch_my_data');
	
	// When
	Route::get('/admin/routes/show_modality', 'ADMIN_Controller@index');
	// URL TEMPLATE
	Route::get('/admin/routes/modality_list', function () {
		return view('user_admin.modality_list');
	});
	// Route::get('/admin/routes/show_modality', 'ADMIN_Controller@show_modality');

	Route::post('/admin/routes/fetch_SP', 'ADMIN_Controller@fetch_SP');
	Route::get('/admin/routes/new_SP', 'ADMIN_Controller@new_SP');

	// When
	Route::get('/admin/routes/show_user_list', 'ADMIN_Controller@index');
	// URL TEMPLATE
	Route::get('/admin/routes/user_list_contents', function () {
		return view('user_admin.user_list');
	});
	Route::get('/admin/routes/user_list', 'ADMIN_Controller@user_list');

	// --------------------------------- files --------------------------------- //
	// When
	Route::get('/admin/routes/files', 'ADMIN_Controller@index');
	// URL TEMPLATE
	Route::get('/admin/routes/file_contents', function () {
	       return view('user_admin.files');
	});

	// MY FILES
	// When
	Route::get('/admin/routes/files/myfiles', 'ADMIN_Controller@index');
	// URL TEMPLATE
	Route::get('/admin/routes/myfiles', function () {
	       return view('user_admin.myfiles');
	});
	Route::get('/admin/routes/files/fetch_my_all_file', 'ADMIN_Controller@fetch_my_all_file');

	// ALL FILES
	// When
	Route::get('/admin/routes/files/allfiles', 'ADMIN_Controller@index');
	// URL TEMPLATE
	Route::get('/admin/routes/allfiles', function () {
	       return view('user_admin.allfiles');
	});
	Route::get('/admin/routes/files/fetch_all_file', 'ADMIN_Controller@fetch_all_file');
	Route::post('/admin/routes/upload_file', 'ADMIN_Controller@upload_file');
	// --------------------------------- files --------------------------------- //

	// PLANNED
	Route::post('/admin/routes/create_planned_logs', 'ADMIN_Controller@create_planned_logs');
	Route::get('/admin/routes/delete_sp_plan/{sp_id}', 'ADMIN_Controller@delete_sp_plan');
	Route::get('/admin/routes/view_planned_sched/{sp_id}', 'ADMIN_RCIS_Controller@view_planned_sched');

	// reports page
	// When
	Route::get('/admin/routes/show_reports', 'ADMIN_Controller@index');
	// URL TEMPLATE
	Route::get('/admin/routes/reports', function () {
	       return view('user_admin.report_contents');
	});
	Route::get('/admin/routes/fetch_reports_modality', 'ADMIN_Controller@fetch_reports_modality');

	Route::get('/admin/routes/fetch_all_for_export', 'ADMIN_Controller@fetch_all_for_export');
	Route::post('/admin/routes/search_data_modal', 'ADMIN_Controller@search_data_modal');


	Route::get('/admin/routes/assign_add_modality/{modality}/{id}', 'ADMIN_Controller@assign_add_modality');
	Route::post('/admin/routes/enroll_user', 'ADMIN_Controller@enroll_user');

	// Route::get('/admin/routes/fetch_modality', 'ADMIN_Controller@fetch_modality');
	Route::get('/admin/routes/fetch_modality/{modality}/{year}', 'ADMIN_Controller@fetch_modality');
	Route::post('/admin/routes/encode_SP', 'ADMIN_Controller@encode_SP');
	Route::post('/admin/routes/assign_SP', 'ADMIN_Controller@assign_SP');

	// profile
	// When
	Route::get('/admin/routes/profile', 'ADMIN_Controller@index');
	// URL TEMPLATE
	Route::get('/admin/routes/my_profiles', function () {
		return view('user_admin.profile_contents');
	});
	Route::get('/admin/routes/show_profile', 'Profile_Controller@show_profile');
	Route::post('/admin/routes/update_profile_photo', 'Profile_Controller@update_profile_photo');
	Route::post('/admin/routes/update_profile_info', 'Profile_Controller@update_profile_info');
	Route::get('/admin/routes/delete_user/{user_id}', 'ADMIN_Controller@delete_user');
	Route::post('/admin/routes/import_to_kce', 'ADMIN_Controller@import_to_kce');

}); //End of ADMIN

Route::middleware(['admin_rcis'])->group(function () {

	Route::get('/admin_rcis/routes', 'ADMIN_RCIS_Controller@index')->name('admin');
	Route::get('/admin_rcis/routes/show_dashboard', 'ADMIN_RCIS_Controller@show_dashboard');

	// profile
	Route::get('/admin_rcis/routes/profile', 'ADMIN_RCIS_Controller@profile');
	Route::get('/admin_rcis/routes/show_profile', 'Profile_Controller@show_profile');
	Route::post('/admin_rcis/routes/update_profile_photo', 'Profile_Controller@update_profile_photo');
	Route::post('/admin_rcis/routes/update_profile_info', 'Profile_Controller@update_profile_info');

	// summary page
	Route::get('/admin_rcis/routes/summary', 'ADMIN_RCIS_Controller@summary');
	Route::get('/admin_rcis/routes/show_summary', 'ADMIN_RCIS_Controller@show_summary');

	// modality page
	Route::get('/admin_rcis/routes/modality', 'ADMIN_RCIS_Controller@modality');
	Route::get('/admin_rcis/routes/fetch_all_modality_sp', 'ADMIN_RCIS_Controller@fetch_all_modality_sp');
	Route::post('/admin_rcis/routes/fetch_search_modality_sp', 'ADMIN_RCIS_Controller@fetch_search_modality_sp');

	// Files
	Route::get('/admin_rcis/routes/downloadables', 'ADMIN_RCIS_Controller@downloadables');
	Route::get('/admin_rcis/routes/fetch_all_file', 'ADMIN_RCIS_Controller@fetch_all_file');
	Route::get('/admin_rcis/routes/fetch_my_all_file', 'ADMIN_RCIS_Controller@fetch_my_all_file');
	Route::post('/admin_rcis/routes/upload_file', 'ADMIN_RCIS_Controller@upload_file');

	Route::post('/admin_rcis/routes/search_data_modal', 'ADMIN_RCIS_Controller@search_data_modal');
	Route::get('/admin_rcis/routes/fetch_all_for_export', 'ADMIN_RCIS_Controller@fetch_all_for_export');
	Route::post('/admin_rcis/routes/show_modal_summary', 'ADMIN_RCIS_Controller@show_modal_summary');
	Route::get('/admin_rcis/routes/view_planned_sched/{sp_id}', 'ADMIN_RCIS_Controller@view_planned_sched');
}); //End of ADMIN

Route::middleware(['rpmo'])->group(function () {
	
	// dashboard page
	// When
	Route::get('/rpmo/routes', 'RPMO_Controller@index')->name('rpmo');
	// URL TEMPLATE
	Route::get('/rpmo/routes/dashboard_contents', function () {
		return view('user_rpmo.dashboard_contents');
	});
	Route::get('/rpmo/routes/fetch_modality', 'RPMO_Controller@fetch_modality');

	// modality page
	// When
	Route::get('/rpmo/routes/show_modality', 'RPMO_Controller@index');

	Route::get('/rpmo/routes/new_module', 'RPMO_Controller@new_module');
	Route::get('/rpmo/routes/new_module_content', 'RPMO_Controller@new_module_content');
	Route::get('/rpmo/routes/new_module_content_table', 'RPMO_Controller@new_module_content_table');
	Route::post('/rpmo/routes/get_sp_details', 'RPMO_Controller@new_module_content_modal');
	Route::post('/rpmo/routes/set_date_start', 'RPMO_Controller@set_date_start');

	// URL TEMPLATE
	Route::get('/rpmo/routes/my_modality_contents', function () { return view('user_rpmo.my_modalities');});
	Route::get('/rpmo/routes/fetch_rpmo_modality_sp/{modality}', 'RPMO_Controller@fetch_rpmo_modality_sp');
	// Route::view('/rpmo/routes/reports', 'reports')->name('reports');
	// Route::view('/rpmo/uploads', 'uploads')->name('uploads');

	// reports page
	// When
	Route::get('/rpmo/routes/show_reports', 'RPMO_Controller@index');
	// URL TEMPLATE
	Route::get('/rpmo/routes/reports', function () { return view('user_rpmo.report_contents');});
	Route::get('/rpmo/routes/fetch_reports_modality', 'RPMO_Controller@fetch_reports_modality');

	Route::get('/rpmo/routes/fetch_all_for_export', 'RPMO_Controller@fetch_all_for_export');
	Route::post('/rpmo/routes/search_data_modal', 'RPMO_Controller@search_data_modal');
	Route::get('/rpmo/routes/fetch_specific_modality_sp_logs_length/{sp_id}', 'RPMO_Controller@fetch_specific_modality_sp_logs_length');
	Route::get('/rpmo/routes/view_planned_sched/{sp_id}', 'RPMO_Controller@view_planned_sched');

	// file page
	// When
	Route::get('/rpmo/routes/files', 'RPMO_Controller@index');
	// URL TEMPLATE
	Route::get('/rpmo/routes/file_contents', function () {return view('user_rpmo.files');});

	// MY FILES
	// When
	Route::get('/rpmo/routes/files/myfiles', 'RPMO_Controller@index');
	// URL TEMPLATE
	Route::get('/rpmo/routes/myfiles', function () {return view('user_rpmo.myfiles');});
	Route::get('/rpmo/routes/files/fetch_my_all_file', 'RPMO_Controller@fetch_my_all_file');
	// ALL FILES
	// When
	Route::get('/rpmo/routes/files/allfiles', 'RPMO_Controller@index');
	// URL TEMPLATE
	Route::get('/rpmo/routes/allfiles', function () {return view('user_rpmo.allfiles');});
	Route::get('/rpmo/routes/files/fetch_all_file', 'RPMO_Controller@fetch_all_file');

	Route::get('/rpmo/routes/show_file', 'RPMO_Controller@show_file');
	Route::post('/rpmo/routes/upload_file', 'RPMO_Controller@upload_file');
	
	Route::post('/rpmo/routes/update_sp_status', 'RPMO_Controller@update_sp_status');
	Route::get('/rpmo/routes/fetch_rpmo_sps', 'RPMO_Controller@fetch_rpmo_sps');
	Route::get('/rpmo/routes/download/{path}', 'RPMO_Controller@download')->name('download');
	Route::get('/rpmo/routes/download_sp_files/{path}', 'RPMO_Controller@download_sp_files')->name('download_sp_files');
	Route::post('/rpmo/routes/delete_file/{id}', 'RPMO_Controller@delete_file')->name('delete_file');
	// profile
	// When
	Route::get('/rpmo/routes/profile', 'RPMO_Controller@index');
	// URL TEMPLATE
	Route::get('/rpmo/routes/my_profiles', function () {
		return view('user_rpmo.profile_contents');
	});
	// Route::get('/rpmo/routes/profile', 'RPMO_Controller@profile');
	Route::get('/rpmo/routes/show_profile', 'Profile_Controller@show_profile');
	Route::post('/rpmo/routes/update_profile_photo', 'Profile_Controller@update_profile_photo');
	Route::post('/rpmo/routes/update_profile_info', 'Profile_Controller@update_profile_info');
}); //End of RPMO

Route::middleware(['dac'])->group(function () {
	// When
	Route::get('/dac/routes', 'DAC_Controller@index')->name('dac');
	// URL TEMPLATE
	Route::get('/dac/routes/dashboard_contents', function () {
        return view('user_dac.dashboard_contents');
	});
	
	// When
	Route::get('/dac/routes/show_modality', 'DAC_Controller@index');
	// URL TEMPLATE
	Route::get('/dac/routes/modality_contents', function () {
	       return view('user_dac.modality_contents');
	});

	Route::get('/dac/routes/fetch_modality', 'DAC_Controller@fetch_modality');
	Route::get('/dac/routes/fetch_subprojects', 'DAC_Controller@fetch_subprojects');

	// Route::get('/dac/routes/show_modality', 'DAC_Controller@index');
	// When
	Route::get('/dac/routes/files', 'DAC_Controller@index');
	// URL TEMPLATE
	Route::get('/dac/routes/file_contents', function () {
	       return view('user_dac.files');
	});

	// MY FILES
	// When
	Route::get('/dac/routes/files/myfiles', 'DAC_Controller@index');
	// URL TEMPLATE
	Route::get('/dac/routes/myfiles', function () {
	       return view('user_dac.myfiles');
	});
	Route::get('/dac/routes/files/fetch_my_all_file', 'DAC_Controller@fetch_all_file');

	// ALL FILES
	// When
	Route::get('/dac/routes/files/allfiles', 'DAC_Controller@index');
	// URL TEMPLATE
	Route::get('/dac/routes/allfiles', function () {
	       return view('user_dac.allfiles');
	});

	Route::get('/dac/routes/files/download/{id}', 'DAC_Controller@download')->name('download');
	Route::get('/dac/routes/files/fetch_all_file', 'DAC_Controller@fetch_all_file');
	Route::post('/dac/routes/files/delete_file', 'DAC_Controller@delete_file');

	Route::post('/dac/routes/upload_file', 'DAC_Controller@upload_file');
	Route::post('/dac/routes/update_subproject_data', 'DAC_Controller@update_subproject_data');
	Route::post('/dac/routes/updating_sp_single_data', 'DAC_Controller@updating_sp_single_data');

	Route::get('/dac/routes/fetch_my_latest_file', 'DAC_Controller@fetch_my_latest_file');
	Route::post('/dac/routes/create_planned_logs', 'DAC_Controller@create_planned_logs');

	Route::get('/dac/routes/Get_Specific_Product_Image/{path}', 'DAC_Controller@Get_Specific_Product_Image');
	Route::post('/dac/routes/download_sp_files/{path}', 'DAC_Controller@download_sp_files')->name('download_sp_files');


	Route::get('/dac/routes/fetch_dac_modality_sp/{modality}', 'DAC_Controller@fetch_dac_modality_sp');
	Route::get('/dac/routes/fetch_reports_modality', 'DAC_Controller@fetch_reports_modality');
	Route::get('/dac/routes/view_planned_sched/{sp_id}', 'DAC_Controller@view_planned_sched');
	
	Route::get('/dac/routes/fetch_specific_modality_sp_logs_length/{sp_id}', 'DAC_Controller@fetch_specific_modality_sp_logs_length');
	// profile
	// When
	Route::get('/dac/routes/profile', 'DAC_Controller@index');
	// URL TEMPLATE
	Route::get('/dac/routes/my_profiles', function () {
		return view('user_dac.profile_contents');
	});
	// Route::get('/dac/routes/profile', 'DAC_Controller@profile');
	Route::get('/dac/routes/show_profile', 'Profile_Controller@show_profile');
	Route::post('/dac/routes/update_profile_photo', 'Profile_Controller@update_profile_photo');
	Route::post('/dac/routes/update_profile_info', 'Profile_Controller@update_profile_info');

	// procurement
	Route::post('/dac/routes/create_pmr', 'DAC_Controller@create_pmr');
	Route::post('/dac/routes/update_pmr', 'DAC_Controller@update_pmr');
	Route::post('/dac/routes/pmr_update_single_data', 'DAC_Controller@pmr_update_single_data');
	Route::view('/dac/routes/reports', 'reports')->name('reports');
	
}); //End of DAC


Route::middleware(['mainstream'])->group(function () {

	Route::get('/mainstream/routes', 'MAINSTREAM_Controller@index')->name('mainstream');
	Route::get('/mainstream/routes/get_spcr_tracks', 'MAINSTREAM_Controller@get_spcr_tracks');


}); //End of mainstream


Route::middleware(['procurement'])->group(function () {

	Route::get('/procurement/routes', 'PROCUREMENT_Controller@index')->name('procurement');
	Route::post('/procurement/routes/upload_file', 'PROCUREMENT_Controller@upload_file');
	
	// Modality	
	Route::get('/procurement/routes/show_modality', 'PROCUREMENT_Controller@show_modality');
	Route::get('/procurement/routes/fetch_modality_dashboard', 'PROCUREMENT_Controller@fetch_modality_dashboard');
	Route::get('/procurement/routes/fetch_modality', 'PROCUREMENT_Controller@fetch_modality');
	Route::post('/procurement/routes/fetch_modality_per_select', 'PROCUREMENT_Controller@fetch_modality_per_select');
	Route::get('/procurement/routes/fetch_specific_sp_pmr_data/{sp_id}', 'PROCUREMENT_Controller@fetch_specific_sp_pmr_data');
	Route::post('/procurement/routes/submit_pmr_focal_comments', 'PROCUREMENT_Controller@submit_pmr_focal_comments');
	Route::post('/procurement/routes/pmr_approve', 'PROCUREMENT_Controller@pmr_approve');
	Route::post('/procurement/routes/pmr_delete_lot', 'PROCUREMENT_Controller@pmr_delete_lot');
	Route::post('/procurement/routes/create_pmr', 'PROCUREMENT_Controller@create_pmr');
	Route::post('/procurement/routes/set_pmr_comments_to_complied', 'PROCUREMENT_Controller@set_pmr_comments_to_complied');

	Route::get('/procurement/routes/fetch_all_modality_sp', 'PROCUREMENT_Controller@fetch_all_modality_sp');
	Route::post('/procurement/routes/fetch_search_modality_sp', 'PROCUREMENT_Controller@fetch_search_modality_sp');
	Route::post('/procurement/routes/search_data_modal', 'PROCUREMENT_Controller@search_data_modal');
	Route::get('/procurement/routes/fetch_all_for_export', 'PROCUREMENT_Controller@fetch_all_for_export');
	Route::post('/procurement/routes/show_modal_summary', 'PROCUREMENT_Controller@show_modal_summary');
	Route::get('/procurement/routes/view_planned_sched/{sp_id}', 'PROCUREMENT_Controller@view_planned_sched');
	
	// PMR
	Route::get('/procurement/routes/fetch_all_pmr', 'PROCUREMENT_Controller@fetch_all_pmr');
	
	// profile
	Route::get('/procurement/routes/show_file', 'PROCUREMENT_Controller@show_file');
	Route::get('/procurement/routes/profile', 'PROCUREMENT_Controller@profile');
	Route::get('/procurement/routes/show_profile', 'Profile_Controller@show_profile');
	Route::post('/procurement/routes/update_profile_photo', 'Profile_Controller@update_profile_photo');
	Route::post('/procurement/routes/update_profile_info', 'Profile_Controller@update_profile_info');
}); //End of procurement
