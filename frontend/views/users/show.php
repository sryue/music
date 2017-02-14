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
      用户列表
    </div>
    <div class="panel-body b-b b-light">
      Search: <input id="filter" type="text" class="form-control input-sm w-sm inline m-r"/>
    </div>
    <div>
      <table class="table m-b-none" ui-jq="footable" data-filter="#filter" data-page-size="5">
        <thead>
          <tr>
              <th data-toggle="true">
                  用户名
              </th>
              <th>
                  密码
              </th>
              <th data-hide="phone,tablet">
                  Nickname
              </th>
              <th data-hide="phone,tablet" data-name="Date Of Birth">
                  sign
              </th>
              <th data-hide="phone">
                  sex
              </th>
              <th data-hide="phone">
                  year
              </th>
              <th data-hide="phone">
                  month
              </th>
              <th data-hide="phone">
                  day
              </th>
              <th data-hide="phone">
                  img
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
            <tr ids="<?php echo $v['user_id']; ?>">
                <td><?php echo $v['username']; ?></td>
                <td><a href><?php echo $v['password']; ?></a></td>
                <td><?php echo $v['nickname']; ?></td>
                <td data-value="78025368997"><?php echo $v['sign']; ?></td>
                <td data-value="1"><span class="label bg-success" title="Active"><?php echo $v['sex']; ?></span></td>
                <td><?php echo $v['year']; ?></td>
                <td><?php echo $v['month']; ?></td>
                <td><?php echo $v['day']; ?></td>
                <td><?php echo $v['img']; ?></td>
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
        var ids=$(this).parents('tr').attr('ids');
        $.ajax({
            type: "POST",
            url: "http://127.0.0.1/admin/frontend/web/?r=users/del",
            data: {
                ids:ids
            },
            success: function(e){
                if(e==1){
                    window.location.reload();
                }
                if(e==0){
                    alert("系统维护中！");
                }
            }
        });
    });
</script>