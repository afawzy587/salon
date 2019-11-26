$(document).ready(function(){
	
   
    $("input.date").datetimepicker({
		format:"Y-m-d H:i:s",
		validateOnBlur: false,
		step:15
	});
	$("input.onlytime").datetimepicker({
		datepicker:false,
        format:'H:i:00',
		step:15
	});
   
    $(document).ready(function(){
    $('input.time').timepicker({});
});

    $('a.status_active').click(function(e){
        e.preventDefault();
		page=$('#page').val();
	    id     = $(this).parent('span').attr('id').replace("active_","");
		status = $(this).parent('span').attr('class').replace("sta_","");
		if (confirm($('#lang_status').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=status",
				data:  "id=" + id + "&status="+ status,
				success : function(data) {
				if(data == 1190)
				{
					setTimeout(location.reload(), 1000);
					$("a.status_active").attr("title","تم التفعيل");
					$("a.status_active#"+id+"").attr("class","badge bg-success");
							   

				}else if(data == 111)
				{
					alert("we can't Active default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
		});

	$('a.status_deactive').click(function(e){
        e.preventDefault();
		page=$('#page').val();
	    id     = $(this).parent('span').attr('id').replace("active_","");
		status = $(this).parent('span').attr('class').replace("sta_","");
		if (confirm($('#lang_status').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=status",
				data:  "id=" + id + "&status="+ status,
				success : function(data) {
				if(data == 1190)
				{
					setTimeout(location.reload(), 1000);
					$("a.status_deactive").attr("title"," غير مفعل");
					$("a.status_deactive#"+id+"").attr("class","badge bg-danger");
				}else if(data == 111)
				{
					alert("we can't Active default items.");
				}
				},
				error : function() {
					return true;
				}
			});
		}
	});

    
	$('button.delete').click(function(e){
        e.preventDefault();
		page=$('#page').val();
		id  = $(this).parent('td').attr('id').replace("item_","");
		
		if (confirm($('#lang_del').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=delete",
				data: "id=" + id + "",
				success : function() {
                   
					$("#tr_" + id).fadeTo(400, 0, function () { $("#tr_" + id).slideUp(400);});
				
				},
				error : function() {
					return true;
				}
			});
		}
	});
    
    
    $('button.delete_service').click(function(e){
        e.preventDefault();
		page=$('#page').val();
		id = $(this).parent('td').attr('id').replace("item_","");
        del = $(this).parent('td').attr('class').replace("td-actions text-right del_","");
		if (confirm($('#lang_del').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=delete_service",
				data: "id=" + id + "",
				success : function() {
                   
					$("#tr_" + del).fadeTo(400, 0, function () { $("#tr_" + del).slideUp(400);});
				
				},
				error : function() {
					return true;
				}
			});
		}
	});
    



	$('button.edit').click(function(e){
        e.preventDefault();
		page=$('#page').val();
		id = $(this).parent('td').attr('id').replace("item_","");
		window.location = page+"_edit.php?id=" + id;
	});


	$('button.view').click(function(e){
        e.preventDefault();
		page=$('#page').val();
		id = $(this).parent('td').attr('id').replace("item_","");
		window.location = page+".html?do=view&id=" + id;
	});

	function redirectNow()
	{
		window.location= page+'.html';
	}

	$('a.delete').click(function(e){
        e.preventDefault();
		page=$('#page').val();
		id = $(this).parent('div').attr('id').replace("item_","");
		if (confirm($('#lang_del').val()+" "+$('#lang_name').val().toLowerCase()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".html?do=delete",
				data: "id=" + id + "",
				success : function(data) {
				if(data == 116)
				{
			        setTimeout(redirectNow, 1000);
			        return false;
				}
			},
			error : function() {
					return true;
				}
			});
		}
	});
	
$(document).on("click", ".browse", function() {
  var file = $(this).parents().find(".file");
  file.trigger("click");
});
$('input[type="file"]').change(function(e) {
  var fileName = e.target.files[0].name;
  $("#file").val(fileName);

  var reader = new FileReader();
  reader.onload = function(e) {
    // get loaded data and render thumbnail.
    document.getElementById("preview").src = e.target.result;
  };
  // read the image file as a data URL.
  reader.readAsDataURL(this.files[0]);
});


});