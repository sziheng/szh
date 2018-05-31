@extends('admin.layout.main')
@section('content')
    <link href="/css/style.css" rel="stylesheet">
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>订单管理 <small>{{$typename}}</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <span>订单数:  <span class='text-danger'>{$total}</span> 订单金额:  <span class='text-danger'>{$totalmoney}</span> 订单成本:  <span class='text-danger'>{$totalcostprice}</span> 运费合计:  <span class='text-danger'>{$totaldispatchprice}</span>{if !empty($magent['nickname'])}订单推广人:  <span class='text-danger'>{$magent['nickname']}</span>{/if}</span>

                        <form action="./index.php" method="get" class="form-horizontal table-search" role="form">
                            <input type="hidden" name="c" value="site" />
                            <input type="hidden" name="a" value="entry" />
                            <input type="hidden" name="m" value="weshop" />
                            <input type="hidden" name="do" value="web" />
                            <input type="hidden" name="r" value="order.list{$st}" />
                            <input type="hidden" name="status" value="{$status}" />
                            <input type="hidden" name="agentid" value="{$_GPC['agentid']}" />
                            <input type="hidden" name="refund" value="{$_GPC['refund']}" />
                            <div class="page-toolbar row m-b-sm m-t-sm">
                                <div class="col-sm-7">

                                    <div class="btn-group btn-group-sm" style='float:left'>
                                        <button class="btn btn-default btn-sm"  type="button" data-toggle='refresh'><i class='fa fa-refresh'></i></button>

                                    </div>


                                    <div class='input-group input-group-sm'   >
                                        <select name="paytype" class="form-control input-sm select-md" style="width:85px;padding:0 5px;">
                                            <option value="" {if $_GPC['paytype']==''}selected{/if}>支付方式</option>
                                            {loop $paytype $key $type}
                                            <option value="{$key}" {if $_GPC['paytype'] == "$key"} selected="selected" {/if}>{$type['name']}</option>
                                            {/loop}
                                        </select>
                                        <select name='searchtime'  class='form-control  input-sm select-md'   style="width:85px;padding:0 5px;"  >
                                            <option value=''>不按时间</option>
                                            <option value='create' {if $_GPC['searchtime']=='create'}selected{/if}>下单时间</option>
                                            <option value='pay' {if $_GPC['searchtime']=='pay'}selected{/if}>付款时间</option>
                                            <option value='send' {if $_GPC['searchtime']=='send'}selected{/if}>发货时间</option>
                                            <option value='finish' {if $_GPC['searchtime']=='finish'}selected{/if}>完成时间</option>
                                        </select>

                                        {php echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d H:i', $endtime)),true);}

                                    </div>
                                </div>


                                <div class="col-sm-5 pull-right">

                                    <select name='searchfield'  class='form-control  input-sm select-md'   style="width:95px;padding:0 5px;"  >

                                        <option value='ordersn' {if $_GPC['searchfield']=='ordersn'}selected{/if}>订单号</option>
                                        <option value='member' {if $_GPC['searchfield']=='member'}selected{/if}>会员信息</option>
                                        <option value='address' {if $_GPC['searchfield']=='address'}selected{/if}>收件人信息</option>
                                        <option value='expresssn' {if $_GPC['searchfield']=='expresssn'}selected{/if}>快递单号</option>
                                        <option value='goodstitle' {if $_GPC['searchfield']=='goodstitle'}selected{/if}>商品名称</option>
                                        <option value='goodssn' {if $_GPC['searchfield']=='goodssn'}selected{/if}>商品编码</option>
                                        <option value='saler' {if $_GPC['searchfield']=='saler'}selected{/if}>核销员</option>
                                        <option value='store' {if $_GPC['searchfield']=='store'}selected{/if}>核销门店</option>
                                        {if $merch_plugin}
                                        <option value='merch' {if $_GPC['searchfield']=='merch'}selected{/if}>商户名称</option>
                                        {/if}
                                        <option value='activity' {if $_GPC['searchfield']=='activity'}selected{/if}>活动名称</option>
                                    </select>
                                    <div class="input-group">
                                        <input type="text" class="form-control input-sm"  name="keyword" value="{$_GPC['keyword']}" placeholder="请输入关键词"/>
                                        <span class="input-group-btn">

                    <button class="btn btn-sm btn-primary" type="submit"> 搜索</button>
                    <button type="submit" name="export" value="1" class="btn btn-success btn-sm">导出</button>


                </span>
                                    </div>

                                </div>
                            </div>

                        </form>

                        {if count($list)>0}
                        <table class='table table-responsive' style='table-layout: fixed;'>
                            <tr style='background:#f8f8f8'>
                                <td style='width:60px;border-left:1px solid #f2f2f2;'>商品</td>
                                <td style='width:150px;'></td>
                                <td style='width:70px;text-align: right;;'>单价/数量</td>
                                <td  style='width:100px;text-align: center;'>买家</td>
                                <td style='width:90px;text-align: center;'>支付/配送</td>
                                <td style='width:100px;text-align: center;'>价格</td>
                                <td style='width:100px;text-align: center;'>下单时间</td>
                                <td style='width:90px;text-align: center'>状态</td>

                            </tr>
                            {loop $list $item}
                            <tr ><td colspan='8' style='height:20px;padding:0;border-top:none;'>&nbsp;</td></tr>
                            <tr class='trorder'>
                                <td colspan='4' >
                                    订单编号:  {$item['ordersn']}
                                    &nbsp;订单成本:  {$item['costprice']}
                                    {if !empty($item['refundstate'])}<label class='label label-danger'>{$r_type[$item['rtype']]}申请</label>{/if}
                                    {if !empty($item['refundstate']) && $item['rstatus'] == 4}<label class='label label-default'>客户退回物品</label>{/if}
                                </td>
                                <td colspan='4' style='text-align:right;font-size:12px;' class='aops'>

                                    {if $item['merchid'] == 0}
                                    {if empty($item['statusvalue'])}
                                    {if $item['ismerch'] == 0}
                                    {ifp 'order.op.close'}
                                    <a class='op'  data-toggle='ajaxModal' href="{php echo webUrl('order/op/close',array('id'=>$item['id']))}" >关闭订单</a>
                                    {/if}
                                    {/if}
                                    {ifp 'order.op.changeprice'}
                                    <a class='op'  data-toggle='ajaxModal' href="{php echo webUrl('order/op/changeprice',array('id'=>$item['id']))}">订单改价</a>
                                    {/if}
                                    {/if}
                                    {/if}

                                    {if !empty($item['refundid'])}
                                    <a class='op'  href="{php echo webUrl('order/op/refund', array('id' => $item['id']))}" >维权{if $item['refundstate']>0}处理{else}详情{/if}</a>
                                    {/if}

                                    {if $item['merchid'] == 0}
                                    {if $item['statusvalue'] == 2 && !empty($item['addressid'])}
                                    {ifp 'order.op.send'}
                                    <a class="op" data-toggle="ajaxModal"  href="{php echo webUrl('order/op/changeexpress', array('id' => $item['id']))}">修改物流</a>
                                    {/if}
                                    {/if}
                                    {/if}

                                    <a class='op'  href="{php echo webUrl('order/detail', array('id' => $item['id']))}" >查看详情</a>
                                    {if $item['addressid']!=0 && $item['statusvalue']>=2}
                                    <a class='op'  data-toggle="ajaxModal" href="{php echo webUrl('util/express', array('id' => $item['id'],'express'=>$item['express'],'expresssn'=>$item['expresssn']))}"   >物流信息</a>
                                    {/if}
                                    {if $item['merchid'] == 0}
                                    {ifp 'order.op.remarksaler'}
                                    <a class='op'  data-toggle="ajaxModal" href="{php echo webUrl('order/op/remarksaler', array('id' => $item['id']))}" {if !empty($item['remarksaler'])}style='color:red'{/if} >备注</a>
                                    {/if}
                                    {/if}

                                    <!--<a class='op'   href="{php echo webUrl('order', array('op' => 'detail', 'id' => $item['id']))}" >标记</a>-->
                                </td>
                            </tr>
                            {loop $item['goods'] $k $g}
                            <tr class='trbody'>
                                <td style='overflow:hidden;'><img src="{php echo tomedia($g['thumb'])}" style='width:50px;height:50px;border:1px solid #ccc; padding:1px;'></td>
                                <td style='text-align: left;overflow:hidden;border-left:none;'  >{$g['title']}{if !empty($g['optiontitle'])}<br/>{$g['optiontitle']}{/if}<br/>{$g['goodssn']}</td>
                                <td style='text-align:right;border-left:none;'>{php echo number_format($g['realprice']/$g['total'],2)}<br/>x{$g['total']}</td>

                                {if $k==0}
                                <td rowspan="{php echo count($item['goods'])}"  style='text-align: center;' >
                                    {ifp 'member.member.edit'}
                                    <a href="{php echo webUrl('member/list/detail',array('id'=>$item['mid']))}"> {$item['nickname']}</a>
                                    {else}
                                    {$item['nickname']}
                                    {/if}

                                    <br/>
                                    {$item['addressdata']['realname']}<br/>{$item['addressdata']['mobile']}</td>
                                <td rowspan="{php echo count($item['goods'])}" style='text-align:center;' >

                                    {if $item['statusvalue'] > 0}
                                    <label class='label label-{$item['css']}'>{$item['paytype']}</label>
                                    {else if $item['statusvalue'] == 0}
                                    {if $item['paytypevalue']!=3}
                                    <label class='label label-default'>未支付</label>
                                    {else}
                                    <label class='label label-primary'>货到付款</label>
                                    {/if}
                                    {else if $item['statusvalue'] == -1}
                                    <label class='label label-default'>{$item['paytype']}</label>
                                    {/if}
                                    <br/>


                                    <span style='margin-top:5px;display:block;'>{$item['dispatchname']}</span>

                                </td>
                                <td  rowspan="{php echo count($item['goods'])}" style='text-align:center' >
                                    ￥{php echo number_format($item['price'],2)} <a data-toggle='popover' data-html='true' data-placement='top'
                                                                                   data-content="<table style='width:100%;'>
                <tr>
                    <td  style='border:none;text-align:right;'>商品小计：</td>
                    <td  style='border:none;text-align:right;;'>￥{php echo number_format( $item['goodsprice'] ,2)}</td>
                </tr>
                <tr>
                    <td  style='border:none;text-align:right;'>运费：</td>
                    <td  style='border:none;text-align:right;;'>￥{php echo number_format( $item['olddispatchprice'],2)}</td>
                </tr>
                {if $item['discountprice']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>会员折扣：</td>
                    <td  style='border:none;text-align:right;;'>-￥{php echo number_format( $item['discountprice'],2)}</td>
                </tr>
                {/if}
                {if $item['deductprice']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>积分抵扣：</td>
                    <td  style='border:none;text-align:right;;'>-￥{php echo number_format( $item['deductprice'],2)}</td>
                </tr>
                {/if}
                {if $item['deductcredit2']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>余额抵扣：</td>
                    <td  style='border:none;text-align:right;;'>-￥{php echo number_format( $item['deductcredit2'],2)}</td>
                </tr>
                {/if}
                {if $item['deductenough']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>商城满额立减：</td>
                    <td  style='border:none;text-align:right;;'>-￥{php echo number_format( $item['deductenough'],2)}</td>
                </tr>
                {/if}
                {if $item['merchdeductenough']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>商户满额立减：</td>
                    <td  style='border:none;text-align:right;;'>-￥{php echo number_format( $item['merchdeductenough'],2)}</td>
                </tr>
                {/if}
                {if $item['couponprice']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>优惠券优惠：</td>
                    <td  style='border:none;text-align:right;;'>-￥{php echo number_format( $item['couponprice'],2)}</td>
                </tr>
                {/if}
                {if $item['isdiscountprice']>0}
                <tr>
                    <td  style='border:none;text-align:right;'>促销优惠：</td>
                    <td  style='border:none;text-align:right;;'>-￥{php echo number_format( $item['isdiscountprice'],2)}</td>
                </tr>
                {/if}
                {if intval($item['changeprice'])!=0}
                <tr>
                    <td  style='border:none;text-align:right;'>卖家改价：</td>
                    <td  style='border:none;text-align:right;;'><span style='{if 0<$item['changeprice']}color:green{else}color:red{/if}'>{if 0<$item['changeprice']}+{else}-{/if}￥{php echo number_format(abs($item['changeprice']),2)}</span></td>
                </tr>
                {/if}
                {if intval($item['changedispatchprice'])!=0}
                <tr>
                    <td  style='border:none;text-align:right;'>卖家改运费：</td>
                    <td  style='border:none;text-align:right;;'><span style='{if 0<$item['changedispatchprice']}color:green{else}color:red{/if}'>{if 0<$item['changedispatchprice']}+{else}-{/if}￥{php echo abs($item['changedispatchprice'])}</span></td>
                </tr>
                {/if}
                <tr>
                    <td style='border:none;text-align:right;'>应收款：</td>
                    <td  style=`'border:none;text-align:right;color:green;'>￥{php echo number_format($item['price'],2)}</td>
                </tr>

            </table>
"
                                    ><i class='fa fa-question-circle'></i></a>
                                    {if $item['dispatchprice']>0}
                                    <br/>(含运费:￥{php echo number_format( $item['dispatchprice'],2)})
                                    {/if}


                                </td>
                                <td  rowspan="{php echo count($item['goods'])}" style='text-align:center' >
                                    {php echo date('Y-m-d',$item['createtime'])}<br/>{php echo date('H:i:s',$item['createtime'])}

                                </td>

                                <td   rowspan="{php echo count($item['goods'])}" class='ops' style='line-height:20px;text-align:center' ><span class='text-{$item['statuscss']}'>{$item['status']}</span><br />{template 'order/ops'}
                                </td>

                                {/if}
                            </tr>
                            {/loop}
                            {if !empty($item['remark'])}
                            <tr ><td colspan='8' style='background:#fdeeee;color:red;'>买家备注: {$item['remark']}</td></tr>
                            {/if}

                            {if !empty($level) || (!empty($item['merchname']) && $item['merchid'] > 0)}
                            <tr style=";border-bottom:none;background:#f9f9f9;">
                                <td colspan='4' style='text-align:left'>
                                    {if !empty($item['merchname']) && $item['merchid'] > 0}
                                    商户名称:<span class="text-info">{$item['merchname']}</span>
                                    {/if}
                                    {if !empty($agentid) &&1==2}
                                    <b>分销订单级别:</b> {$item['level']}级 <b>分销佣金:</b> {$item['commission']} 元
                                    {/if}
                                </td>
                                <td colspan='4' style='text-align:right'>
                                    {if empty($agentid) &&1==2}
                                    {if $item['commission1']!=-1}<b>1级佣金:</b> {$item['commission1']} 元 {/if}
                                    {if $item['commission2']!=-1}<b>2级佣金:</b> {$item['commission2']} 元 {/if}
                                    {if $item['commission3']!=-1}<b>3级佣金:</b> {$item['commission3']} 元 {/if}
                                    {/if}

                                    {if !empty($item['agentid']) && !$is_merch[$item['id']] &&1==2}
                                    {ifp 'commission.changecommission'}
                                    <a data-toggle="ajaxModal"  href="{php echo webUrl('commission/apply/changecommission', array('id' => $item['id']))}">修改佣金</a>
                                    {/if}
                                    {/if}
                                </td></tr>
                            {/if}
                            {/loop}
                        </table>
                        <div style="text-align:right;width:100%;">
                            {$pager}
                        </div>
                        {else}

                        <div class='panel panel-default'>
                            <div class='panel-body' style='text-align: center;padding:30px;'>
                                暂时没有任何订单!
                            </div>
                        </div>
                        {/if}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection