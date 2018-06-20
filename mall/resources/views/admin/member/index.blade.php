@extends('admin.layout.main')
@section('content')
    <style>
        .spiner-example{height:200px;padding-top:70px}
        .sk-spinner-wave.sk-spinner{margin:0 auto;width:50px;height:30px;text-align:center;font-size:10px}
        .sk-spinner-wave div{background-color:#1ab394;height:100%;width:6px;display:inline-block;-webkit-animation:sk-waveStretchDelay 1.2s infinite ease-in-out;animation:sk-waveStretchDelay 1.2s infinite ease-in-out}
        .sk-spinner-wave .sk-rect2{-webkit-animation-delay:-1.1s;animation-delay:-1.1s}
        .sk-spinner-wave .sk-rect3{-webkit-animation-delay:-1s;animation-delay:-1s}
        .sk-spinner-wave .sk-rect4{-webkit-animation-delay:-.9s;animation-delay:-.9s}
        .sk-spinner-wave .sk-rect5{-webkit-animation-delay:-.8s;animation-delay:-.8s}
        .echarts {
            height: 240px;
        }
    </style>
    <div class="right_col" role="main">
        <div class="page-heading"> <h2>会员概述</h2> </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">
                    <div class="ibox-title">
                        <!--<span class="label label-success pull-right">月</span>-->
                        <h5>今日新增会员</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins today-count">--</h1>
                        <div class="stat-percent font-bold text-success"><span class="today-rate">--</span>%<i class="fa fa-level-up"></i>
                        </div>
                        <small>新增会员</small>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">
                    <div class="ibox-title">
                        <!--<span class="label label-success pull-right">月</span>-->
                        <h5>昨日新增会员</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins yesterday-count">--</h1>
                        <div class="stat-percent font-bold text-info"><span class="yesterday-rate">--</span>% <i class="fa fa-level-up"></i>
                        </div>
                        <small>新增会员</small>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">
                    <div class="ibox-title">
                        <!--<span class="label label-info pull-right">全年</span>-->
                        <h5>过去七天新增会员</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins seven-count">--</h1>
                        <div class="stat-percent font-bold text-warning"><span class="seven-rate">--</span>%<i class="fa fa-level-up"></i>
                        </div>
                        <small>新增会员</small>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">
                    <div class="ibox-title">
                        <h5>会员性别分布</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="echarts" id="echarts-pie-chart" style="display: none"></div>

                        <div class="spiner-example" id="echarts-pie-chart-loading">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">
                    <div class="ibox-title">
                        <h5>会员等级分布</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="echarts" id="echarts-pie-chart1" style="display: none"></div>

                        <div class="spiner-example" id="echarts-pie-chart1-loading">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">
                    <div class="ibox-title">
                        <h5>会员区域分布</h5>
                    </div>
                    <div class="ibox-content">
                        <div style="height:600px;display: none" id="echarts-map-chart" class="echarts" ></div>

                        <div class="spiner-example" id="echarts-map-chart-loading">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script>
            $(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    }
                })
                require(['echarts'],function(){
                    $(function () {
                        $.ajax({
                            type: "GET",
                            url: "/web/member/getMemberInfos",
                            dataType: "json",
                            success: function (json) {
                                var pieChart = echarts.init(document.getElementById("echarts-pie-chart"));
                                var pieoption = {
                                    title: {
                                        text: '男女会员分布',
                                        subtext: '',
                                        x: 'center'
                                    },
                                    tooltip: {
                                        trigger: 'item',
                                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                                    },
                                    legend: {
                                        orient: 'vertical',
                                        x: 'right',
                                        data: ['男', '女', '未知']
                                    },
                                    calculable: true,
                                    series: [
                                        {
                                            name: '男女分布',
                                            type: 'pie',
                                            radius: '55%',
                                            center: ['50%', '60%'],
                                            data: [
                                                {value: json.ajaxmembergender[1], name: '男'},
                                                {value: json.ajaxmembergender[2], name: '女'},
                                                {value: json.ajaxmembergender[0], name: '未知'}
                                            ]
                                        }
                                    ]
                                };
                                $("#echarts-pie-chart-loading").hide()
                                $("#echarts-pie-chart").show();
                                pieChart.setOption(pieoption);
                                pieChart.resize();

                                var pieChart1 = echarts.init(document.getElementById("echarts-pie-chart1"));
                                var pieoption1 = {
                                    title: {
                                        text: '会员等级分布',
                                        subtext: '',
                                        x: 'center'
                                    },
                                    tooltip: {
                                        trigger: 'item',
                                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                                    },
                                    legend: {
                                        orient: 'vertical',
                                        x: 'right',
                                        data: json.ajaxmemberlevel.name
                                    },
                                    calculable: true,
                                    series: [
                                        {
                                            name: '等级分布',
                                            type: 'pie',
                                            radius: '55%',
                                            center: ['40%', '60%'],
                                            data: json.ajaxmemberlevel.data
                                        }
                                    ]
                                };
                                $("#echarts-pie-chart1-loading").hide();
                                $("#echarts-pie-chart1").show();
                                pieChart1.setOption(pieoption1);
                                pieChart1.resize();

                                var mapChart = echarts.init(document.getElementById("echarts-map-chart"));
                                var mapoption = {
                                    title: {
                                        text: '会员分布区域',
                                        subtext: '',
                                        x: 'center'
                                    },
                                    tooltip: {
                                        trigger: 'item'
                                    },
                                    legend: {
                                        orient: 'vertical',
                                        x: 'left',
                                        data: ['会员分布区域']
                                    },
                                    dataRange: {
                                        min: 0,
                                        max: 100,
                                        x: 'left',
                                        y: 'bottom',
                                        text: ['人数'],           // 文本，默认为数值文本
                                        calculable: true
                                    },
                                    toolbox: {
                                        show: true,
                                        orient: 'vertical',
                                        x: 'right',
                                        y: 'center',
                                        feature: {
                                            mark: {show: true},
                                            dataView: {show: true, readOnly: true},
                                            restore: {show: true},
                                            saveAsImage: {show: true}
                                        }
                                    },
                                    roamController: {
                                        show: false,
                                        x: 'right',
                                        mapTypeControl: {
                                            'china': true
                                        }
                                    },
                                    series: [
                                        {
                                            name: '会员分布区域',
                                            type: 'map',
                                            mapType: 'china',
                                            roam: false,
                                            itemStyle: {
                                                normal: {label: {show: true}},
                                                emphasis: {label: {show: true}}
                                            },
                                            data: json.ajaxprovince
                                        }
                                    ]
                                };
                                $("#echarts-map-chart-loading").hide();
                                $("#echarts-map-chart").show();
                                mapChart.setOption(mapoption);
                                mapChart.resize();

                                $(".today-count").text(json.ajaxnewmember0.count);
                                $(".today-rate").text(json.ajaxnewmember0.rate);

                                $(".yesterday-count").text(json.ajaxnewmember1.count);
                                $(".yesterday-rate").text(json.ajaxnewmember1.rate);

                                $(".seven-count").text(json.ajaxnewmember7.count);
                                $(".seven-rate").text(json.ajaxnewmember7.rate);
                            }
                        });
                    });
                });
            })
        </script>
    </div>
@endsection



