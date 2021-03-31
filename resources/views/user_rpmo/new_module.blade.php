<link href="{{ asset('dataTables/datatablesnew.min.css') }}" rel="stylesheet">
<link href="{{ asset('dataTables/w3.css') }}" rel="stylesheet">
<style>

.loading {
	animation: bounceIn 1300ms infinite
}

@keyframes bounceIn {

	from,
	20%,
	40%,
	60%,
	80%,
	to {
		animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
	}

	0% {
		opacity: 0;
		transform: scale3d(0.3, 0.3, 0.3);
	}

	20% {
		transform: scale3d(1.1, 1.1, 1.1);
	}

	40% {
		transform: scale3d(0.9, 0.9, 0.9);
	}

	60% {
		opacity: 1;
		transform: scale3d(1.03, 1.03, 1.03);
	}

	80% {
		transform: scale3d(0.97, 0.97, 0.97);
	}

	to {
		opacity: 1;
		transform: scale3d(1, 1, 1);
	}
}

</style>
<div id='content' style='padding:20px;margin:5px;border:1px solid #f5f5f5;'>
<h4 class='text-center loading'><strong style="color:black;font-size: 20px;">Retrieving Data from the Server...</strong><br><br><i class="fa fa-database  fa-3x fa-fw" style="color:#86ebb8;font-size: 8x;"></i></h4>   
</div>

<div id="id01" class="modal">
	<div class="modal-content">
	<div class="container">
		<span onclick="$ID('id01').style.display='none'"
		class="button display-topright">&times;</span>
		<p>Some text in the Modal..</p>
		<p>Some text in the Modal..</p>
	</div>
	</div>
</div>

<script type="text/javascript" src="{{ asset('/dataTables/datatablesnew.min.js') }}"></script>
<script type="text/javascript" src="s{{ asset('/dataTables/Brorn.min.js') }}"></script>
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
	$ID('id01').style.display='none'
}
</script>