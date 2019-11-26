<?php /* Smarty version Smarty-3.0.8, created on 2019-10-19 17:45:47
         compiled from "C:\xampp\htdocs\icouna\inc\..\assets\themes\admin\sidebar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4628664985dab2fab402e95-77090410%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '44bad82bac4cf18e106947c5bb76e81eedfa4af9' => 
    array (
      0 => 'C:\\xampp\\htdocs\\icouna\\inc\\..\\assets\\themes\\admin\\sidebar.tpl',
      1 => 1571235648,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4628664985dab2fab402e95-77090410',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- sidebar menu -->
<aside class="sidebar offscreen-<?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='right'){?>right<?php }else{ ?>left<?php }?>">
    <!-- main navigation -->
    <nav style="margin-top:15px;" class="main-navigation" data-height="auto" data-size="6px" data-distance="0" data-rail-visible="true" data-wheel-step="10">
		<ul class="nav">
			<li>
				<a href="javascript:;">
					<i class="toggle-accordion"></i>
					<i class="ti-layers"></i>
					<span>  <?php echo $_smarty_tpl->getVariable('lang')->value['users'];?>
  </span>
				</a>
				<ul class="sub-menu">

					<li>
						<a href="users.html">
							<span><?php echo $_smarty_tpl->getVariable('lang')->value['list'];?>
 <?php echo $_smarty_tpl->getVariable('lang')->value['users'];?>
  </span>
						</a>
					</li>
					<li>
						<a href="users.html?do=add">
							<span><?php echo $_smarty_tpl->getVariable('lang')->value['add_user'];?>
</span>
						</a>
					</li>
				</ul>
			</li>
	   </ul>
		<ul class="nav">
			<li>
				<a href="javascript:;">
					<i class="toggle-accordion"></i>
					<i class="ti-layers"></i>
					<span>  <?php echo $_smarty_tpl->getVariable('lang')->value['news'];?>
  </span>
				</a>
				<ul class="sub-menu">

					<li>
						<a href="news.html">
							<span><?php echo $_smarty_tpl->getVariable('lang')->value['list'];?>
 <?php echo $_smarty_tpl->getVariable('lang')->value['news'];?>
  </span>
						</a>
					</li>
					<li>
						<a href="news.html?do=add">
							<span><?php echo $_smarty_tpl->getVariable('lang')->value['add_new'];?>
</span>
						</a>
					</li>
				</ul>
			</li>
	   </ul>
	   <ul class="nav">
			<li>
				<a href="javascript:;">
					<i class="toggle-accordion"></i>
					<i class="ti-layers"></i>
					<span>  <?php echo $_smarty_tpl->getVariable('lang')->value['categories'];?>
  </span>
				</a>
				<ul class="sub-menu">

					<li>
						<a href="categories.html">
							<span><?php echo $_smarty_tpl->getVariable('lang')->value['list'];?>
 <?php echo $_smarty_tpl->getVariable('lang')->value['categories'];?>
  </span>
						</a>
					</li>
					<li>
						<a href="categories.html?do=add">
							<span><?php echo $_smarty_tpl->getVariable('lang')->value['add_category'];?>
</span>
						</a>
					</li>
				</ul>
			</li>
	   </ul>
	   
		<br><br><br><br><br><br>
	</nav>
</aside>
<!-- /sidebar menu -->
