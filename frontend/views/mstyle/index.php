<script src="./js/jquery-2.1.1.min.js"></script>
<div class="bg-light lter b-b wrapper-md">
  <h1 class="m-n font-thin h3">爱尚music</h1>
</div>
<div class="wrapper-md" ng-controller="FormDemoCtrl">
  <div class="row">
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-heading font-bold">添加风格</div>
        <div class="panel-body">
          <form role="form" enctype="multipart/form-data" method="post" id="fileinfo">
            <div class="form-group">
              <label>风格名称</label>
              <input type="text" class="form-control" placeholder="style_name" id="style">
                <label>风格图片</label>
                <input type="file" placeholder="style_img" id="style_img" name="style_img">
                <input type="button" value="图片上传" id="btnimg"/>
                <span id="backgroundimg"></span>

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
        $('#btnimg').click(function(){
            var upload = document.getElementById('fileinfo')
            var fd = new FormData(upload);
            $.ajax({
                url:"?r=mstyle/imgadd",
                type:"POST",
                data:fd,
                processData:false,
                contentType:false,
                success:function(data)
                {
                    $('#backgroundimg').html("<img src="+data+" width="+30+" height="+30+"/>");
                }
            })
        })
   $("#btn").click(function(){
         var style=$("#style").val();
        var style_img = $("#backgroundimg").find('img').attr("src");
     $.ajax({
         type:"POST",
        url:"?r=mstyle/add",
         data:{style:style,style_img:style_img},
         success:function(e)
         {
             if(e==0)
             {
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