<div class="{{$viewClass['form-group']}}">

    <label class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <textarea data-toggle="kindeditor" name="{{ $name}}" placeholder="{{ $placeholder }}" {!! $attributes !!} >{!! $value !!}</textarea>

        @include('admin::form.help-block')

    </div>
</div>
<script require="@sparkinzy.dcat-kindeditor" init="{!! $selector !!}">
    var options = {!! admin_javascript_json($options) !!};
    options = $.extend({
        width:'100%',
        fileSizeLimit:"10MB",// 前端文件大小限制
        fileUploadLimit:'30',// 前端一次上传的文件数量限制
        afterBlur:function(){
            this.sync();
        }
    }, options);
    var is_readonly = $('#'+id).attr('readonly') !== undefined;
    var editor = KindEditor.create('#'+id, options);
    if(is_readonly) {
        editor.readonly();
    }

</script>
