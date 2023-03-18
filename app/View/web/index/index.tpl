<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
{$title}
    <table  id="table_excel"  > <!-- 显示 block -->
       {foreach $name as $k=>$v}
            <tr>
               <td> {$v['name'] }</td>
                <td> {$v['username'] }</td>
            </tr>
        {/foreach}

    </table>
</body>
</html>