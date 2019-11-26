<?php /* Smarty version Smarty-3.0.8, created on 2019-10-19 17:45:47
         compiled from "C:\xampp\htdocs\icouna\inc\..\assets\themes\admin\topmenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5029418445dab2fab1927d7-98457831%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '15fa38e01070c7bdacec7cda72924beba71f2795' => 
    array (
      0 => 'C:\\xampp\\htdocs\\icouna\\inc\\..\\assets\\themes\\admin\\topmenu.tpl',
      1 => 1571442355,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5029418445dab2fab1927d7-98457831',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
			<div class="brand "<?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?>style="float: left;margin-left: -15px;margin-right: 0;"<?php }?>>
                <!-- toggle offscreen menu -->
                <a href="javascript:;" class="ti-menu off-<?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?>left<?php }else{ ?>right<?php }?> visible-xs" data-toggle="offscreen" data-move="<?php echo $_smarty_tpl->getVariable('lang')->value['dir'];?>
"></a>
                <!-- /toggle offscreen menu -->

                <!-- logo -->
                <a href="index.html" style="margin:auto;display:block;text-align:center;">
                    <img src="../assets/img/logo.png" alt=<?php echo $_smarty_tpl->getVariable('lang')->value['site_name'];?>
 style="padding-top: 12px" >
                </a>
                <!-- /logo -->
            </div>
			<ul class="nav navbar-nav <?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?>navbar-right<?php }?>">


                <li class="off-<?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?>right<?php }else{ ?>left<?php }?>">
                    <a href="javascript:;" data-toggle="dropdown">
                        <span class=" mr10"><?php echo $_smarty_tpl->getVariable('username')->value;?>
</span>
                        <i class="ti-angle-down ti-caret "></i>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight">
                        <li>
                            <a href="settings.html"><?php echo $_smarty_tpl->getVariable('lang')->value['PERSONALSITTING'];?>
</a>
                        </li>
                        <li>
                            <a href="login.html?do=logout"><?php echo $_smarty_tpl->getVariable('lang')->value['LGUT_SUBMIT'];?>
</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav <?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?> navbar-left<?php }else{ ?>navbar-right<?php }?>">
<!--                <li class="header-search <?php if ($_smarty_tpl->getVariable('q')->value){?>open<?php }?>" <?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?> style="float : right;"<?php }?>>-->
                    <!-- toggle search -->
<!--
                    <a href="javascript:;" class="toggle-search">
                        <i class="ti-search"></i>
                    </a>
-->
                    <!-- /toggle search -->
<!--
                    <div class="search-container" <?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?> style="left:40px; right: auto"<?php }?>>
                        <form role="search" action="search.html" method="get">
                            <input type="text" name="query"  class="form-control search" placeholder="<?php echo $_smarty_tpl->getVariable('lnag')->value['search'];?>
" value="<?php echo $_smarty_tpl->getVariable('q')->value;?>
" >
                        </form>
                    </div>
                </li>
-->
                
                
                <li class="" <?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?> style="float : right;"<?php }?>>
                    <!-- toggle small menu -->
                    <a href="javascript:;" class="toggle-sidebar">
                        <i class="ti-menu"></i>
                    </a>
                    <!-- /toggle small menu -->
                </li>
            </ul>
