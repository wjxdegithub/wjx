
<?php

use yii\widgets\LinkPager;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../style/backstage/bootstrap2.3.2/css/bootstrap.min.css" rel="stylesheet" />
    <title></title>
    <link href="../style/backstage/styles/Common.css" rel="stylesheet" />
    <link href="../style/backstage/styles/Index2.css" rel="stylesheet" />
</head>
<body class="div">
<div class="container-fluid">
    <div class="row-fluid">
        <h4>用户列表</h4>
        <div class="add"><a class="btn btn-success" onclick="openadd();">新增</a></div>
        <input type="text"  class="sou"/><button class="aa">搜索</button>
        <div class="w">
            <div class="span12">
                <table class="table table-condensed table-bordered table-hover tab">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>用户名</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody id="tbody">
                    <?php foreach($arr as $v) {?>
                    <tr>
                        <th><?=$v['id']?></th>
                        <th><?=$v['username']?></th>
                        <th><?=$v['addtime']?></th>
                        <th>操作</th>
                    </tr>
                    <?php }?>
                    </tbody>

                </table>

                <div id="page" class="tr">
                    <?= LinkPager::widget(['pagination' => $pages]); ?>
                </div>
            </div>
        </div>


        <div id="addModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">添加成绩</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="userName">姓名</label>
                        <div class="controls">
                            <input type="text" id="userName" placeholder="姓名">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="Chinese">语文</label>
                        <div class="controls">
                            <input type="text" id="Chinese" placeholder="语文">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="Math">数学</label>
                        <div class="controls">
                            <input type="text" id="Math" placeholder="数学">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="English">英语</label>
                        <div class="controls">
                            <input type="text" id="English" placeholder="英语">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
                <button class="btn btn-primary" id="add" onclick="add();">保存</button>
                <button class="btn btn-primary" id="edt" onclick="edt();">保存</button>
            </div>
        </div>
    </div>
</div>

<script src="../style/backstage/scripts/jquery-1.9.1.min.js"></script>
<script src="../style/backstage/bootstrap2.3.2/js/bootstrap.min.js"></script>
<script src="../style/backstage/layer-v2.3/layer/layer.js"></script>
<script src="../style/backstage/laypage-v1.3/laypage/laypage.js"></script>
<script src="../style/backstage/scripts/Index2.js"></script>
</body>
</html>
<script>
    $(".aa").click(function()
    {
        var sou=$(".sou").val();
        $.get("index.php?r=backstage/admin_list",{sou:sou},function(msg)
        {
             //alert(msg)
            $(".div").html(msg);

        })
    })
</script>

