<script src="js/jquery-2.1.1.min.js"></script>
<div class="bg-light lter b-b wrapper-md">
  <h1 class="m-n font-thin h3">爱尚music</h1>
</div>
<div class="wrapper-md" ng-controller="FormDemoCtrl">
  <div class="row">
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-heading font-bold">添加风格</div>
        <div class="panel-body">
          <form role="form">
            <div class="form-group">
              <label>风格名称</label>
              <input type="text" class="form-control" placeholder="style_name" id="style">
            </div>
            <div class="checkbox">
              <label class="i-checks">
                <input type="checkbox" checked disabled><i></i> Check me out
              </label>
              <span id="one"></span>
            </div>
            <button type="button" class="btn btn-sm btn-primary" id="btn">添加</button>
          </form>
        </div>
      </div>
    </div>
</div>
  <script>
   $("#btn").click(function(){
     var style=$("#style").val();
     $.ajax({
       type:"post",
       url:"http://127.0.0.1/admin/frontend/web/index.php?r=mstyle/add",
       data:{
         style:style
       },
       success:function(e){
         if(e==0){
           $("#one").html("<a style='color: red'>风格名称已存在！</a>");
         }
         if(e==1){
           $("#one").html("<a style='color: red' >添加错误</a>");
         }
         if(e==2){
           window.location.href="?r=mstyle/list";
         }
       }
     });
   });
  </script>