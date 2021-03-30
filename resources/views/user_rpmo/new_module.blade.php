<link href="{{ asset('dataTables/datatablesnew.min.css') }}" rel="stylesheet">

<div id='content' style='padding:20px;margin:5px;border:1px solid #f5f5f5;'>

</div>

<script type="text/javascript" src="{{ asset('/dataTables/datatablesnew.min.js') }}"></script>
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
</script>