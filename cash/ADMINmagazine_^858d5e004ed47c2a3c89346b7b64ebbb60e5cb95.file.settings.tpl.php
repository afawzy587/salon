<?php /* Smarty version Smarty-3.0.8, created on 2019-10-19 17:45:57
         compiled from "C:\xampp\htdocs\icouna\inc\..\assets\themes\admin\internal/settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15753878405dab2fb54bc9a6-49089534%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '858d5e004ed47c2a3c89346b7b64ebbb60e5cb95' => 
    array (
      0 => 'C:\\xampp\\htdocs\\icouna\\inc\\..\\assets\\themes\\admin\\internal/settings.tpl',
      1 => 1571235201,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15753878405dab2fb54bc9a6-49089534',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
                        <ol class="breadcrumb">
                            <li>
                                <a href="index.html"><i class="ti-home ml5"></i>الصفحة الرئيسية</a>
                            </li>
                            <li class="active"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</li>
                        </ol>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if ($_smarty_tpl->getVariable('success')->value){?><div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('success')->value;?>
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
                                    <header class="panel-heading">الإعدادات الشخصية</header>
                                    <div class="panel-body">
                                        <form class="form-horizontal" role="form" method="post" action="settings.html?do=update">
                                            <div class="form-group">
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="name" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
" value="<?php echo $_smarty_tpl->getVariable('u')->value['name'];?>
">
                                                </div>
                                                <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
</label>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" autocomplete="new-password" id="inputPassword" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['password'];?>
" name="password">
                                                    <p class="help-block"><?php echo $_smarty_tpl->getVariable('lang')->value['NOCHANGEINPASS'];?>
</p>
                                                </div>
                                                <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['password'];?>
</label>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" name="email"  placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['email'];?>
" value="<?php echo $_smarty_tpl->getVariable('u')->value['email'];?>
">
                                                </div>
                                                <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['email'];?>
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
