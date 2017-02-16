<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\Widget;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
$this->title = '多条件查询';
?>
<div class="bg-light lter b-b wrapper-md">
  <h1 class="m-n font-thin h3">文章列表</h1>
</div>
<div class="wrapper-md">
  <div class="panel panel-default">
    <div class="panel-heading">
    </div>

    <div>
     <?php
         $form = ActiveForm::begin([
                    'action'=>Url::toRoute(['show']),
                    'method'=>'get',
            ]);           
      ?>
      标题：<input type="text" name="title" value="<?php echo empty($where['title'])?'' : $where['title'] ?>">
      内容：<input type="text" name="content" value="<?php echo empty($where['conetent'])?'' : $where['content'] ?>">
      <?php
        echo Html::submitButton('搜索',['class'=>'btn btn-primary']);
        ActiveForm::end();
      ?>
      <table class="table m-b-none" ui-jq="footable" data-filter="#filter" data-page-size="5">
        <thead>
          <tr>
              <th data-toggle="true">
                  标题
              </th>
              <th>
                  文章插图图片
              </th>
              <th data-hide="phone,tablet">
                  发布时间
              </th>
              <th data-hide="phone,tablet">
                  文章内容
              </th>
              <th data-hide="phone,tablet" data-name="Date Of Birth">
                  操作
              </th>  
          </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $key => $val): ?>
          <tr>
              <td><?php echo $val['art_title'] ?></td>
              <td><img src="./instyle/images/article/<?php echo $val['art_img'] ?>" width='60px' height='60px' id="img" alt="图片不显示"></td>
              <td><?php echo $val['art_starttime'] ?></td>
              <td>
              <?php 
                 echo  mb_substr(strip_tags($val['art_content']), 50,120,'UTF8').'....';
              ?>
              </td>
              <td><input type="button" name="btn" class="btn btn-default btn-xs" id="<?php echo $val['art_id'] ?>" value="Remove"></td>      
          </tr>
         <?php endforeach ?>
        </tbody>
        <tfoot class="hide-if-no-paging">
          <tr>
              <td colspan="5" class="text-center">
                  <ul class="pagination">
                    <?php
                      echo LinkPager::widget([
                      'pagination' => $pages,
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
<script src="./jquery-1.7.js"></script>
<script>
    $(function(){
        $("input[name='btn']").click(function(){
            if(confirm("您确定要删除?")){
              _this = $(this);
              var id = $(this).attr("id");
              //发送id  删除
              $.ajax({
                 type: "POST",
                 url: "?r=article/del",
                 data: "id="+id,
                 success: function(msg){
                     if(msg==1){
                        _this.parent().parent().remove();
                     }else{
                        alert("删除失败");
                     }
                 }
              });
          }else{
              return false;
          }

        })


        $(function(){
            $(document).on("click","#img",function(){
               var _this = $(this);
               var widths= _this.attr("width");
               if(widths.indexOf("6") > -1){
                  var width =   $(this).attr("width","240px");
                  var width =   $(this).attr("height","120px");
               }else{
                  var width =   $(this).attr("width","60px");
                  var width =   $(this).attr("height","60px");
               }

               
            })
        })

    })
</script>