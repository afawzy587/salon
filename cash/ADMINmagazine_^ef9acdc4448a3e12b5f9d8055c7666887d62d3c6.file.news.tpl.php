<?php /* Smarty version Smarty-3.0.8, created on 2019-10-19 17:48:44
         compiled from "C:\xampp\htdocs\icouna\inc\..\assets\themes\admin\internal/news.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13050008725dab305c770192-14505875%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ef9acdc4448a3e12b5f9d8055c7666887d62d3c6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\icouna\\inc\\..\\assets\\themes\\admin\\internal/news.tpl',
      1 => 1571440235,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13050008725dab305c770192-14505875',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
	<?php if ($_smarty_tpl->getVariable('area_name')->value=='list'){?>
	<input type="hidden" value="news" id="page">
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['new'];?>
" id="lang_name">
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['delete_alarm_massage_in_men'];?>
" id="lang_del">
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['status_alarm_massage_in_men'];?>
" id="lang_status">

	<ol class="breadcrumb">
		<li>
			<a href="index.html"><i class="ti-home ml5"></i><?php echo $_smarty_tpl->getVariable('lang')->value['NDX_PAGE_NAME'];?>
</a>
		</li>
		<li class="active"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</li>
	</ol>
	<div class="row mt">
		<div class="col-md-12">
			<?php if ($_smarty_tpl->getVariable('success')->value){?><div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('success')->value;?>
</div><?php }?>
			<section class="panel">
				<div class="panel-heading no-b">
					<h5><?php echo $_smarty_tpl->getVariable('lang')->value['list'];?>
 <b><?php echo $_smarty_tpl->getVariable('lang')->value['news'];?>
</b></h5>
				</div>
				<div class="panel-body">
				<div class="table-responsive">
					<table class="tableau_eleves table table-bordered table-striped">
					<?php if ($_smarty_tpl->getVariable('u')->value){?>
						<thead>
							<tr>
								<th>#</th>
								<th> <?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
</th>
								<th> <?php echo $_smarty_tpl->getVariable('lang')->value['new'];?>
</th>
								<th> <?php echo $_smarty_tpl->getVariable('lang')->value['comments'];?>
</th>
								<th> <?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
 </th>
								<th> <?php echo $_smarty_tpl->getVariable('lang')->value['settings'];?>
</th>
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars["c"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('u')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["c"]->key => $_smarty_tpl->tpl_vars["c"]->value){
?>
								<tr id="tr_<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
">
									<td><?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
</td>
									<td>
										<a href="news.html?do=view&id=<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
"><span style="width:150px"><?php echo $_smarty_tpl->getVariable('c')->value['title'];?>
</span></a> <br />
									</td>
									<td >

										<a href="news.html?do=view&id=<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
" ><span style="display:block;width:auto;height:100px;overflow:auto; white-space: rap;"><?php echo br2nl($_smarty_tpl->getVariable('c')->value['text']);?>
</span></a> <br />
									</td>
									<td>
										<a class="btn btn-primary btn-xs " title="<?php echo $_smarty_tpl->getVariable('lang')->value['comments'];?>
 " onClick="window.location='news.html?do=comment&id=<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
'"><i class="fa fa-comment"></i></a>
									</td>
									<td>
										<span  id="active_<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
" class="sta_<?php echo $_smarty_tpl->getVariable('c')->value['status'];?>
">
											<?php if ($_smarty_tpl->getVariable('c')->value['status']==1){?>
											<a class="badge bg-success status_deactive" id="<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
"  title="<?php echo $_smarty_tpl->getVariable('lang')->value['deactivation'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
</a>
											<?php }else{ ?><a class="badge bg-danger status_active" id="<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['activation'];?>
"> <?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
 </a>
											<?php }?>
										</span>	
									</td>
									<td id="item_<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
">
											<button class="btn btn-primary btn-xs edit" title="<?php echo $_smarty_tpl->getVariable('lang')->value['edit'];?>
"><i class="fa fa-pencil"></i></button>
											<button class="btn btn-danger btn-xs delete" title="<?php echo $_smarty_tpl->getVariable('lang')->value['delete'];?>
"><i class="fa fa-trash-o"></i></button>
									</td>
								</tr>
							<?php }} ?>
						</tbody>
						<?php }else{ ?>
						<tbody>
						<td align="center" colspan="5"><b><?php echo $_smarty_tpl->getVariable('lang')->value['no_news'];?>
</b></td>
						</tbody><?php }?>
						<tfoot>
							<tr>
								<td colspan="5" align="right"><?php echo $_smarty_tpl->getVariable('pager')->value;?>
</td>
								<td colspan="1" align="left"><a class="btn btn-success btn-sm pull-left" href="news.html?do=add"><?php echo $_smarty_tpl->getVariable('lang')->value['add_new'];?>
 </a></td>
							</tr>
						</tfoot>
					</table>

				  </div>
				</div>
			</section>
		</div>
	</div>
<?php }elseif($_smarty_tpl->getVariable('area_name')->value=='edit'){?>
	<ol class="breadcrumb">
		<li>
			<a href="index.html"><i class="ti-home ml5"></i><?php echo $_smarty_tpl->getVariable('lang')->value['NDX_PAGE_NAME'];?>
</a>
		</li>
		<li class="active"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</li>
	</ol>
	<div class="row">
		<div class="col-lg-12">
		<?php if ($_smarty_tpl->getVariable('success')->value){?>
			<div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('success')->value;?>
</div>
		<?php }else{ ?>
			<?php if ($_smarty_tpl->getVariable('errors')->value){?>
				<div class="alert alert-danger">
					<ul>
					<?php  $_smarty_tpl->tpl_vars["e"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["e"]->key => $_smarty_tpl->tpl_vars["e"]->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars["e"]->key;
?>
						<li><strong><?php echo $_smarty_tpl->getVariable('e')->value;?>
</strong></li>
					<?php }} ?>
					</ul>
				</div>
			<?php }?>
		<?php }?>
		<section class="panel">
			<header class="panel-heading"><?php echo $_smarty_tpl->getVariable('lang')->value['edit_new'];?>
 ( # <?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
 )</header>
			<div class="panel-body">
			<form class="form-horizontal" role="form" method="post" action="news.html?do=update&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
" enctype="multipart/form-data">
				<div class="form-group">
					<div class="col-sm-10">
						<input type="text" class="form-control" name="title" placeholder=" <?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
 " value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['title'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['title'];?>
<?php }?>">
					</div>
					<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
</label>
				</div>

				<div class="form-group">
					<div class="col-sm-10">
						<textarea class=" form-control" rows="5" name="text" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['news_description'];?>
 "><?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo br2nl($_smarty_tpl->getVariable('n')->value['text']);?>
<?php }else{ ?><?php echo br2nl($_smarty_tpl->getVariable('u')->value['text']);?>
<?php }?></textarea>
					</div>
					<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['news_description'];?>
</label>
				</div>

				<div class="form-group">
					<div class="col-sm-10">
						<input type="file" class=" form-control" name="icon" value="">
						<?php if ($_smarty_tpl->getVariable('u')->value['image']){?><p class="help-block"><a target="_blank" href="<?php echo $_smarty_tpl->getVariable('path_img')->value;?>
<?php echo $_smarty_tpl->getVariable('u')->value['image'];?>
">   <?php echo $_smarty_tpl->getVariable('lang')->value['show_image'];?>
 </a></p><?php }?>
					</div>
					<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['image'];?>
</label>
				</div>
				<div class="form-group"  >
					<div class="col-sm-10">
						<input  autocomplete="off" class="date form-control" style="text-align: right" name="date" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['_date'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['date'];?>
<?php }?>">
					</div>
					<label class="col-sm-2 control-label"> <?php echo $_smarty_tpl->getVariable('lang')->value['date'];?>
</label>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
					<select class="form-control" name="category_id">
							<option value=0> <?php echo $_smarty_tpl->getVariable('lang')->value['CHOOSE'];?>
</option>
							<?php  $_smarty_tpl->tpl_vars["_c"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('c')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["_c"]->key => $_smarty_tpl->tpl_vars["_c"]->value){
?>
								<option value="<?php echo $_smarty_tpl->getVariable('_c')->value['id'];?>
"<?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['category_id']==$_smarty_tpl->getVariable('_c')->value['id']){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['category_id']==$_smarty_tpl->getVariable('_c')->value['id']){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('_c')->value['name'];?>
</option>
							<?php }} ?>
						</select>
					</div>
					<label class="col-sm-2 control-label">  <?php echo $_smarty_tpl->getVariable('lang')->value['news_category'];?>
   </label>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
						<select class="form-control" name="slider">
							<option value="0" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['slider']==0){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['slider']==0){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['normal_news'];?>
</option>
							<option value="1" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['slider']==1){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['slider']==1){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['main_news'];?>
</option>
						</select>
					</div>
					<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['new_kind'];?>
</label>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
						<select class="form-control" name="status">
							<option value="0" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['status']==0){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['status']==0){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
</option>
							<option value="1" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['status']==1){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['status']==1){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
</option>
						</select>
					</div>
					<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
</label>
				</div>
				<div class="form-group">
					<div class="col-sm-10"><button type="submit" class="btn btn-default"><?php echo $_smarty_tpl->getVariable('lang')->value['update'];?>
</button></div>
				</div>
			</form>
			</div>
		</section>
		</div>
	</div>
<?php }elseif($_smarty_tpl->getVariable('area_name')->value=='view'){?>
	<input type="hidden" value="news" id="page">
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['new'];?>
" id="lang_name">
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['delete_alarm_massage_in_men'];?>
" id="lang_del">
	<ol class="breadcrumb hidden-print">
		<li>
			<a href="index.html"><i class="ti-home ml5"></i><?php echo $_smarty_tpl->getVariable('lang')->value['NDX_PAGE_NAME'];?>
</a>
		</li>
		<li class="active"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</li>
	</ol>
	<div class="row">
		<div class="col-lg-12">
		<?php if ($_smarty_tpl->getVariable('success')->value){?>
			<div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('success')->value;?>
</div>
		<?php }else{ ?>
			<?php if ($_smarty_tpl->getVariable('errors')->value){?>
				<div class="alert alert-danger">
					<ul>
					<?php  $_smarty_tpl->tpl_vars["e"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["e"]->key => $_smarty_tpl->tpl_vars["e"]->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars["e"]->key;
?>
						<li><strong><?php echo $_smarty_tpl->getVariable('e')->value;?>
</strong></li>
					<?php }} ?>
					</ul>
				</div>
			<?php }?>
		<?php }?>
		<section class="panel">
			<header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['new_details'];?>
 ( # <?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
 )</header>
			<div class="panel-body">
			<form class="form-horizontal" role="form" method="post" action="news.html?do=update&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
">
				<div class="alert alert-info">
					<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
 : </strong></span>
					<span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['title'];?>
</span>
				</div>
				<div class="alert alert-info">
					<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['new'];?>
 : </strong></span>
					<span style="width:80%;display:inline-block;"><?php echo br2nl($_smarty_tpl->getVariable('u')->value['text']);?>
</span>
				</div>
				<div class="alert alert-info">
					<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['image'];?>
 : </strong></span>
					<span style="width:80%;display:inline-block;"><a href="<?php echo $_smarty_tpl->getVariable('path_img')->value;?>
<?php echo $_smarty_tpl->getVariable('u')->value['image'];?>
" target="_blank"><img style="border-radius:5px;" src="<?php echo $_smarty_tpl->getVariable('path_img')->value;?>
<?php echo $_smarty_tpl->getVariable('u')->value['image'];?>
" width="100" /></a></span>
				</div>
				<div class="alert alert-info">
					<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['date'];?>
 : </strong></span>
					<span style="width:80%;display:inline-block;"><?php echo _date_format($_smarty_tpl->getVariable('u')->value['date']);?>
</span>
				</div>

				<div class="alert alert-info">
					<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['news_category'];?>
 : </strong></span>
					<span style="width:80%;display:inline-block;"><?php echo getcategoryname($_smarty_tpl->getVariable('u')->value['category_id']);?>
</span>
				</div>
				<div class="alert alert-info">
					<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['Write_by'];?>
 : </strong></span>
					<span style="width:80%;display:inline-block;"><?php echo getusername($_smarty_tpl->getVariable('u')->value['user_id']);?>
</span>
				</div>
				<div class="alert alert-info">
					<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['new_kind'];?>
 : </strong></span>
					<span style="width:80%;display:inline-block;"><?php if ($_smarty_tpl->getVariable('u')->value['slider']==0){?> <?php echo $_smarty_tpl->getVariable('lang')->value['normal_news'];?>
<?php }else{ ?> <?php echo $_smarty_tpl->getVariable('lang')->value['main_news'];?>
<?php }?></span>
				</div>
				<div class="alert alert-info">
					<span style="width:20%;display:inline-block;vertical-align:top;"><strong> <?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
  : </strong></span>
					<span style="width:75%;display:inline-block;"><?php if ($_smarty_tpl->getVariable('u')->value['status']==0){?><i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">  <?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
   </i><?php }else{ ?><i class="fa fa-check"style="font-size:18px"  dir="ltr">   <?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
 </i><?php }?></span>
				</div>
				<div class="form-group" id="item_<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
">
					<a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();" style="margin-<?php echo $_smarty_tpl->getVariable('lang')->value['dir_fe'];?>
: 20px"><?php echo $_smarty_tpl->getVariable('lang')->value['print'];?>
</a>
						<a class="hidden-print btn btn-warning btn-sm" href="news.html?do=edit&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['edit'];?>
</a>
						<a class="hidden-print btn btn-danger btn-sm delete" href="news.html?do=del&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['delete'];?>
 </a>
				</div>
			</form>
			</div>
		</section>
		</div>
	</div>
<?php }elseif($_smarty_tpl->getVariable('area_name')->value=='add'){?>
	<ol class="breadcrumb">
		<li>
			<a href="index.html"><i class="ti-home ml5"></i><?php echo $_smarty_tpl->getVariable('lang')->value['NDX_PAGE_NAME'];?>
</a>
		</li>
		<li class="active"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</li>
	</ol>
	<div class="row">
		<div class="col-lg-12">
		<?php if ($_smarty_tpl->getVariable('success')->value){?>
			<div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('success')->value;?>
</div>
		<?php }else{ ?>
			<?php if ($_smarty_tpl->getVariable('errors')->value){?>
				<div class="alert alert-danger">
					<ul>
					<?php  $_smarty_tpl->tpl_vars["e"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["e"]->key => $_smarty_tpl->tpl_vars["e"]->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars["e"]->key;
?>
						<li><strong><?php echo $_smarty_tpl->getVariable('e')->value;?>
</strong></li>
					<?php }} ?>
					</ul>
				</div>
			<?php }?>
		<?php }?>
		<section class="panel">
			<header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['add_new'];?>
</header>
			<div class="panel-body">
			<form class="form-horizontal" role="form" method="post" action="news.html?do=add" enctype="multipart/form-data">
				<div class="form-group">
					<div class="col-sm-10">
						<input type="text" class="form-control" name="title" placeholder=" <?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
 " value="<?php echo $_smarty_tpl->getVariable('n')->value['title'];?>
">
					</div>
					<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
</label>
				</div>

				<div class="form-group">
					<div class="col-sm-10">
						<textarea class="form-control" rows="5" name="text" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['news_description'];?>
 "><?php echo br2nl($_smarty_tpl->getVariable('n')->value['text']);?>
</textarea>
					</div>
					<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['news_description'];?>
</label>
				</div>

				<div class="form-group">
					<div class="col-sm-10">
						<input type="file" class=" form-control" name="icon" value="">
					</div>
					<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['image'];?>
</label>
				</div>
				<div class="form-group"  >
					<div class="col-sm-10">
						<input  autocomplete="off" class="date form-control" style="text-align: right" name="date" value="<?php echo $_smarty_tpl->getVariable('n')->value['date'];?>
">
					</div>
					<label class="col-sm-2 control-label"> <?php echo $_smarty_tpl->getVariable('lang')->value['date'];?>
</label>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
					<select class="form-control" name="category_id">
							<option value=0> <?php echo $_smarty_tpl->getVariable('lang')->value['CHOOSE'];?>
</option>
							<?php  $_smarty_tpl->tpl_vars["_c"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('c')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["_c"]->key => $_smarty_tpl->tpl_vars["_c"]->value){
?>
								<option value="<?php echo $_smarty_tpl->getVariable('_c')->value['id'];?>
"<?php if ($_smarty_tpl->getVariable('_c')->value['id']==$_smarty_tpl->getVariable('n')->value['category_id']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('_c')->value['name'];?>
</option>
							<?php }} ?>
						</select>
					</div>
					<label class="col-sm-2 control-label">  <?php echo $_smarty_tpl->getVariable('lang')->value['news_category'];?>
   </label>
				</div>
				<div class="form-group">
					<div class="col-sm-10">
						<select class="form-control" name="slider">
							<option value="0" <?php if ($_smarty_tpl->getVariable('n')->value['slider']==0){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['normal_news'];?>
</option>
							<option value="1" <?php if ($_smarty_tpl->getVariable('n')->value['slider']==1){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['main_news'];?>
</option>
						</select>
					</div>
					<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['new_kind'];?>
</label>
				</div>
				<div class="form-group">
					<div class="col-sm-10"><button type="submit" class="btn btn-default"><?php echo $_smarty_tpl->getVariable('lang')->value['add_new'];?>
</button></div>
				</div>
			</form>
			</div>
		</section>
		</div>
	</div>
<?php }elseif($_smarty_tpl->getVariable('area_name')->value=='comment'){?>
	<input type="hidden" value="comments" id="page">
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['comment'];?>
" id="lang_name">
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['delete_alarm_massage_in_men'];?>
" id="lang_del">
	<ol class="breadcrumb">
		<li>
			<a href="index.html"><i class="ti-home ml5"></i><?php echo $_smarty_tpl->getVariable('lang')->value['NDX_PAGE_NAME'];?>
</a>
		</li>
		<li class="active"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</li>
	</ol>
	<div class="row mt">
		<div class="col-md-12">
			<?php if ($_smarty_tpl->getVariable('success')->value){?><div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('success')->value;?>
</div><?php }?>
			<section class="panel">
				<div class="panel-heading no-b">
					<h5> <?php echo $_smarty_tpl->getVariable('lang')->value['list'];?>
 <b> <?php echo $_smarty_tpl->getVariable('lang')->value['comments'];?>
 </b></h5>
				</div>
				<div class="panel-body">
				  <div class="table-responsive">
					<table class="tableau_eleves table table-bordered table-striped">
					<?php if ($_smarty_tpl->getVariable('u')->value){?>
						<thead>
							<tr style="text-align: center">
								<th>#</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['email'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['comment'];?>
</th>
								<th><?php echo $_smarty_tpl->getVariable('lang')->value['date'];?>
</th>
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars["c"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('u')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["c"]->key => $_smarty_tpl->tpl_vars["c"]->value){
?>
								<tr>
									<td><?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
</td>
									<td>
										<?php echo $_smarty_tpl->getVariable('c')->value['name'];?>

									</td>
									<td><?php echo $_smarty_tpl->getVariable('c')->value['email'];?>
</td>
									<td><span style="display:block;width: 200px;overflow:auto; white-space: nowrap;"><?php echo $_smarty_tpl->getVariable('c')->value['subject'];?>
</span></td>
									<td><?php echo $_smarty_tpl->getVariable('c')->value['date'];?>
</td>
								</tr>
							<?php }} ?>
						</tbody>
						<?php }else{ ?>
						<tbody>
							<td align="center" colspan="8"><b><?php echo $_smarty_tpl->getVariable('lang')->value['NO_comments'];?>
</b></td>
						</tbody>
						<?php }?>
						<tfoot>
							<tr>
								<td colspan="7" align="right"><?php echo $_smarty_tpl->getVariable('pager')->value;?>
</td>
							</tr>
						</tfoot>
					</table>
				  </div>
				</div>
			</section>
		</div>
	</div>	
<?php }?>
	<script>
	$("#datetime").datetimepicker({
	step:15
	});
	</script>
	<script type="text/javascript">

	$(document).ready(function() {
	  $('.summernote').summernote();

	});
	</script>
