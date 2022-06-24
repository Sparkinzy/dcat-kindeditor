<div class="{{$viewClass['form-group']}}">

    <label class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <textarea data-toggle="kindeditor" name="{{ $name}}" placeholder="{{ $placeholder }}" {!! $attributes !!} >{{ $value }}</textarea>

        @include('admin::form.help-block')

    </div>
</div>
<script require="@sparkinzy.dcat-kindeditor" init="{!! $selector !!}">
    var options = {!! admin_javascript_json($options) !!};
    options = $.extend({
        width:'100%',
        fileSizeLimit:"10MB",// 前端文件大小限制
        fileUploadLimit:'30',// 前端一次上传的文件数量限制\
        afterUploaded:function(data)
        {
            var result = {};
            if (data.code === 0){
                result.error = 0;
                result.url = data.data.url;
            }else{
                result.error = data.code;
                result.message = data.msg;
            }
            return result;
        },
        afterBlur:function(){
            this.sync();
        }
    }, options);
    var is_readonly = $('#'+id).attr('readonly') !== undefined;
    var name = $('#'+id).attr('name');
    if (!window.editors){
        window.editors={};
    }
    window.editors[name] = KindEditor.create('#'+id, options);
    if(is_readonly) {
        window.editors[name].readonly();
    }

</script>
