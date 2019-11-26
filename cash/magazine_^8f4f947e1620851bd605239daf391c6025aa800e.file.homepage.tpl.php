<?php /* Smarty version Smarty-3.0.8, created on 2019-10-19 17:42:13
         compiled from "C:\xampp\htdocs\icouna\inc\..\assets\themes\magazine\internal/homepage.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15603003045dab2ed5d7f557-08069922%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f4f947e1620851bd605239daf391c6025aa800e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\icouna\\inc\\..\\assets\\themes\\magazine\\internal/homepage.tpl',
      1 => 1571440349,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15603003045dab2ed5d7f557-08069922',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="colorlib-page">
	<a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
	<aside id="colorlib-aside" role="complementary" class="js-fullheight">
		<h1 id="colorlib-logo"><a href="index.html"><?php echo $_smarty_tpl->getVariable('site_name')->value;?>
</a></h1>
		<nav id="colorlib-main-menu" role="navigation">
			<ul>
				<li <?php if (!$_smarty_tpl->getVariable('cat_select')->value){?>class="colorlib-active"<?php }?>><a href="index.html">Home</a></li>
				<?php if ($_smarty_tpl->getVariable('categries')->value){?>
					<?php  $_smarty_tpl->tpl_vars["c"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars["k"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('categries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["c"]->key => $_smarty_tpl->tpl_vars["c"]->value){
 $_smarty_tpl->tpl_vars["k"]->value = $_smarty_tpl->tpl_vars["c"]->key;
?>
						<li <?php if ($_smarty_tpl->getVariable('cat_select')->value){?> <?php if ($_smarty_tpl->getVariable('cat_select')->value==$_smarty_tpl->getVariable('c')->value['id']){?> class="colorlib-active" <?php }?><?php }?>><a href="index.html?do=category&id=<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('c')->value['name'];?>
</a></li>
					<?php }} ?>
				<?php }?>
			</ul>
		</nav>
	</aside>
	<div id="colorlib-main">
	<?php if ($_smarty_tpl->getVariable('area_name')->value=='home'){?>
		<aside id="colorlib-hero" class="js-fullheight">
			<div class="flexslider js-fullheight">
				<ul class="slides">
				<?php if ($_smarty_tpl->getVariable('sliders')->value){?>
					<?php  $_smarty_tpl->tpl_vars["s"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars["sk"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('sliders')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["s"]->key => $_smarty_tpl->tpl_vars["s"]->value){
 $_smarty_tpl->tpl_vars["sk"]->value = $_smarty_tpl->tpl_vars["s"]->key;
?>
					<li style="background-image: url(<?php echo $_smarty_tpl->getVariable('s')->value['image'];?>
);">
						<div class="overlay"></div>
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12 col-xs-12 js-fullheight slider-text">
									<div class="slider-text-inner">
										<div class="desc">
											<p class="tag"><a href="index.html?do=category&id=<?php echo $_smarty_tpl->getVariable('s')->value['category_id'];?>
"><span><?php echo getcategoryname($_smarty_tpl->getVariable('s')->value['category_id']);?>
</span></a></p>
											<h1><a href="index.html?do=news&id=<?php echo $_smarty_tpl->getVariable('s')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('s')->value['title'];?>
</a></h1>
											<p class="line"><?php echo br2nl($_smarty_tpl->getVariable('s')->value['text']);?>
</p>
											</div>
									</div>
								</div>
							</div>
						</div>
					</li>
					<?php }} ?>
				<?php }?>
				</ul>
			</div>
		</aside>
		<div class="colorlib-blog">
			<div class="container-wrap">
				<div class="row">
				<?php if ($_smarty_tpl->getVariable('news')->value){?>
					<?php  $_smarty_tpl->tpl_vars["n"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars["nk"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('news')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["n"]->key => $_smarty_tpl->tpl_vars["n"]->value){
 $_smarty_tpl->tpl_vars["nk"]->value = $_smarty_tpl->tpl_vars["n"]->key;
?>
						<?php if ($_smarty_tpl->getVariable('nk')->value==1){?>
						<div class="col-md-6">
							<div class="row"><?php }?>
								<?php if ($_smarty_tpl->getVariable('nk')->value==3){?>
									<div class="col-md-12">
								<?php }elseif($_smarty_tpl->getVariable('nk')->value>3){?>
									<div class="col-md-4">
								<?php }else{ ?>
									<div class="col-md-6">
								<?php }?>
									<div class="blog-entry animate-box">
										<div <?php if ($_smarty_tpl->getVariable('nk')->value==1||$_smarty_tpl->getVariable('nk')->value==2||$_smarty_tpl->getVariable('nk')->value==3){?> class="blog-img blog-img2" <?php }else{ ?> class="blog-img" <?php }?> style="background-image: url(<?php echo $_smarty_tpl->getVariable('n')->value['image'];?>
);">
											<div class="desc text-center">
												<p class="tag"><span><?php echo getcategoryname($_smarty_tpl->getVariable('n')->value['category_id']);?>
</span></p>
												<h2 class="head-article"><a href="index.html?do=news&id=<?php echo $_smarty_tpl->getVariable('n')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('n')->value['title'];?>
</a></h2>
												<p class="line"><?php echo br2nl($_smarty_tpl->getVariable('n')->value['text']);?>
</p>
											</div>
										</div>
									</div>
								</div>
						<?php if ($_smarty_tpl->getVariable('nk')->value==3){?>		
							</div>
						</div>
						<?php }?>
					<?php }} ?>
				<?php }?>
				</div>
			</div>
		</div>			
			</div>
		</div>
	<?php }elseif($_smarty_tpl->getVariable('area_name')->value=='category'){?>
		<div class="colorlib-blog">
				<div class="container-wrap">
					<div class="row">
						<div class="col-md-11">
							<div class="content-wrap">
							<?php if ($_smarty_tpl->getVariable('news')->value){?>
								<?php  $_smarty_tpl->tpl_vars["n"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars["nk"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('news')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["n"]->key => $_smarty_tpl->tpl_vars["n"]->value){
 $_smarty_tpl->tpl_vars["nk"]->value = $_smarty_tpl->tpl_vars["n"]->key;
?>
								<article class="blog-entry-travel animate-box">
									<div class="blog-img" style="background-image: url(<?php echo $_smarty_tpl->getVariable('n')->value['image'];?>
);"></div>
									<div class="desc">
										<p class="meta">
											<span class="cat"><?php echo getcategoryname($_smarty_tpl->getVariable('n')->value['category_id']);?>
</span>
											<span class="date"><?php echo _date_format($_smarty_tpl->getVariable('n')->value['date']);?>
</span>
											<span class="pos">By <?php echo getusername($_smarty_tpl->getVariable('n')->value['user_id']);?>
</span>
										</p>
										<h2><a href="index.html?do=news&id=<?php echo $_smarty_tpl->getVariable('n')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('n')->value['title'];?>
</a></h2>
										<p class="line"><?php echo br2nl($_smarty_tpl->getVariable('n')->value['text']);?>
</p>
										<p><a href="index.html?do=news&id=<?php echo $_smarty_tpl->getVariable('n')->value['id'];?>
" class="btn btn-primary with-arrow">Read More <i class="icon-arrow-right22"></i></a></p>
									</div>
								</article>
								<?php }} ?>
							<?php }else{ ?>
								<article class="blog-entry-travel animate-box">
									<div class="desc">
										<h2><?php echo $_smarty_tpl->getVariable('lang')->value['no_news'];?>
</h2>
									</div>
								</article>
							<?php }?>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php }elseif($_smarty_tpl->getVariable('area_name')->value=='single'){?>
		<div class="colorlib-blog">
				<div class="container-wrap">
					<div class="row">
						<div class="col-md-9">
							<div class="content-wrap">
								<article class="animate-box">
									<div class="blog-img" style="background-image: url(<?php echo $_smarty_tpl->getVariable('n')->value['image'];?>
);"></div>
									<div class="desc">
										<div class="meta">
											<p>
												<span><?php echo getcategoryname($_smarty_tpl->getVariable('n')->value['category_id']);?>
</span>
												<span><?php echo _date_format($_smarty_tpl->getVariable('n')->value['date']);?>
</span>
												<span><?php echo getusername($_smarty_tpl->getVariable('n')->value['user_id']);?>
 </span>
												<?php if ($_smarty_tpl->getVariable('n')->value['totalcomment']>0){?>
													<span><?php echo $_smarty_tpl->getVariable('n')->value['totalcomment'];?>
 Comments</span>
												<?php }?>
											</p>
										</div>
										<h2><?php echo $_smarty_tpl->getVariable('n')->value['title'];?>
</h2>
										<p><?php echo br2nl($_smarty_tpl->getVariable('n')->value['text']);?>
</p>
									</div>
								</article>
								<?php if ($_smarty_tpl->getVariable('n')->value['totalcomment']>0){?>
									<div class="row row-bottom-padded-md">
									<div class="col-md-12 animate-box">
										<h2 class="heading-2"><?php echo $_smarty_tpl->getVariable('n')->value['totalcomment'];?>
 Comments</h2>
										<?php  $_smarty_tpl->tpl_vars["c"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars["ck"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('n')->value['comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["c"]->key => $_smarty_tpl->tpl_vars["c"]->value){
 $_smarty_tpl->tpl_vars["ck"]->value = $_smarty_tpl->tpl_vars["c"]->key;
?>
								   			<div class="review">
								   				<div class="desc">
													<h4>
														<span class="text-left"><?php echo $_smarty_tpl->getVariable('c')->value['name'];?>
</span>
														<span class="text-right"><?php echo _date_format($_smarty_tpl->getVariable('c')->value['date']);?>
</span>
													</h4>
													<p><?php echo $_smarty_tpl->getVariable('c')->value['subject'];?>
</p>
												</div>
								   			</div>
								   		<?php }} ?>
									</div>
								</div>
								<?php }?>
								<div class="row">
									<div class="col-md-12 animate-box">
										<h2 class="heading-2">Say something</h2>
										<div class="alert">
											
										</div>
										
										<form  id="CONTACT"  class="form"  method="POST"> 
											<div class="row form-group">
												<div class="col-md-12">
													<!-- <label for="fname">First Name</label> -->
													<input name="id" value="<?php echo $_smarty_tpl->getVariable('n')->value['id'];?>
" hidden>
													<input type="text" id="fname" name="name" class="form-control" placeholder="Your name" value="<?php echo $_smarty_tpl->getVariable('news')->value['name'];?>
">
												</div>
											</div>

											<div class="row form-group">
												<div class="col-md-12">
													<!-- <label for="email">Email</label> -->
													<input type="text" id="email" class="form-control" name ="email" placeholder="Your email address" value="<?php echo $_smarty_tpl->getVariable('news')->value['email'];?>
">
												</div>
											</div>
											

											<div class="row form-group">
												<div class="col-md-12">
													<textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Your subject of this message"><?php echo $_smarty_tpl->getVariable('news')->value['message'];?>
</textarea>
												</div>
											</div>
											<div class="form-group">
												<input type="submit" value="Post Comment" class="btn btn-primary">
											</div>
										</form>	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php }?>
	</div>
</div>