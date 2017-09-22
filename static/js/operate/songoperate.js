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
                title: '编辑歌曲',
                type: 2,
                content: 'song_edit/'+id,
                area: ['450px','500px'],
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
            layer.confirm('是否要删除歌曲 ' + name + ' ?',function(){
                $.ajax({
                    type: 'post',
                    url: 'delsong',
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

    $('#content').children('tr').each(function () {
        var $that = $(this);
        $that.children('td:last-child').prev('td').children('a[data-opt=mv]').on('click',function () {
            var mvurl = $(this).data('mvurl');
            var gqname = $(this).data('name');
            layer.open({
                title: gqname,
                type: 2,
                maxmin: true,
                content: 'video',
                area: ['800px', '500px'],
                success: function (layero,index) {
                    var body = layer.getChildFrame('body',index);
                    body.find('video').attr('src',mvurl);
                }
            })
        })
    })

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
            layer.confirm('是否要删除歌曲 ' + names + ' ？',function(){
                $.ajax({
                    type: 'post',
                    url: 'delsong',
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
            title: '添加歌曲',
            type: 2,
            content: 'song_add',
            area: ['450px','500px'],
            maxmin: true
        })
    })
})