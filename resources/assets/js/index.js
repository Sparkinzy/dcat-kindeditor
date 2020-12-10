(function (w, $) {
    function ExtensionKindeditor(options) {
        this.options = $.extend({
            width:'100%',
            uploadJson:'http://127.0.0.1:8000/php/upload_json.php?dir=image',
            fileSizeLimit:"10MB",// 前端文件大小限制
            fileUploadLimit:'30',// 前端一次上传的文件数量限制
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
            }
        }, options);
        console.log(this.options);
        this.init(this.options);
    }

    ExtensionKindeditor.prototype = {
        init: function (options) {
            var editor;

            KindEditor.ready(function(K) {
                editor = K.create('textarea[data-toggle="kindeditor"]', options);
            });


        },
    };

    $.fn.extensionKindeditor = function (options) {
        options = options || {};
        return new ExtensionKindeditor(options);
    };
})(window, jQuery);
