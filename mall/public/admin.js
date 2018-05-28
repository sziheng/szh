$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
})
//商品分类显示/隐藏事件
$(function(){
    $('.ishome').click(function(){
        var t = $(this);
        var id = $(this).data('id');
        if (t.html() == '隐藏') {
            ishome = 1;
        } else {
            ishome = 0
        }
        $.post("/category/"+id+"/ishome",{ishome:ishome},function(result){
            if (result.error){
                alert(result.msg)
            }else{
                if(ishome == 1){
                    t.attr('class','btn ishome btn-info  btn-xs');
                    t.html('显示')
                } else {
                    t.attr('class','btn ishome btn-default  btn-xs')
                    t.html('隐藏')
                }

            }
        });
    })


    //加载显示数据
    //1.加载省份
    FillSheng();

    //2.加载市
    //    FillShi();
    // //3.加载区
    //    FillQu();

    //当省份选中变化，重新加载市和区
    $("#sheng").change(function(){ //当元素的值发生改变时，会发生 change 事件,该事件仅适用于文本域（text field），以及 textarea 和 select 元素。
        //加载市
        FillShi();
        //加载区
        FillQu();

    });

    //当市选中变化，重新加载区
    $("#shi").change(function(){
        //加载区
        FillQu();
    })

})




//加载省份信息
function FillSheng()
{
    //取父级代号
    var pcode ="0";

    //根据父级代号查数据
    $.ajax({
        //取消异步，也就是必须完成上面才能走下面
        async:false,
        url:"/good/address",
        data:{pcode:pcode},
        type:"POST",
        dataType:"JSON",
        success: function(data){
            var str="";
            //遍历数组，把它放入sj
            for(var sj in data){
                str=str+"<option value='"+data[sj].Add_Code+"'>"+data[sj].Add_Name +"</option>";
            }
            var yuan=$('#sheng').html();
            $("#sheng").html(yuan+str);

        }
    });
}

//加载市信息
function FillShi()
{
    //取父级代号
    var pcode =$("#sheng").val();

    //根据父级代号查数据
    $.ajax({
        //取消异步，也就是必须完成上面才能走下面
        async:false,
        url:"/good/address",
        data:{pcode:pcode},
        type:"POST",
        dataType:"JSON",
        success: function(data){
            var str="";
            //遍历数组，把它放入sj
            for(var sj in data){
                //<option value="11">北京</option>
                str=str+"<option value='"+data[sj].Add_Code+"'>"+data[sj].Add_Name +"</option>";
            }
            $("#shi").html(str);

        }



    });

}


//加载区信息
function FillQu()
{
    //取父级代号
    var pcode =$("#shi").val();

    //根据父级代号查数据
    $.ajax({
        //不需要取消异步
        url:"/good/address",
        data:{pcode:pcode},
        type:"POST",
        dataType:"JSON",
        success: function(data){
            var str="";
            //遍历数组，把它放入sj
            for(var sj in data){
                //<option value="11">北京</option>
                str=str+"<option value='"+data[sj].Add_Code+"'>"+data[sj].Add_Name +"</option>";

            }
            $("#qu").html(str);

        }



    });

}








