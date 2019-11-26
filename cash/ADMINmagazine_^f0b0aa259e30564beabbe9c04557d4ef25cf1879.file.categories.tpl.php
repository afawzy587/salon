<?php /* Smarty version Smarty-3.0.8, created on 2019-10-19 17:48:53
         compiled from "C:\xampp\htdocs\icouna\inc\..\assets\themes\admin\internal/categories.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13190637865dab3065625b32-28975569%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0b0aa259e30564beabbe9c04557d4ef25cf1879' => 
    array (
      0 => 'C:\\xampp\\htdocs\\icouna\\inc\\..\\assets\\themes\\admin\\internal/categories.tpl',
      1 => 1571236185,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13190637865dab3065625b32-28975569',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
          	<?php if ($_smarty_tpl->getVariable('area_name')->value=='list'){?>
          		<input type="hidden" value="categories" id="page">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['category'];?>
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
 <b><?php echo $_smarty_tpl->getVariable('lang')->value['categories'];?>
</b></h5>
							</div>
							<div class="panel-body">
							   <div class="table-responsive">
								<table class="tableau_eleves table table-bordered table-striped">
									<?php if ($_smarty_tpl->getVariable('u')->value){?>
									<thead>
										<tr>
											<th>#</th>
											<th> <?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
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
												<td><a href="categories.html?do=view&id=<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('c')->value['name'];?>
</a></td>
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
									<td align="center" colspan="6"><b><?php echo $_smarty_tpl->getVariable('lang')->value['no_categories'];?>
</b></td>
									</tbody><?php }?>
									<tfoot>
										<tr>
											<td colspan="3" align="right"><?php echo $_smarty_tpl->getVariable('pager')->value;?>
</td>
											<td colspan="1" align="left"><a class="btn btn-success btn-sm pull-left" href="categories.html?do=add"><?php echo $_smarty_tpl->getVariable('lang')->value['add_category'];?>
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
						<header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['edit_category'];?>
 ( # <?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
 )</header>
						<div class="panel-body">
						<form class="form-horizontal" role="form" method="post" action="categories.html?do=update&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
" enctype="multipart/form-data">
						<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" autocomplete="new-password" name="name" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['name'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['name'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"> <?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
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
								<label class="col-sm-2 control-label"> <?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
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
          		<input type="hidden" value="categories" id="page">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['category'];?>
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
						<header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['category_details'];?>
 ( # <?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
 )</header>
						<div class="panel-body">
						<form class="form-horizontal" role="form" method="post" action="categories.html?do=update&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
">
							<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['name'];?>
</span>
							</div>

							
							<div class="alert alert-info">
								<span style="width:20%;display:inline-block;vertical-align:top;"><strong> <?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
   : </strong></span>
								<span style="width:75%;display:inline-block;"><?php if ($_smarty_tpl->getVariable('u')->value['status']==0){?><i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">   <?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
    </i><?php }else{ ?><i class="fa fa-check"style="font-size:18px"  dir="ltr">   <?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
  </i><?php }?></span>
							</div>
							
							<div class="form-group" id="item_<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
">
								<a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();" style="margin-<?php echo $_smarty_tpl->getVariable('lang')->value['dir_fe'];?>
: 20px"><?php echo $_smarty_tpl->getVariable('lang')->value['print'];?>
</a>
								<a class="hidden-print btn btn-warning btn-sm" href="categories.html?do=edit&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['edit'];?>
</a>
								<a class="hidden-print btn btn-danger btn-sm delete" href="categories.html?do=del&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
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
						<header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['add_category'];?>
  </header>
						<div class="panel-body">
						<form class="form-horizontal" role="form" method="post" action="categories.html?do=add" enctype="multipart/form-data">
							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="name" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
" value="<?php echo $_smarty_tpl->getVariable('n')->value['name'];?>
">
								</div>
								<label class="col-sm-2 control-label"> <?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
 </label>
							</div>
							<div class="form-group">
								<div class="col-sm-10"><button type="submit" class="btn btn-default"><?php echo $_smarty_tpl->getVariable('lang')->value['add_category'];?>
</button></div>
							</div>
						</form>
						</div>
					</section>
					</div>
				</div>
			<?php }?>
