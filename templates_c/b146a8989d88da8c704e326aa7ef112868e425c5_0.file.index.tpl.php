<?php
/* Smarty version 4.3.1, created on 2023-04-29 00:38:21
  from 'F:\fr\fr\app\View\web\index\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_644bf67de335e4_66187229',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b146a8989d88da8c704e326aa7ef112868e425c5' => 
    array (
      0 => 'F:\\fr\\fr\\app\\View\\web\\index\\index.tpl',
      1 => 1681999954,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_644bf67de335e4_66187229 (Smarty_Internal_Template $_smarty_tpl) {
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
