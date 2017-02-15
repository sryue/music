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
                        专辑姓名
                    </th>
                    <th>
                        发行时间
                    </th>
                    <th data-hide="phone,tablet">
                        专辑封面
                    </th>
                    <th data-hide="phone,tablet">
                        所属艺人
                    </th>
                    <th data-hide="phone,tablet" data-name="Date Of Birth">
                        专辑介绍
                    </th>
                    <th data-hide="phone">
                        操作
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($models as $k => $v){ ?>
                    <tr>
                        <td> <span class="actor_name">
                                <?php echo $v['spe_name']?>
                            </span><input ids="<?php echo $v['spe_id']?>"  type="text" value="<?php echo $v['spe_name']?>" style="display: none"> </td>

                        <td><?php echo $v['issue_time'];?></td>

                        <td><img src="<?php echo $v['spe_img']?>" width="100px" alt="专辑封面"></td>
                        <td><?php echo $v['actor_name']?></td>

                        <td data-value="78025368997"><?php echo mb_substr($v['spe_desc'],'1','30','utf8');?></td>

                        <td data-value="1">
                            <a href="?r=song/show&spe_id=<?php echo $v['spe_id']?>" class="label bg-success" title="查看专辑" ids="<?php echo $v['spe_id']?>">Select</a>
                            <a href="javascript:void(0)" class="label bg-light" title="删除" ids="<?php echo $v['spe_id']?>">Delete</a></td>
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
                location.href = "?r=special/spe_list&spe_name="+text;
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
            var spe_id = $(this).attr('ids');
            if(text == _this.prev().html())
            {
                _this.css('display','none').prev().css('display','block');
            }
            else
            {
                $.ajax({
                    url:"?r=special/upd_spe",
                    data:"spe_id="+spe_id+"&spe_name="+text,
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
                    url:"?r=special/del_spe",
                    data:"spe_id="+actor_id,
                    success:function(msg)
                    {
                        if(msg == 1)
                        {
                            _this.parents("tr").remove();
                        }
                        if(msg == 0)
                        {
                            alert('删除失败');
                        }
                        if(msg == 2)
                        {
                            alert('不存在的专辑');
                        }
                    }
                })
            }

        })
    })
</script>