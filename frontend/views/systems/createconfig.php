<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">添加配置项</h1>
</div>

<div class="panel panel-default">
    <div class="panel-heading font-bold">
        <a href="?r=systems/config" style="color: blue"> & 全部配置项</a>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="?r=systems/createconfig" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-sm-2 control-label">标题</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control rounded" name="conf_title">
                </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">名称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control rounded" name="conf_name">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">类型</label>
                <div class="col-sm-10">
                    <input type="radio" value="text" name="field_type" checked>text &nbsp;
                    <input type="radio" value="radio" name="field_type">radio &nbsp;
                    <input type="radio" value="textarea" name="field_type">textarea &nbsp;
                </div>
            </div>
            <div class="form-group" style="display: none" id="field_value">
                <label class="col-sm-2 control-label">选项值</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control rounded" name="field_value" placeholder="每个值以逗号隔开" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">排序</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control rounded" name="conf_order">
                </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">说明</label>
                <div class="col-sm-10">
                <textarea name="conf_tips" id="" cols="100" rows="7"></textarea>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                </div>
            </div>



                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button type="reset" class="btn btn-default">重置</button>
                        <button type="submit" class="btn btn-primary">增加</button>
                    </div>
                </div>
        </form>
    </div>
</div>
</div>
<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>

<script>
    $("input[name=field_type]").click(function()
    {
        if($(this).val() == 'radio')
        {
            $("#field_value").show();
        }else {
            $("#field_value").hide();
        }
    })
</script>
