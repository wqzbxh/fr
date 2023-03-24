<?php
/* Smarty version 4.3.0, created on 2023-03-24 22:14:07
  from 'F:\project\fr\app\View\web\index\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_641db02fee60d8_95506633',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4757712e7b06ae77b6c23602eb6cc49aa3078bc7' => 
    array (
      0 => 'F:\\project\\fr\\app\\View\\web\\index\\index.tpl',
      1 => 1679154833,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_641db02fee60d8_95506633 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php echo $_smarty_tpl->tpl_vars['title']->value;?>

    <table  id="table_excel"  > <!-- 显示 block -->
       <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['name']->value, 'v', false, 'k');
$_smarty_tpl->tpl_vars['v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->do_else = false;
?>
            <tr>
               <td> <?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
                <td> <?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</td>
            </tr>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

    </table>
</body>
</html><?php }
}
