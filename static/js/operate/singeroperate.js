layui.use(['layer','form'], function() {
    var layer = layui.layer //获取当前窗口的layer对象
    form = layui.form()

    form.render('checkbox');
    form.on('checkbox(allselector)', function(data) {
        var elem = data.elem;

        //重新渲染复选框
        $('#content').children('tr').each(function() {
            var $that = $(this);
            //全选或反选
            $that.children('td').eq(0).children('input[type=checkbox]')[0].checked = elem.checked;
            form.render('checkbox');
        });
    });

    //绑定所有编辑按钮事件
    $('#content').children('tr').each(function() {
        var $that = $(this);
        $that.children('td:last-child').children('a[data-opt=edit]').on('click', function() {
            //layer.msg($(this).data('name'));
            var id = $(this).data('id');
            console.log(id);
            layer.open({
                title: '编辑歌手',
                type: 2,
                content: 'singer_edit/'+id,
                area: ['400px','450px'],
                maxmin: true
            })
        });
    });

    //绑定所有删除按钮事件
    $('#content').children('tr').each(function() {
        var $that = $(this);
        $that.children('td:last-child').children('a[data-opt=del]').on('click', function() {
            var name = $(this).data('name');
            var id = $(this).data('id');
            layer.confirm('是否要删除歌手 ' + name + ' ?',function(){
                $.ajax({
                    type: 'post',
                    url: 'delsinger',
                    data: {'id':id},
                    dataType: 'json',
                    success: function(result){
                        if(result.status == 1){
                            layer.msg('删除成功');
                            var t = setTimeout("location.reload()",1500);
                        }else{
                            layer.msg('删除失败');
                            var t = setTimeout("location.reload()",1500);
                        }
                    }
                });
            });
        });
    });

    //获取所有选择的列
    $('#getSelected').on('click', function () {
        var names = [];
        var ids = [];
        $('#content').children('tr').each(function () {
            var $that = $(this);
            var $cbx = $that.children('td').eq(0).children('input[type=checkbox]')[0].checked;
            if ($cbx) {
                var n = $that.children('td:last-child').children('a[data-opt=edit]').data('name');
                var id = $that.children('td:last-child').children('a[data-opt=edit]').data('id');
                names.push(n);
                ids.push(id);
            }
        });
        if(names == ''){
            layer.msg('没有选中的数据！');
        }else{
            console.log(ids)
            layer.confirm('是否要删除歌手 ' + names + ' ？',function(){
                $.ajax({
                    type: 'post',
                    url: 'delsinger',
                    data: {'id':ids},
                    dataType: 'json',
                    success: function(result){
                        if(result.status == 1){
                            layer.msg('删除成功');
                            var t = setTimeout("location.reload()",1500);
                        }else{
                            layer.msg('删除失败');
                            var t = setTimeout("location.reload()",1500);
                        }
                    }
                })
            });
        }
    });

    // $('#search').on('click', function () {
    //     var name = $('#search-content').val();
    // 	console.log(name)
    // 	$.ajax({
    // 		type: 'post',
    // 		url: 'searchuser',
    // 		data: {'name':name},
    // 		success: function(result){
    // 			$("#content").html(result);
    // 		}
    // 	});
    // });

    $('#add').on('click', function () {
        layer.open({
            title: '添加歌手',
            type: 2,
            content: 'singer_add',
            area: ['400px','450px'],
            maxmin: true
        })
    })
})
