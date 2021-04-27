<div class="{{$viewClass['form-group']}}">

    <label class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <textarea data-toggle="kindeditor" name="{{ $name}}" placeholder="{{ $placeholder }}" {!! $attributes !!} >{!! $value !!}</textarea>

        @include('admin::form.help-block')

    </div>
</div>
<script require="@sparkinzy.dcat-kindeditor" init="{!! $selector !!}">
    Dcat.ready(function () {
        $this.extensionKindeditor({!! $options !!});
    });
</script>
