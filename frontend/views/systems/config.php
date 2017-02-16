<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">网站配置</h1>
</div>

<div class="panel panel-default">
    <div class="panel-heading font-bold">
        <a href="?r=systems/createconfig" style="color: blue"> + 添加配置</a>
    </div>
    <form action="?r=systems/saveconfig" method="post">
    <table class="table m-b-none" ui-jq="footable" data-filter="#filter" data-page-size="5">
        <thead>
        <tr>
            <th data-toggle="true">
                排序
            </th>
            <th>
                ID
            </th>
            <th data-hide="phone,tablet">
                标题
            </th>
            <th data-hide="phone,tablet">
                名称
            </th>
            <th data-hide="phone,tablet">
                内容
            </th>
            <th data-hide="phone">
                操作
            </th>
        </tr>
        </thead>
        <tbody> 
            <?php foreach($configList as $k=>$v){?>
            <tr>
                <td width="30px"><input type="text" value="<?php echo $v['conf_order']?>" size="5" style="text-align: center" name="data[<?php echo $v['conf_id']?>][order]"></td>
                <td width="30px"><?php echo $v['conf_id']?></td>
                <td width="200px"><a href="javascript:void(0)"><?php echo $v['conf_title']?></a></td>
                <td width="300px"><?php echo $v['conf_name']?></td>
                <td width="300px"><?php echo $v['conf_content']?></td>
                <td><a href=""> 删除</a></td>
            </tr>
        <?php }?>
        </tbody>
        <tfoot class="hide-if-no-paging">
    </table>
        &nbsp;&nbsp;<button type="submit" class="btn btn-primary">保存</button>
    </form>
</div>
</div>