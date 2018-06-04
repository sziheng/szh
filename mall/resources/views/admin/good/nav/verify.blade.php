<style type='text/css'>
    body { width:100%;}

    .img-thumbnail { width:100px; height:100px;}
    .img-nickname { height:25px;line-height:25px;width:90px;margin-left:5px;margin-right:5px;position: absolute;bottom:55px;color:#fff;text-align: center;background:rgba(0,0,0,0.7)}
</style>

<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">支持线下核销</label>
    <div class="col-sm-6 col-xs-6">
        {ife 'goods' $item}
        <label class="radio-inline"><input type="radio" name="isverify" value="1" {if empty($item['isverify']) || $item['isverify'] == 1}checked="true"{/if}  /> 不支持</label>
        <label class="radio-inline"><input type="radio" name="isverify" value="2" {if $item['isverify'] == 2}checked="true"{/if}   /> 支持</label>
        {else}
        <div class='form-control-static'>
            {if empty($item['isverify']) || $item['isverify'] == 1}不支持{else}支持{/if}
        </div>
        {/if}

    </div>
</div>

<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">核销类型</label>
    <div class="col-sm-6 col-xs-6">
        {ife 'goods' $item}
        <label class="radio-inline"><input type="radio" name="verifytype" value="0" {if empty($item['verifytype'])}checked="true"{/if}  /> 按订单核销</label>
        <label class="radio-inline"><input type="radio" name="verifytype" value="1" {if $item['verifytype'] == 1}checked="true"{/if}   /> 按次核销</label>
        <label class="radio-inline"><input type="radio" name="verifytype" value="2" {if $item['verifytype'] == 2}checked="true"{/if}   /> 按消费码核销</label>
        {else}
        <div class='form-control-static'>
            {if empty($item['isverify'])}按订单核销{else if $item['verifytype'] == 1}按消费码核销{else if $item['verifytype'] == 2}按次核销{/if}
        </div>
        {/if}
        <p class="help-block">
            按订单核销： 不管够买多少 一次核销完成<br>
            按次核销：  一个消费码使用多次（购买的数量）<br>
            按消费码核销： 多个消费码  一次核销一个
        </p>
    </div>
</div>

