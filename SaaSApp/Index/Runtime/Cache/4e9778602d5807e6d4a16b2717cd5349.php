<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>物業資源決策系統</title>
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/basic.css" />
        <script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.min.js"></script>
        <script type="text/JavaScript">
            <!--
            function MM_jumpMenu(targ, selObj, restore) 
            //-->
        </script>
    </head>
    <body>
        <div class="mainPage" style="float: none">
            <div class="topic">
                同事名單
            </div>
            <div class="mainInfo">
                    <table width="675" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                            <div class="friend_list">
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><div class="freind_box">
                                        <div>
                                            <a href="#">
                                            <?php if(empty($item["userimage"])): ?><img src="__PUBLIC__/images/no_picture.jpg" alt="" width="100" height="100" border="0" />
                                                <?php else: ?>
                                                <img src="__PUBLIC__/Uploads/<?php echo ($item["userimage"]); ?>" alt="" width="100" height="100" border="0" /><?php endif; ?> </a>
                                        </div>
                                        <div>
                                            <a href="#"><?php echo ($item["name"]); ?></a>
                                        </div>
                                        <div>
                                            <?php echo ($item["ucode"]); ?>
                                        </div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div></td>
                        </tr>
                    </table>
                </div>
                <div class="pages">
                    <?php echo ($page); ?>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>