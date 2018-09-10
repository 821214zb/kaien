@extends('admin.master')

@section('content')
  <div class="pd-20">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
			网站公告：
		</span>
      <span class="r"></span>
    </div>
    <div class="mt-20">

      </table>
    </div>
  </div>
@endsection

@section('my-js')
  <script type="text/javascript">
    function category_add(title, url) {
      var index = layer.open({
        type: 2,
        title: title,
        content: url
      });
      layer.full(index);
    }

    function category_edit(title, url) {
      var index = layer.open({
        type: 2,
        title: title,
        content: url
      });
      layer.full(index);
    }

    function category_del(name, id) {
      layer.confirm('确认要删除【' + name +'】吗？',function(index){
        //此处请求后台程序，下方是成功后的前台处理……
        $.ajax({
          type: 'post', // 提交方式 get/post
          url: '/admin/service/category/del', // 需要提交的 url
          dataType: 'json',
          data: {
            id: id,
            _token: "{{csrf_token()}}"
          },
          success: function(data) {
            if(data == null) {
              layer.msg('服务端错误', {icon:2, time:2000});
              return;
            }
            if(data.status != 0) {
              layer.msg(data.message, {icon:2, time:2000});
              return;
            }

            layer.msg(data.message, {icon:1, time:2000});
            location.replace(location.href);
          },
          error: function(xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
            layer.msg('ajax error', {icon:2, time:2000});
          },
          beforeSend: function(xhr){
            layer.load(0, {shade: false});
          }
        });
      });
    }
  </script>
@endsection
