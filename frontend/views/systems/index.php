<div class="bg-light lter b-b wrapper-md">
  <h1 class="m-n font-thin h3">轮播图</h1>
</div>

  <div class="panel panel-default">
    <div class="panel-heading font-bold">
      <a href="?r=systems/carousel_show">轮播图列表</a>
    </div>
    <div class="panel-body">
      <form class="form-horizontal" action="?r=systems/carousel" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label class="col-sm-2 control-label">轮播图名称</label>
          <div class="col-sm-10">
            <input type="text" class="form-control rounded" name="car_name">                        
          </div>
        </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
          <label class="col-sm-2 control-label">图片</label>
          <div class="col-sm-10">
            <input ui-jq="filestyle" type="file" name="car_file" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s">
          </div>
        </div>
    
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
          <label class="col-sm-2 control-label">专辑介绍</label>
          <textarea name="car_content" id="" cols="100" rows="7"></textarea>
        
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
          <div class="col-sm-4 col-sm-offset-2">
            <button type="reset" class="btn btn-default">重置</button>
            <button type="submit" class="btn btn-primary">增加</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>