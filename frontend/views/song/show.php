<?php
use yii\widgets\LinkPager;
?>
<div class="bg-light lter b-b wrapper-md">
  <h1 class="m-n font-thin h3">歌曲列表</h1>
</div>
<div class="wrapper-md">
  <div class="panel panel-default">
    <div class="panel-heading">
       喝最烈的酒,听最好的歌.    --列夫托儿斯凯
    </div>
    <div class="panel-body b-b b-light">
      Search: <input id="filter" type="text" class="form-control input-sm w-sm inline m-r" name="music_name"/>
    </div>
    <div>
      <table class="table m-b-none" ui-jq="footable" data-filter="#filter" data-page-size="5">
        <thead>
          <tr>
              <th data-toggle="true">
                  歌曲名称
              </th>
              <th>
                  所属歌手
              </th>
              <th data-hide="phone,tablet">
                  语种
              </th>
              <th data-hide="phone,tablet">
                  风格
              </th>
              <th data-hide="phone,tablet" data-name="Date Of Birth">
                  封面展示
              </th>
              <th data-hide="phone">
                  下载次数
              </th>
               <th data-hide="phone">
                  播放次数
              </th>
              <th data-hide="phone">
                  操作
              </th>
          </tr>
        </thead>
        <tbody>

        <?php foreach($list as $k=>$v){?>
          <tr>
              <td><?php echo $v['music_name']?></td>
              <td><?php echo $v['actor_name']?></td>
              <td><?php echo $v['name']?></td>
              <td><?php echo $v['style_name']?></td>
              <td><img src="<?php echo $v['music_img']?>" alt="" width="150px" height="100px;"></td>
              <td><?php echo $v['download']?></td>
              <td><?php echo $v['play']?></td>
              <td><a href="?r=song/listensong&id=<?php echo $v['music_id']?>">试听
                      <a href="javascript:void(0)" onclick="deleteSong(<?php echo $v['music_id']?>)">删除</a>
              </td>
          </tr>
        <?php }?>
        </tbody>
        <tfoot class="hide-if-no-paging">
          <tr>
              <td colspan="8" class="text-center">
                  <ul class="pagination">
                      <?php
                      echo LinkPager::widget([
                          'pagination' => $pagination,
                      ]);
                      ?>
                  </ul>
              </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
<script>
    function  deleteSong(id) {
        var result = confirm('你确定要删除吗');
        if(result)
        {
            location.href = '?r=song/delsong&id='+id;
        }else {
            return false;
        }
    }
</script>