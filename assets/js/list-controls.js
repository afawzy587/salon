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
    $(document).ready(function(){$('input.time').timepicker({});});
    $('.table').on('click','a.status_active',function(){
		data          = $(this).parent('span').attr('id');
        activtion     = $('#activtion').val();
        deactivtion   = $('#deactivtion').val();
        deactive      = $('#deactive').val();
        active        = $('#active').val();
              var result = data.split('|');
              var id         =    result[3] ;
              var status     =    result[4] ;
		if (confirm($('#lang_status').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type  :"POST",
				url   :"products_js.php?do=status",
				data  :  "data=" + data,
				success : function(message) {
				if(message == 1190)
				{
                    if(status == 1)
                    {
                        result[4] =  0;
                        result      = result.join("|");
                        $("#td_" + id).html("<span id="+result+"><a class='btn btn-danger btn-sm status_active' style='color:white;border-radius:12px;'   title="+activtion+">"+deactive+"</a></span>");
                        $("#td_" + id).animate({height: 'auto', opacity: '0.2'}, "slow");
                        $("#td_" + id).animate({width: 'auto', opacity: '0.9'}, "slow");
                        $("#td_" + id).animate({height: 'auto', opacity: '0.2'}, "slow");
                        $("#td_" + id).animate({width: 'auto', opacity: '1'}, "slow");
                    }else if(status == 0)
                     {
                        result[4]   =  1;
                        result      = result.join("|");
                        $("#td_" + id).html("<span id="+result+"><a class='btn btn-success btn-sm status_active' style='color:white;border-radius:12px;'   title="+deactivtion+">"+active+"</a></span>");
                        $("#td_" + id).animate({height: 'auto', opacity: '0.2'}, "slow");
                        $("#td_" + id).animate({width: 'auto', opacity: '0.9'}, "slow");
                        $("#td_" + id).animate({height: 'auto', opacity: '0.2'}, "slow");
                        $("#td_" + id).animate({width: 'auto', opacity: '1'}, "slow");
                     }


				}else if(message == 111)
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
    $('a.status_order').click(function(e){
        e.preventDefault();
		data   = $(this).parent('span').attr('id');
        admin_cancel   = $('#admin_cancel').val();
        finished       = $('#finished').val();
        var result     = data.split('|');
        var id         =    result[3] ;
        var status     =    result[4] ;
		if (confirm($('#lang_status').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type  :"POST",
				url   :"products_js.php?do=status_order",
				data  :  "data=" + data,
				success : function(data) {
				if(data == 1190)
				{
                    if(status == 0)
                    {

                        $("#td_" + id).html("<a style='color:#f44336;'>"+admin_cancel+"<i class='material-icons success'>remove_shopping_cart</i></a>");
                        $("#td_" + id).animate({height: 'auto', opacity: '0.2'}, "slow");
                        $("#td_" + id).animate({width: 'auto', opacity: '0.9'}, "slow");
                        $("#td_" + id).animate({height: 'auto', opacity: '0.2'}, "slow");
                        $("#td_" + id).animate({width: 'auto', opacity: '1'}, "slow");
                    }else if(status == 2)
                     {
                        $("#td_" + id).html("<a style='color:#1fcc26;'>"+finished+"<i class='material-icons success'>check_circle</i></a>");
                         $("#td_" + id).animate({height: 'auto', opacity: '0.2'}, "slow");
                        $("#td_" + id).animate({width: 'auto', opacity: '0.9'}, "slow");
                        $("#td_" + id).animate({height: 'auto', opacity: '0.2'}, "slow");
                        $("#td_" + id).animate({width: 'auto', opacity: '1'}, "slow");
                     }
//					setTimeout(location.reload(), 1000);

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
    function redirectNow(){
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
    $(".choose").select2( {} );
    $('a.addrequest').click(function(e){
	e.preventDefault();
		jQuery.ajax( {
			async :true,
			type :"POST",
			url :'products_js.php?do=request',
			success:function(html){
				$('tbody.request').append(html);
			},
			error : function() {
				return true;
			}
		});
	});
    $('.request').on('change', 'select.product',function(){
	var productID = $(this).val();
	var id        = $(this).parent('div').attr('id');
	if(productID){
		$.ajax({
			type:'POST',
			url:'products_js.php?do=product_price',
			data:'product_id='+productID,
			success:function(data){
				$('input#price_'+id).val(data);
								  }
			   });
				  }
	});
    $('.request').on('click','a.delete_order_product',function(e){
        e.preventDefault();
		id  = $(this).parent('td').attr('id').replace("item_","");
        console.log (id);
		if (confirm($('#lang_del').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :"products_js.php?do=delete_order_product",
				data: "id=" + id + "",
				success : function(data) {
                    if(data == 116)
                    {
                        $("#tr_" + id).fadeTo(400, 0, function () { $("#tr_" + id).slideUp(400);});
                        setTimeout(location.reload(), 1000);
                        return false;
                    }


				},
				error : function() {
					return true;
				}
			});
		}
	});
    $('.request').on('click','a.delete_order_service',function(e){
        e.preventDefault();
		id  = $(this).parent('td').attr('id').replace("item_","");
		if (confirm($('#lang_del').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :"products_js.php?do=delete_order_service",
				data: "id=" + id + "",
				success : function(data) {
                    if(data == 116)
                    {
                        $("#tr_" + id).fadeTo(400, 0, function () { $("#tr_" + id).slideUp(400);});
                        setTimeout(location.reload(), 1000);
                        return false;
                    }


				},
				error : function() {
					return true;
				}
			});
		}
	});
    $('.request').on('click', 'a.delete_product',function(e){
        e.preventDefault();
      $(this).closest('tr').remove();
	});
    $('.request').on('click', 'a.delete_service',function(e){
        e.preventDefault();
      $(this).closest('tr').remove();
	});
    $('.request').on('change', 'select.service',function(){
        $("input.date").datetimepicker({
		format:"Y-m-d H:i:s",
		validateOnBlur: false,
		step:15
	});
	var serviceID = $(this).val();
	var id        = $(this).parent('div').attr('id');
	if(serviceID){
		$.ajax({
			type:'POST',
			url:'products_js.php?do=service_price',
			data:'service_id='+serviceID,
			success:function(data){
				$('input#price_'+id).val(data);
								  }
			   });
				  }
	});
    $('select.branch').on('change',function(){
	var branchID = $(this).val();
	if(branchID){
		$.ajax({
			type:'POST',
			url:'products_js.php?do=branch_staff',
			data:'branch_id='+branchID,
			success:function(html){
				$('select.staff').html(html);
								  }
			   });
				  }
	});
    $('.services').on('click', 'a.addservice',function(e){
        e.preventDefault();
        var branchID = $('select.branch').val();
            jQuery.ajax( {
                async :true,
                type :"POST",
                url :'products_js.php?do=service',
                data:'branch_id='+branchID,
                success:function(html){
                    $('tbody.request').append(html);
                },
                error : function() {
                    return true;
                }
            });
        });
    var clicked = false;
    $(".checkall").on("click", function() {
      $(".checkhour").prop("checked", !clicked);
      clicked = !clicked;
    });
});
