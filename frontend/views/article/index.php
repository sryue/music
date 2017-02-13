<style type="text/css">

        .demo1{

            height:300px;

        }
    </style>
<div class="bg-light lter b-b wrapper-md">
  <h1 class="m-n font-thin h3">添加文章</h1>
</div>
<div class="wrapper-md" ng-controller="FormDemoCtrl">
<div class="row">
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-heading font-bold">手动添加文章</div>
        <div class="panel-body">
          <form role="form" action="?r=article/index_add" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>文章标题</label>
              <input type="text" name="art_title" class="form-control" placeholder="添加文章标题">
            </div>
            
            <div class="form-group">
              <label>附加图片</label>
               <input type="file" name="art_img"  placeholder="图片">
            </div>
            <div class="form-group">
              <label>发布时间</label>
               <input type="text" id="J-xl" name="art_starttime" class="form-control" placeholder="选择合理的时间">
            </div>
            <div class="form-group">
              <label>文章内容</label>
              <textarea class="form-control" name="art_content" cols="60" rows="10" placeholder="请输入..."></textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">添加</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-heading font-bold">Horizontal form</div>
        <div class="panel-body">
          <form class="bs-example form-horizontal">
            <div class="form-group">
              <label class="col-lg-2 control-label">Email</label>
              <div class="col-lg-10">
                <input type="email" class="form-control" placeholder="Email">
                <span class="help-block m-b-none">Example block-level help text here.</span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Password</label>
              <div class="col-lg-10">
                <input type="password" class="form-control" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">
                <div class="checkbox">
                  <label class="i-checks">
                    <input type="checkbox" checked><i></i> Remember me
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-sm btn-info">Sign in</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="./jquery-1.7.js"></script>
  <script src="./instyle/index/js/laydate.dev.js"></script>
  <script>
      laydate({

            elem: '#J-xl'

        });

      $(function(){
          $("#J-xl").blur(function(){
              //获取当前时间
              var starttime = $(this).val();
              var strtime = Date.parse(new Date(starttime))/1000;
              var newtime = Date.parse(new Date())/1000;
              if(strtime>newtime){
                alert("不能大于当前时间");
              }
          })
      })

  </script>