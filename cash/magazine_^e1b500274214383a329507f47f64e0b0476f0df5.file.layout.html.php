<?php /* Smarty version Smarty-3.0.8, created on 2019-10-19 17:42:13
         compiled from "C:\xampp\htdocs\icouna\inc\..\assets\themes\magazine\layout.html" */ ?>
<?php /*%%SmartyHeaderCode:3286637995dab2ed55889f1-74206295%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1b500274214383a329507f47f64e0b0476f0df5' => 
    array (
      0 => 'C:\\xampp\\htdocs\\icouna\\inc\\..\\assets\\themes\\magazine\\layout.html',
      1 => 1571269690,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3286637995dab2ed55889f1-74206295',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<!-- fill language attributes -->
<html lang="en" dir="ltr">
 <head>
	<?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('headinc')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
  </head> 
  <body>
    <main>
    <!-- SECTION MAIN -->
		<?php if ($_smarty_tpl->getVariable('filename')->value!=''){?>
           	<?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('filename')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
        <?php }else{ ?>
        	no file page to include in ( layout.html )
        <?php }?>
    </main>
    <!-- / SECTION MAIN -->
    <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('footinc')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
  </body>
</html>










