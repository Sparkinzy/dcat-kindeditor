# Dcat Admin Extension

扩展表单字段: **kindeditor**

## kindeditor 

此版本kindeditor为个人分支，其中上传组件已删除flash，改为plupload.js
作为核心上传组件，并进行一定程度的精简

## 默认使用

```
$form->kindeditor('description');
# 重置展示项
$form->kindeditor('description')
    ->options([
    'items'=>[
    'source','insertimages','fontsize'
]
]);
```

## 上传回调

允许上传文件后对回调数据格式化，适配现有第三方上传结构返回的数据结构。

自定义图片上传回调
```php
       $afterUploadedCallback=JavaScript::make(
            <<<JS
function(data)
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
JS
        );
        $custom_upload_url = 'http://upload.baidu.com/';
        $form->kindeditor('editor')->options(['afterUploaded'=>$afterUploadedCallback])->url($custom_upload_url);'


```

## 只读模式

```php

$form->kindeditor('desc')->url($custom_upload_url)->readonly();
```

## 新增全局js变量window.editors 对象

可通过表单name值获取对应的kindeditor实例,实现跨作用域调用编辑器的方法
例如:
```html
<textarea name="content" >
```

```js
var editor = window.editors.content;
```

## 当前工具栏目默认项目如下：
```js
{
items : [
    'source',
    '|','formatblock', 'fontsize', '|', 'justifyleft', 'justifycenter', 'justifyright',
    'justifyfull', 'insertorderedlist', 'insertunorderedlist',
    'forecolor', 'hilitecolor', 'bold',
    'italic', 'underline', 'lineheight',
    'table',  'insertimages',
    'preview',
    'fullscreen',
]
}
```

> 可用栏目如下：
 

| item_name           | 项目|
|---------------------| ----  |
| source	             |HTML代码 |
| preview             |	预览 |
| undo                |	后退 |
| redo                |	前进 |
| cut                 |	剪切 |
| copy                |	复制 |
| paste               |	粘贴 |
| plainpaste	         |粘贴为无格式文本 |
| wordpaste           |	从Word粘贴 |
| selectall           |	全选 |
| justifyleft         |	左对齐 |
| justifycenter       |	居中 |
| justifyright        |	右对齐 |
| justifyfull         |	两端对齐 |
| insertorderedlist   |	编号 |
| insertunorderedlist |	项目符号 |
| indent              |	增加缩进 |
| outdent             |	减少缩进 |
| subscript           |	下标 |
| superscript         |	上标 |
| formatblock         |	段落 |
| fontname            |	字体 |
| fontsize            |	文字大小 |
| forecolor           |	文字颜色 |
| hilitecolor         |	文字背景 |
| bold                |	粗体 |
| italic              |	斜体 |
| underline           |	下划线 |
| strikethrough       |	删除线 |
| removeformat        |	删除格式 |
| insertimages        |	图片 |
| flash               |	Flash |
| media               |	视音频 |
| table               |	表格 |
| hr                  |	插入横线 |
| emoticons           |	插入表情 |
| link                |	超级链接 |
| unlink              |	取消超级链接 |
| fullscreen          |	全屏显示 |
| about               |	关于 |
| print               |	打印 |
| code                |	插入程序代码 |
| map                 |	Google地图 |
| baidumap            |	百度地图 |
| lineheight          |	行距 |
| clearhtml           |	清理HTML代码 |
| pagebreak           |	插入分页符 |
| quickformat         |	一键排版 |
| insertfile          |	插入文件 |
| template            |	插入模板 |
| anchor              |	插入锚点 |

## 工具栏项目新增与删除

```php
$form->kindeditor('content')
// 在源代码后面新增一个 从Word粘贴
->appendToolbar('wordpaste','source')
// 在最后新增一个 插入百度地图
->appendToolbar('baidumap')
// 移除图片
->removeToolbar('insertimages');
```



