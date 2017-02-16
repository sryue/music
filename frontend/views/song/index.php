
<?php
use yii\widgets\ActiveForm;
?>
<script src="jquery.js"></script>
<link rel="stylesheet" type="text/css" href="./diyUpload/css/webuploader.css">
<link rel="stylesheet" type="text/css" href="./diyUpload/css/diyUpload.css">
<script type="text/javascript" src="./diyUpload/js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="./diyUpload/js/diyUpload.js"></script>
<style>
*{ margin:0; padding:0;}
#box{ margin-left:200px; auto; width:750px; min-height:400px; background:#FF9}
p{ margin-top: 5px;margin-bottom: 5px;}
</style>
<div class="bg-light lter b-b wrapper-md">
  <h1 class="m-n font-thin h3">添加歌曲</h1>
</div>
<div class="wrapper-md" ng-controller="FormDemoCtrl">
  <div class="row">
  </div>
  <div class="panel panel-default">
    <div class="panel-heading font-bold">
      添加歌曲
    </div>
    <div class="panel-body">
      <form class="form-horizontal" method="post" action="?r=song/addsong" enctype="multipart/form-data">
        <div class="form-group">
          <label class="col-sm-2 control-label">歌曲风格</label>
           <div class="col-sm-10">
            <select name="style_id" class="form-control m-b">
                <?php foreach($styleList as $k=>$v){?>
                    <option value="<?php echo $v['style_id']?>"><?php echo $v['style_name']?></option>
                <?php }?>
            </select>
           </div>                     
        </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
          <label class="col-sm-2 control-label">歌曲名称</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name='music_name'>
            <input type='button' value='检查是否重复' id='check'>
          </div>
        </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-id-1">演唱者</label>
           <div class="col-sm-10">
              <input type="text" class="form-control" id="songer">
              <span id='songerTs'>必须填写存在的歌手</span>&nbsp;&nbsp;<a href="?r=actor/actorshow" style="color: blue">去查看歌手</a>
              <input type='hidden' name='actor_id'>
              <div style="border:2px #CCCCCC solid;display:none" id="tailresult">

              </div>
           </div> 
        </div>
          <div class="line line-dashed b-b line-lg pull-in"></div>
          <div class="form-group">
              <label class="col-sm-2 control-label" for="input-id-1">所属专辑</label>
              <div class="col-sm-10">
                  <select name="spe_id" class="form-control m-b">
                  <?php foreach($speciList as $k=>$v){?>
                      <option value="<?php echo $v['spe_id']?>"><?php echo $v['spe_name']?></option>
                  <?php }?>
                  </select>
              </div>
          </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
          <label class="col-sm-2 control-label">语种</label>
          <div class="col-sm-10">
            <select name="language" class="form-control m-b">
                <?php foreach($langList as $k=>$v){?>
                    <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                <?php }?>
            </select>
          </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
          <label class="col-sm-2 control-label">歌曲文件</label>
          <div class="col-sm-10" >
            <input type='file' name='song'>
          </div>
        </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
          <label class="col-sm-2 control-label">高音质文件</label>
          <div class="col-sm-10">
              <input type='file' name='songbest'>
          </div>
        </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
          <label class="col-lg-2 control-label">歌词文件</label>
          <div class="col-lg-10">
            <input type='file' name='lyrics'>
          </div>
        </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
          <label class="col-lg-2 control-label">歌曲图片</label>
            <div id="box" style="margin-left: 230px;">
            <div id="test" ></div>
            </div>
        </div>                    
        <input type='hidden' name='music_img' >
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
          <div class="col-sm-4 col-sm-offset-2">
            <button type="submit" class="btn btn-sm btn-info" id='smtform'>提交</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$('#test').diyUpload({
  url:'?r=song/uploadimg',
  success:function( data ) {
    var result = eval(data);
    var imgpath = $("input[name=music_img]").val();
    if(imgpath=='')
    {
      imgpath = result.imgpath;
    }else
    {
      imgpath = imgpath + ',' + result.imgpath;
    }
    $("input[name=music_img]").val(imgpath);
  },
  error:function( err ) {
    console.info( err );  
  },
  buttonText : '选择文件',
  chunked:true,
  // 分片大小
  chunkSize:512 * 1024,
  //最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
  fileNumLimit:50,
  fileSizeLimit:500000 * 1024,
  fileSingleSizeLimit:50000 * 1024,
  accept: {}
});

//$("#songer").keyup(function(e)
//{
//    if(!e) var e = window.event;
//       //尾词查询
//       var value = $(this).val();
//       if(value=='')
//       {
//          $("input[name=actor_id]").val('');
//          $("#tailresult").hide();
//          return false;
//       }
//          $.ajax({
//             type: "post",
//             url: "?r=song/tailsearch",
//             data: "value="+value,
//             dataType:'json',
//             success: function(result){
//                var str = '';
//                $(result).each(function(i){
//                   str += "<p><a href='javascript:void(0)' class='Aresult' acc="+ $(this)[0].actor_id +">"+ $(this)[0].actor_name +"</a></p>";
//                })
//                if(str!='')
//                {
//                    $("#tailresult").empty();
//                    $("#tailresult").append(str);
//                    $("#tailresult").show();
//                }
//             }
//            });
//})
//鼠标放上去事件
$(document).on('mouseover','.Aresult',function()
{
    $(this).parent().siblings().css({"background":'#fff'});
    $(this).parent().css({"background":'#F0F0F0'});
})
//鼠标点击事件
$(document).on('click','.Aresult',function()
{
   $("#songer").val($(this).html());
   $("input[name=actor_id]").val();
   $("input[name=actor_id]").val($(this).attr('acc'));
   $("#songerTs").empty();
   $("#songerTs").append("<span style='color:green'>可以使用该名称</span>"); 
   $("#tailresult").hide();
})
//检查是否重复
$("#check").click(function()
{
    var value = $("input[name=music_name]").val();
    if(value=='')
    {
       alert('请先输入歌曲名称');
    }else
    {
         $.ajax({
         type: "POST",
         url: "?r=song/checksong",
         data: "value="+value,
         success: function(msg){
            if(msg == 1)
            {
                alert('可以使用该名称');
            }else
            {
                alert('该名称已经存在');
            }
         }
        });
    }
})

$("#songer").blur(function()
{
    var songer = $("#songer").val();
    $.ajax({
     type: "POST",
     url: "?r=song/checkactor",
     data: "songer="+songer,
     success: function(msg){
        if(msg == 0)
        {
            $("#songerTs").empty();
            $("#songerTs").append("<span style='color:red'>请输入正确的歌手名</span>");  
        }else
        {
            $("input[name=actor_id]").val();
            $("input[name=actor_id]").val(msg);
            $("#songerTs").empty();
            $("#songerTs").append("<span style='color:green'>可以使用该名称</span>");  
        }
     }
   });
})
</script>