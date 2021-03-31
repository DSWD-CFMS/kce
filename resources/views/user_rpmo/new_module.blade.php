<link href="{{ asset('dataTables/datatablesnew.min.css') }}" rel="stylesheet">
<link href="{{ asset('dataTables/w3.css') }}" rel="stylesheet">
<style>

.loading {
	animation: bounceIn 1300ms infinite
}

@keyframes bounceIn {
	from,20%,40%,60%,80%,
	to {animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);}
	0% {opacity: 0;transform: scale3d(0.3, 0.3, 0.3);}
	20% {transform: scale3d(1.1, 1.1, 1.1);}
	40% {transform: scale3d(0.9, 0.9, 0.9);}
	60% {opacity: 1;transform: scale3d(1.03, 1.03, 1.03);}
	80% {transform: scale3d(0.97, 0.97, 0.97);}
	to {opacity: 1;transform: scale3d(1, 1, 1);}
}

</style>
<div id='content' style='padding:20px;margin:5px;border:1px solid #f5f5f5;'>
<h4 class='text-center loading'><strong style="color:black;font-size: 20px;">Retrieving Data from the Server...</strong><br><br><i class="fa fa-database  fa-3x fa-fw" style="color:#86ebb8;font-size: 8x;"></i></h4>   
</div>

<div id="id01" class="x-modal">
	<div class="x-modal-content x-round-large">
		<div class="x-container x-padding">
			<span onclick="$ID('id01').style.display='none'"
			class="x-button x-display-topright x-round-large x-red">&times;</span>
			<h4 class="x-text-blue">Details for SP # : <b id="sp_id_v"></b></h4>
			<div class="x-row x-container">
				<div class="x-container x-col l4 s4 m4">
					<h4 class="x-row">Date Started</h4>
					<div class="x-row">
						<input type="date" class="x-col s7 m7 l7 x-input x-border" name="started_date" id="started_date">
						<button class="x-col s5 m5 l5 x-btn x-blue x-round-large">Set Date</button>
					</div>
				</div>
			</div>
			<hr>
			<div class="x-container x-padding x-row">
				<button class="x-btn x-round-large x-orange">RFR Tracking</button>
				<button class="x-btn x-round-large x-blue">History</button>
				<button class="x-btn x-round-large x-green">SPcr Tracking</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="{{ asset('/dataTables/datatablesnew.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/dataTables/Brorn.min.js') }}"></script>
<script>
$.ajax({
	type:'GET',
	url:'new_module_content_table',
	success: function(data){
		$('#content').html(data);
		$('#table_details').DataTable({
			 'processing': true,
			 'dom': 'lBfrtip',
			 'buttons': [
				{
					extend: 'collection',
					text: 'Export to...',
					buttons: [
						'copy',
						'excel',
						'csv',
						'pdf',
						'print'
					]
				}
			]
		});
	}
});

function det_modal(res){
	$ID('sp_id_v').innerHTML = res
	$ID('id01').style.display='block'

	$send({
		action:'/rpmo/routes/get_sp_details',
		data : $DATA({'data':res}),
		method : POST,
		_async : true,
		headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		func : function(res){
			$print(res)
		}
	})

}
</script>