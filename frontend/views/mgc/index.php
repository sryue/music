<div class="panel panel-default">
<div class="panel-body">
      <form class="form-inline" role="form" action="" method="post">
        <div class="form-group" id="aa">
          <input type="text" name="min" class="form-control" id="min" placeholder="请输入敏感词语">
        </div>
        <span ng-controller="ModalDemoCtrl">
        <button type="button" class="btn btn-default" id="btn1">追加</button>
        <button type="button" class="btn btn-success" id="btn2">提交</button>
        </span>
      </form>
    </div>	
</div>
  <script src="./jquery-1.7.js"></script>
<script>
	//敏感词追加
	$(function(){
		$("#btn1").click(function(){
			var input = '<input type="text" name="min" class="form-control" id="min" placeholder="请输入敏感词语">';
			$("#aa").append(input);
		})


		$("#btn2").click(function(){
			var name = [];
			$("input[name^=min]").each(function(a_Idx, a_Elmt) { name.push(a_Elmt.value); });
			var name1=name.join(",");
			// alert(name1);return false;
			$.ajax({
			   type: "get",
			   url: "?r=mgc/min",
			   data: "name1="+name1,
			   success: function(msg){
			     if(msg == 1 ){
			     	window.history.go(0);
			     }else{
			     	alert("以有敏感词，请输入其他敏感词...");
			     }
			   }
			});


		});


	})
</script>
