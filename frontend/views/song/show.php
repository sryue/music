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
      Search:&nbsp;&nbsp;
        歌曲名:
        <input id="music_name" type="text" class="form-control input-sm w-sm inline m-r" name="music_name" value="<?php echo $formData['music_name']?>"/>
        语种:
        <select name="lang" id="lang">
            <option value="0" selected>全部语种</option>
            <?php foreach($langList as $k=>$v){?>
                <option value="<?php echo $v['id']?>" <?php if($formData['lang'] == $v['id']){ echo 'selected';}?>><?php echo $v['name']?></option>
            <?php }?>
        </select>
       风格:
        <select name="style_name" id="style_name">
            <option value="0" selected>全部风格</option>
            <?php foreach($styleList as $k=>$v){?>
                <option value="<?php echo $v['style_id']?>" <?php if($formData['style_id'] == $v['style_id']){ echo 'selected';}?>><?php echo $v['style_name']?></option>
            <?php }?>
        </select>
        发布时间:
        <input type="text" name="start" id="start" value="<?php echo $formData['start']?>" > - <input type="text" name="end" id="end" value="<?php echo $formData['end']?>">
        <input type="button" value="搜索" id="search">
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
              <th>
                  所属专辑
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
                  发布时间
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
              <td><a href="#"><?php echo $v['spe_name']?></a></td>
              <td><?php echo $v['name']?></td>
              <td><?php echo $v['style_name']?></td>
              <td><img src="<?php echo $v['music_img']?>" alt="" width="150px" height="100px;"></td>
              <td><?php echo $v['download']?></td>
              <td><?php echo $v['play']?></td>
              <td><?php echo date('Y-m-d H:i:s',$v['lssue_time'])?></td>
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
<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
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

    $("#search").click(function(){
        var music_name = $("#music_name").val();
        var lang       = $("#lang").val();
        var style_name = $("#style_name").val();
        var start      = $("#start").val();
        var end      = $("#end").val();
        location.href = '?r=song/show&music_name='+music_name+'&lang='+lang+'&style_id='+style_name+'&start='+start+'&end='+end;
    })
</script>