<div class="panel panel-default">
    <div class="panel-heading font-bold">
        艺人添加
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="?r=actor/addactor_do" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-sm-2 control-label">姓名</label>
                <div class="col-sm-10">
                    <input type="text" name="actor_name" class="form-control rounded">
                </div>
            </div>


            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">类型</label>
                <div class="col-sm-10">
                    <div class="radio">
                        <label class="i-checks">
                            <input type="radio" checked  name="sex" value="0">
                            <i></i>
                            男艺人
                        </label>

                        <label class="i-checks">
                            <input type="radio"  value="1" name="sex" >
                            <i></i>
                            女艺人
                        </label>

                        <label class="i-checks">
                            <input type="radio"  value="2" name="sex" >
                            <i></i>
                            组合
                        </label>
                    </div>
                </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">封面</label>
                <div class="col-sm-10">
                    <input ui-jq="filestyle" type="file" name="actor_img" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s">
                </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">所属地区</label>
                <div class="col-lg-10">
                    <select name="region[]" class="form-control region" style="width: 150px;float: left;">
                        <option value="0">请选择地区</option>
                        <?php foreach($area_info as $k =>$v){?>
                        <option value="<?php echo $v['area_id']?>" ><?php echo $v['area_name']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">艺人介绍</label>
                <div class="col-sm-10">

                    <textarea ui-jq="wysiwyg" name="actor_desc" class="form-control" style="overflow:scroll;height:200px;max-height:200px" placeholder="输入艺人介绍。"></textarea>
                </div>
            </div>

            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <button type="reset" class="btn btn-default">重置</button>
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="./jquery.js"></script>
<script>
    $(function(){
        $(document).on('change','.region',function(){
            var obj = $('.region');

            var reg_id = $(this).val();
            var _this = $(this);
            var url = "?r=actor/get_area";
            if(obj.length < 8)
            {
                $.get(url,{'parent_id':reg_id},function(msg){
                    if(msg != "")
                    {
                        var html = '<select name="region[]" class="form-control region" style="width: 150px;float: left;">';
                        $(msg).each(function(k,v){
                            html+="<option value='"+ v.area_id+"'>"+ v.area_name+"</option>";
                        })
                        html+= "</select>";
                        _this.nextAll().remove();
                        _this.after(html);
                    }
                },'json')
            }

        })
    })
</script>
