<link rel="stylesheet" href="wenzi/css/pintuer.css">
<link rel="stylesheet" href="wenzi/css/admin.css">
<script src="wenzi/js/jquery.js"></script>
<script src="wenzi/js/pintuer.js"></script>
<script src="wenzi/js/respond.js"></script>
<script src="wenzi/js/admin.js"></script>
<link type="image/x-icon" href="/favicon.ico" rel="shortcut icon" />
<link href="/favicon.ico" rel="bookmark icon" />
<style>
    .wp-paginate {

        padding:0;

        margin:0;

    }

    .wp-paginate li {

        float:left;

        list-style:none;

        margin:2px;

        padding:0;

    }

    .wp-paginate a {

        margin:0 2px;

        line-height:20px;

        text-align:center;

        text-decoration:none;

        border-radius:3px;

        -moz-border-radius:3px;

        float:left;

        min-height:20px;

        min-width:20px;

        color:#858585;

        border:2px #e3e3e3 solid;

        border-radius:13px;

        font-size:11px;

    }

    .wp-paginate a:hover {

        border:2px #858585 solid;

        color:#858585;

    }

    .wp-paginate .title {

        color:#555;

        margin:0;

        margin-right:4px;

        font-size:14px;

    }

    .wp-paginate .gap {

        color:#999;

        margin:0;

        margin-right:4px;

    }

    .wp-paginate .current {

        margin:0 2px;

        line-height:20px;

        text-align:center;

        text-decoration:none;

        border-radius:3px;

        -moz-border-radius:3px;

        float:left;

        font-weight:700;

        min-height:20px;

        min-width:20px;

        color:#262626;

        border:2px #119eda solid;

        border-radius:13px;

        font-size:11px;

        color:#119eda;

    }

    .wp-paginate .page {

        margin:0;

        padding:0;

    }

    .wp-paginate .prev {

    }

    .wp-paginate .next {

    }

</style>
<div class="tab">
    <div class="tab-head">
        <strong>&nbsp;&nbsp;&nbsp;文字回复</strong>
        <ul class="tab-nav">
            <li class="active"><a href="#tab-set">管理基本图片回复</a></li>
            <li><a href="#tab-email">添加基本图片回复</a></li>
            <li><a href="#tab-update" class="update" style="display: none;">编辑基本图片回复</a></li>
        </ul>
    </div>
    <div class="tab-body" style="margin-left: 10px;">
        <br />
        <div class="tab-panel active" id="tab-set">
            <div class="panel admin-panel">
                <div class="panel-head"><strong>内容列表</strong></div>
                <div class="padding border-bottom">
                    <div class="button-group button-group-small radio">
                        <label class="button active"><input name="pintuer" value="所有" class="sta" checked="checked" type="radio"><span class="icon icon-check"></span> 所有</label>
                        <label class="button"><input name="pintuer" class="sta" value="启用" type="radio"><span class="icon icon-check"></span> 启用</label>
                        <label class="button"><input name="pintuer" class="sta" value="禁用" type="radio"><span class="icon icon-times"></span> 禁用</label>
                    </div>
                    <input type="button" class="button button-small checkall" id="all" name="checkall" checkfor="id" value="全选" />
                    <input type="button" id="delall" class="button button-small border-yellow" value="批量删除" />
                    <input type="text" class="sou" style="border-radius:3px;border:1px solid #f0ad4e;border:1px solid antiquewhite ; height: 28px;" <?php if(!empty($sou)) { echo "value='$sou'"; } ?>/>
                    <input type="button" id="sou" class="button button-small border-blue" value="搜索" />
                </div>
                <table class="table table-hover">
                    <tr><th width="45"></th><th width="120">回复规则名称</th><th width="120">触发关键字</th><th width="120">回复内容</th><th width="120">图片标题</th><th width="120">图片</th><th width="120">图片内容</th></tr>
                </table>
                <div id="page" class="tr" style="margin-right: 550px;">
                    <div class="navigation" style="float: right;">
                        <ol class="wp-paginate">
                            <li><span class="title">Pages:</span></li>
                            <li><a href="javascript:void(0);" class="last">&lt;</a></li>
                            <li><span id="current" class="page current">1</span></li>
                            <li><a href="javascript:void(0);" title="2" class="page">2</a></li>
                            <li><span class="gap">...</span></li>
                            <li><a href="javascript:void(0);" class="next">&gt;</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-panel" id="tab-email">
            <form method="post" class="form-x" action="index.php?r=photo/save_list" enctype="multipart/form-data">
                <div class="label"><label>&nbsp;&nbsp;&nbsp;添加回复规则 删除，修改规则、关键字以及回复后，请提交以保存操作。</label></div>
                <br/>
                <div class="form-group">
                    <input type="hidden" name="_csrf" id="_csrf" value="<?php echo \yii::$app->request->csrfToken;?>"/>
                    <div class="label"><label for="desc"f>回复规则名称</label></div>
                    <div class="field">
                        <input type="text" class="input" name="rep_name" value="<?php echo $re['rep_name']?>" size="50" style="width: 500px;" placeholder="请输入回复规则的名称" />
                        <p style="margin-left: 430px;"><input type="checkbox"  value="2" class="set"/><b>高级设置</b></p>
                        您可以给这条规则起一个名字, 方便下次修改和查看. <br/>
                        <p style="color: red;"> 选择高级设置: 将会提供一系列的高级选项供专业用户使用.</p>
                        <div>
                        </div>
                    </div>
                </div>
                <div class="stick" style="display: none;">
                    <div class="form-group">
                        <div class="label"><label for="desc">状态</label></div>
                        <div class="field"style="margin-top: 8px;">
                            <input type="radio" name="is_open" id="" value="1"/><b>启用</b>&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="is_open" id="" value="0"/><b>禁用</b>
                            <p>您可以临时禁用这条回复.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="label"><label for="desc">置顶回复</label></div>
                        <div class="field"style="margin-top: 8px;">
                            <input type="radio" name="is_stick"  value="1" class="sticks"/><b>置顶</b>&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="is_stick"  value="0" class="sticks"/><b>普通</b>
                            <p>“置顶”时无论在什么情况下均能触发且使终保持最优先级</p>
                        </div>
                    </div>
                    <div class="is_stick">
                        <div class="form-group">
                            <div class="label"><label for="desc">优先级</label></div>
                            <div class="field">
                                <input type="text" class="input" id="desc" value="<?php echo $re['priority_id']?>" name="priority_id" size="50" style="width: 500px;" placeholder="请输入这条回复规则优先级" />
                                规则优先级，越大则越靠前，最大不得超过254
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <br/>
                <div class="form-group">
                    <div class="label"><label for="desc">触发关键字</label></div>
                    <div class="field">
                        <input type="text" class="input"  id="desc" value="<?php echo $re['rep_keyword']?>" size="50" style="width: 500px;" placeholder="请输入触发关键字" name="rep_keyword" />
                        当用户的对话内容符合以上的关键字定义时，会触发这个回复定义。多个关键字请使用逗号隔开。 表情 <br/>
                        <p style="color: red;">选择高级触发: 将会提供一系列的高级触发方式供专业用户使用(注意: 如果你不了解, 请不要使用).</p>
                    </div>
                </div>
                <br/>
                <div class="label"><label>&nbsp;&nbsp;&nbsp;回复内容</label></div>
                <div class="form-group">
                    <div class="label"><label for="desc">图片标题</label></div>
                    <div class="field">
                        <input type="text" class="input" id="desc" name="title" value="<?php echo $re['title']?>" size="50" style="width: 500px;" placeholder="添加图片消息的标题" />
                        <div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label for="logo">上传图片</label></div>
                    <div class="field">
                        <a class="button input-file" href="javascript:void(0);">选择媒体文件<input size="100" type="file" name="logo"/></a>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label for="desc">图片描述</label></div>
                    <div class="field">
                        <textarea class="input" rows="5" cols="50" placeholder="添加图片的简短描述" value="<?php echo $re['desc']?>" name="desc"></textarea>
                        描述内容将出现在图片名称下方，建议控制在20个汉字以内最佳
                        <div>
                        </div>
                    </div>
                </div>
                <div class="form-button" style="margin-left: 50px;"><button class="button bg-main" type="submit">提交</button></div>
            </form>
        </div>
        <div class="tab-panel" id="tab-update">
            <form method="post" class="form-x" action="index.php?r=character/update">
                <input name="rep_id" class="upd" type="hidden"/>
                <div class="label"><label>&nbsp;&nbsp;&nbsp;添加回复规则 删除，修改规则、关键字以及回复后，请提交以保存操作。</label></div>
                <br/>
                <div class="form-group">
                    <div class="label"><label for="desc"f>回复规则名称</label></div>
                    <div class="field">
                        <input type="text" class="input" name="rep_name" size="50" style="width: 500px;" placeholder="请输入回复规则的名称" />
                        <p style="margin-left: 430px;"><input type="checkbox"  value="2" class="set"/><b>高级设置</b></p>
                        您可以给这条规则起一个名字, 方便下次修改和查看. <br/>
                        <p style="color: red;"> 选择高级设置: 将会提供一系列的高级选项供专业用户使用.</p>
                        <div>
                        </div>
                    </div>
                </div>
                <div class="stick" style="display: none;">
                    <div class="form-group">
                        <div class="label"><label for="desc">状态</label></div>
                        <div class="field"style="margin-top: 8px;">
                            <input type="radio" name="is_open" value="1"/><b>启用</b>&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="is_open" value="0"/><b>禁用</b>
                            <p>您可以临时禁用这条回复.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="label"><label for="desc">置顶回复</label></div>
                        <div class="field"style="margin-top: 8px;">
                            <input type="radio" name="is_stick"  value="1" class="sticks"/><b>置顶</b>&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="is_stick"  value="0" class="sticks"/><b>普通</b>
                            <p>“置顶”时无论在什么情况下均能触发且使终保持最优先级</p>
                        </div>
                    </div>
                    <div class="is_stick">
                        <div class="form-group">
                            <div class="label"><label for="desc">优先级</label></div>
                            <div class="field">
                                <input type="text" class="input" id="desc" name="priority_id" size="50" style="width: 500px;" placeholder="请输入这条回复规则优先级" />
                                规则优先级，越大则越靠前，最大不得超过254
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <br/>
                <div class="form-group">
                    <div class="label"><label for="desc">触发关键字</label></div>
                    <div class="field">
                        <input type="text" class="input" id="desc"  size="50" style="width: 500px;" placeholder="请输入触发关键字" name="rep_keyword" />
                        当用户的对话内容符合以上的关键字定义时，会触发这个回复定义。多个关键字请使用逗号隔开。 表情 <br/>
                        <p style="color: red;">选择高级触发: 将会提供一系列的高级触发方式供专业用户使用(注意: 如果你不了解, 请不要使用).</p>
                    </div>
                </div>
                <br/>
                <div class="label"><label>&nbsp;&nbsp;&nbsp;回复内容</label></div>
                <div class="form-group" style="margin-left: 50px;">
                    <div class="field">
                        <textarea class="input" rows="5" cols="50" placeholder="添加要回复的内容" name="rep_content"></textarea>

                    </div>

                </div>
                <div class="form-button" style="margin-left: 50px;"><button class="button bg-main" type="submit">修改</button></div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).on('click','.set',function(){
        var set = $(this).val();
        if(set==2)
        {
            if($('.stick').css('display') == 'none'){
                $('.stick').show();
            }else{
                $('.stick').hide();
            }

        }
        else if(set ==4)
        {

        }
    })
    $(document).on('click','.sticks',function(){
        var sticks = $(this).val();
        if(sticks == 1)
        {
            $('.is_stick').hide();
        }
        else
        {
            $('.is_stick').show();
        }
    })
    $(function() {

        $(":text").focus(function() {

            $(this).css('border-color', 'gold');

        }).blur(function() {

            $(this).css('border-color', '');

        })

    });
    $(document).on('click','#update',function(){
        var id = $(this).attr('value');
        $('.update').show();
        $('#tab-update').show();
        $('#tab-set').hide();
        $('.active').removeAttr("class");
        $('.update').parent().attr("class",'active');
        $('.upd').val(id);
    })
    $(document).on('click','#del',function(){
        var id = $(this).attr('value');
        var sta = $(this);
        if(confirm('确认删除?'))
        {
            $.get('index.php?r=photo/del',{id:id},function(msg){
                if(msg == 1)
                {
                    sta.parent().parent().remove();
                }
            })

        }
        else
        {return false;}
    })
    $(document).on('click','.sta',function(){
        var name = $(this).val();
        if(name == "启用")
        {
            $.get('index.php?r=character/cutyes',function(msg){
                $('.tab').html(msg)
            })
        }
        else if(name =="禁用")
        {
            $.get('index.php?r=character/cutno',function(msg){
                $('.tab').html(msg)
            })
        }
        else
        {
            $.get('index.php?r=character/index2',function(msg){
                $('.tab').html(msg)
            })
        }
    })
    $(document).on('click','#sou',function(){
        var sou = $(".sou").val();
        $.get('index.php?r=character/sou',{sou:sou},function(msg){
            $('.tab').html(msg)
        })
    })
    $(document).on('click','#delall',function(){
        var id ="";
        $('input[name="dels"]:checked').each(function(){
            id+=","+$(this).val();
        });

        if(confirm('确认删除?'))
        {
            $.get('index.php?r=character/alldel',{id:id},function(msg){
                alert(msg)
                $('.tab').html(msg)
            })
            return true;
        }
        else
        {return false;}

    })
    $('#all').click(function(){
        var but =$(this).val();
        if(but=="全选")
        {
            $('input[type="checkbox"][name="dels"]').attr('checked',true);
            $(this).val('全不选');
        }
        else{
            $('input[type="checkbox"][name="dels"]').attr('checked',false);
            $(this).val('全选');
        }
    })
</script>