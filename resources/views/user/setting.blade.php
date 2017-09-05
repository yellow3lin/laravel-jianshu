@extends("layout.main")
@section("content")
 <div class="col-sm-8 blog-main">
            <form class="form-horizontal" action="/user/{{\Auth::id()}}/setting" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-3 control-label">用户名</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="name" type="text" value="{{$me->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">头像</label>
                    <div class="col-sm-2">
                        <input class="file-loading preview_input" type="file" value="" style="width:90px" name="avatar" multiple >
                        <img  class="preview_img" src="{{$me->avatar}}" alt="" class="img-rounded" style="border-radius:500px;">
                    </div>
                </div>
                @include('layout.error')
                <button type="submit" class="btn btn-default" style="margin: 4% 15%">修改</button>
            </form>
            <br>
    </div>
@endsection
