$(document).ready(function(){
    $('#form-delete').load(function(e){
        e.preventDefault();
        
        var row = $(this).parents('tr');

        var type_id = row.data('type_id');
        var form = $('#form-delete');
        
        if(type_id) {
        	form.attr('action').replace(':USER_ID', type_id);	
        }
    });
});
