<div class="panel panel-default">
  <div class="panel-heading font-bold">
    艺人添加
  </div>
  <div class="panel-body">
    <form class="form-horizontal" action="?r=special/spe_add" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label class="col-sm-2 control-label">专辑名称</label>
        <div class="col-sm-10">
          <input type="text" name="spe_name" class="form-control rounded">
        </div>
      </div>


      <div class="line line-dashed b-b line-lg pull-in"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">唱片公司</label>
        <div class="col-sm-10">
          <input type="text" name="company" class="form-control rounded">
        </div>
      </div>


      <div class="line line-dashed b-b line-lg pull-in"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">所属艺人</label>
        <div class="col-sm-10">
          <input type="text" name="actor_name" class="form-control rounded">
            <input type="button" value="检测艺人是否可用" id="check_act" style="margin-left: 20px">
            <input type="hidden" name="actor_id" value="">
        </div>
      </div>


      <div class="line line-dashed b-b line-lg pull-in"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">发行时间</label>
        <div class="col-sm-10">
          <input type="text" name="issue_time" class="form-control rounded">
        </div>
      </div>


      <div class="line line-dashed b-b line-lg pull-in"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">歌曲语种</label>
        <div class="col-sm-10">
          <select name="spe_language" class="form-control m-b">
              <?php foreach($info['language'] as $k => $v){?>
              <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
              <?php } ?>
          </select>
        </div>
      </div>
      <div class="line line-dashed b-b line-lg pull-in"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">歌曲风格</label>
        <div class="col-sm-10">
          <select name="spe_style" class="form-control m-b">
            <?php foreach($info['style'] as $k => $v){?>
              <option value="<?php echo $v['style_id']?>"><?php echo $v['style_name']?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="line line-dashed b-b line-lg pull-in"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">专辑封面</label>
        <div class="col-sm-10">
          <input ui-jq="filestyle" type="file" name="spe_img" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s">
        </div>
      </div>
      <div class="line line-dashed b-b line-lg pull-in"></div>

      <div class="form-group">
        <label class="col-sm-2 control-label">专辑介绍</label>
        <div class="col-sm-10">

          <textarea ui-jq="wysiwyg" name="spe_desc" class="form-control" style="overflow:scroll;height:200px;max-height:200px" placeholder="输入专辑介绍。"></textarea>
        </div>
      </div>

      <div class="line line-dashed b-b line-lg pull-in"></div>
      <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
          <button type="reset" class="btn btn-default">重置</button>
          <button type="submit" class="btn btn-primary">保存</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="./jquery.js"></script>
<script>
  $(function(){
      $('#check_act').click(function(){
          var _this = $(this);
          var actor_name = $(this).prev().val();
          $.ajax({
              url:"?r=song/checkactor",
              data:"songer="+actor_name,
              type:"post",
              success:function(msg)
              {
                  if(msg)
                  {
                      alert('该艺人名可用！');
                      _this.next().val(msg);
                  }
                  else
                  {
                       alert('该艺人不存在,重新添加！');
                  }
              }
          })
      })
//    $(document).on('change','.region',function(){
//      var obj = $('.region');
//
//      var reg_id = $(this).val();
//      var _this = $(this);
//      var url = "?r=actor/get_area";
//      if(obj.length < 8)
//      {
//        $.get(url,{'parent_id':reg_id},function(msg){
//          if(msg != "")
//          {
//            var html = '<select name="region[]" class="form-control region" style="width: 150px;float: left;">';
//            $(msg).each(function(k,v){
//              html+="<option value='"+ v.area_id+"'>"+ v.area_name+"</option>";
//            })
//            html+= "</select>";
//            _this.nextAll().remove();
//            _this.after(html);
//          }
//        },'json')
//      }
//
//    })
  })
</script>
