<?php
use \yii\widgets\LinkPager;
?>
<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">艺人列表</h1>
</div>
<div class="wrapper-md">
    <div class="panel panel-default">

        <div class="panel-body b-b b-light">
            <input id="filter" type="text" class="form-control input-sm w-sm inline m-r"/>
            <button class="btn btn-success" >搜索</button>
        </div>
        <div>
            <table class="table m-b-none" ui-jq="footable" data-filter="#filter" data-page-size="5">
                <thead>
                <tr>
                    <th data-toggle="true">
                       艺人姓名
                    </th>
                    <th>
                        类型
                    </th>
                    <th data-hide="phone,tablet">
                        形象照片
                    </th>
                    <th data-hide="phone,tablet" data-name="Date Of Birth">
                        所在地
                    </th>
                    <th data-hide="phone">
                        操作
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($actor_info as $k => $v){?>
                <tr>
                    <td> <span class="actor_name"><?php echo $v['actor_name']?> </span><input ids="<?php echo $v['actor_id']?>"  type="text" value="<?php echo $v['actor_name']?>" style="display: none"> </td>
                    <td><?php if($v['sex'] == 0){echo "男艺人";}if($v['sex']==1){echo "女艺人";}if($v['sex']==2){echo "组合";}?></td>
                    <td><img src="<?php echo $v['actor_img']?>" width="100px" alt=""></td>
                    <td data-value="78025368997"><?php echo $v['region']?></td>
                    <td data-value="1"><span class="label bg-light" title="Disabled" ids="<?php echo $v['actor_id']?>">Delete</span></td>
                </tr>
                <?php } ?>
                </tfoot>
            </table>
        </div>
        <span style="margin-left: 600px">
        <?php echo LinkPager::widget([
            'pagination' => $pages,
        ]);?></span>
    </div>
</div>
<script src="./jquery.js"></script>
<script>
    $(function(){
        $('.btn-success').click(function(){
            var text = $(this).prev().val();
            if(text != "")
            {
                location.href = "?r=actor/actorshow&actor_name="+text;
            }
            else
            {
                alert('请输入搜索名称');
            }
        })


        $('.actor_name').click(function(){
            var _this = $(this);
            _this.css('display','none');
            _this.next().css('display','block');
        }).next().blur(function(){
            var _this = $(this);
            var text = $(this).val();
            var actor_id = $(this).attr('ids');
//            alert(text);
//            alert(_this.prev().html());return;
            if(text == _this.prev().html())
            {
                _this.css('display','none').prev().css('display','block');
            }
            else
            {
                $.ajax({
                    url:"?r=actor/actor_update",
                    data:"actor_id="+actor_id+"&actor_name="+text,
                    success:function(msg)
                    {
                        if(msg == 1)
                        {
                            _this.css('display','none');
                            _this.prev().html(text);
                            _this.prev().css('display','block');
                        }
                        else{
                            alert('修改失败');
                            _this.css('display','none');
                            _this.prev().css('display','block');
                        }
                    }
                })

            }

        });




        $('.bg-light').click(function(){
            var _this = $(this);
            var actor_id = $(this).attr('ids');

            if(confirm('是否删除？'))
            {
                $.ajax({
                    url:"?r=actor/delete_actor",
                    data:"actor_id="+actor_id,
                    success:function(msg)
                    {
                        if(msg == 1)
                        {
                            _this.parents("tr").remove();
                        }
                        if(msg == 2)
                        {
                            alert('删除失败');
                        }
                    }
                })
            }

        })
    })
</script>