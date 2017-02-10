<div class="bg-light lter b-b wrapper-md">
  <h1 class="m-n font-thin h3">轮播图列表</h1>
</div>
<div class="wrapper-md">
  <div class="panel panel-default">
    <div class="panel-heading">
    </div>
    <div class="panel-body b-b b-light">
      
    </div>
    <div>
      <table class="table m-b-none" ui-jq="footable" data-filter="#filter" data-page-size="5">
        <thead>
          <tr>
              <th data-toggle="true">
                  名称
              </th>
              <th>
                  轮播图图片
              </th>
              <th data-hide="phone,tablet">
                  轮播图介绍
              </th>
              <th data-hide="phone,tablet" data-name="Date Of Birth">
                  操作
              </th>  
          </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $key => $val): ?>
          <tr>
              <td><?php echo $val['car_name'] ?></td>
              <td><img src="./instyle/images/carousel/<?php echo $val['car_file'] ?>" width='60px' height='60px' id="img"></td>
              <td><?php echo $val['car_content'] ?></td>
              <td><button type="button" class="btn btn-default btn-xs" id="<?php echo $val['car_id'] ?>">Remove</button> </td>      
          </tr>
         <?php endforeach ?>
        </tbody>
        <tfoot class="hide-if-no-paging">
          <tr>
              <td colspan="5" class="text-center">
                  <ul class="pagination"></ul>
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
        $("button").click(function(){
            if(confirm("您确定要删除?")){
              _this = $(this);
              var id = $(this).attr("id");
              //发送id  删除
              $.ajax({
                 type: "POST",
                 url: "?r=systems/del",
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