<?php
use yii\widgets\LinkPager;
?>
<script src="js/jquery-2.1.1.min.js"></script>
<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">爱尚music</h1>
</div>
<div class="wrapper-md">
    <div class="panel panel-default">
        <div class="panel-heading">
            Footable - make HTML tables on smaller devices look awesome
        </div>
        <div>
            <table class="table m-b-none" ui-jq="footable" data-filter="#filter" data-page-size="5">
                <thead>
                <tr>
                    <th data-toggle="true">
                        编号
                    </th>
                    <th>
                        风格名称
                    </th>
                    <th>
                        操作
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($data as $k=>$v){
                    ?>
                    <tr ids="<?php echo $v['style_id']; ?>">
                        <td><?php echo $v['style_id']; ?></td>
                        <td><?php echo $v['style_name']; ?></td>
                        <td><a class="del">删除</a></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
            <div class="list-page"> <?php
                echo LinkPager::widget([
                    'pagination' => $page,

                    'nextPageLabel'=>'下一页'

                ]);?></div>

        </div>
    </div>
</div>
<script>
    $(".del").click(function(){
        var ids=$(this).parents('tr').attr("ids");
        $.ajax({
            type:"post",
            url:"http://127.0.0.1/admin/frontend/web/index.php?r=mstyle/style_del",
            data:{
                ids:ids
            },
            success:function(e){
                if(e==1){
                    window.location.reload();
                }else{
                    alert("系统维护中！");
                }
            }
        });

    });
</script>