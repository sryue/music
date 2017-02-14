<?php
use yii\widgets\LinkPager;  
use yii\helpers\Html;   
?>
<div class="bg-light lter b-b wrapper-md">
  <h1 class="m-n font-thin h3">评理管理</h1>
</div>
<div class="wrapper-md">
  <div class="row">
    <div class="col-sm-6"></div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      评论列表
    </div>
    <div class="row wrapper">
    
      <div class="col-sm-3">
      <form action="?r=song/discuss" method="post">
        <div class="input-group">
          <input type="text" name="search" class="input-sm form-control" placeholder="请输入搜索歌名..." value="<?php echo $search ?>">
          <span class="input-group-btn">
          <input type="submit" class="btn btn-sm btn-default" value="Go!">  
          </span>
        </div>
       </form>
      </div>
      <div class="col-sm-4">
      </div>

    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:3%">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th style="width:10%;">序号</th>
            <th style="width:15%;">用户</th>
            <th style="width:15%;">评论内容</th>
            <th style="width:10%;">歌曲</th>
            <th style="width:10%;">评论时间</th>
            <th style="width:10%;">被点赞数</th>
            <th style="width:10%;">被鄙视数</th>
            <th style="width:10%;">操作</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($model   as $key => $val): ?>
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td><?php echo $val['comm_id'] ?></td>
            <td><?php echo $val['username'] ?></td>
            <td><?php echo $val['comm_content'] ?></td>
            <td><?php echo $val['music_name'] ?></td>
            <td><?php echo $val['comm_time'] ?></td>
            <td><?php echo $val['praise'] ?></td>
            <td><?php echo $val['contempt'] ?></td>
            <td><a href="?r=song/dis_del&id=<?php echo $val['comm_id'];if(isset($search) && !empty($search)){ echo '&search='.$search; } ?>">删除</a></td>
          </tr>
         <?php endforeach ?>
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-4 text-center">
          <small class="text-muted inline m-t-sm m-b-sm"></small>
        </div>
        <div>                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li>
            <?php 
                echo LinkPager::widget([  
                    'pagination' => $pages,  
                ]);  
            ?></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>