<?php /* Smarty version Smarty-3.0.8, created on 2019-10-19 17:45:46
         compiled from "C:\xampp\htdocs\icouna\inc\..\assets\themes\admin\layout.html" */ ?>
<?php /*%%SmartyHeaderCode:18040084705dab2faada0ab4-44068965%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '46286e3dadbca13c95808cab83ffb4d1bf2ba31c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\icouna\\inc\\..\\assets\\themes\\admin\\layout.html',
      1 => 1567503335,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18040084705dab2faada0ab4-44068965',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <!-- /meta -->

    <title><?php echo $_smarty_tpl->getVariable('site_name')->value;?>
 :: <?php echo $_smarty_tpl->getVariable('title')->value;?>
</title>
    <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('headinc')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
</head>

<!-- body -->

<body>
    <div class="app right-menu">
        <!-- top header -->
        <header class="header header-fixed navbar ">
            <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('topmenu')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
        </header>
        <!-- /top header -->

        <section class="layout">

            <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('sidebar')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
            <!-- main content -->
            <section class="main-content">

                <!-- content wrapper -->
                <div class="content-wrap">

                    <!-- inner content wrapper -->
                    <div class="wrapper">
	            	<?php if ($_smarty_tpl->getVariable('filename')->value!=''){?>
			            <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('filename')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
			        <?php }else{ ?>
			        	no file page to include ( layout.html )
			        <?php }?>
			        </div>
                    <!-- /inner content wrapper -->

                </div>
                <!-- /content wrapper -->
                <a class="exit-offscreen"></a>
            </section>
            <!-- /main content -->
        </section>

    </div>
    <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('footinc')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
</body>
<!-- /body -->

</html>
