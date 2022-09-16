<?php

namespace Sparkinzy\Dcat\Kindeditor;

use Dcat\Admin\Form\Field;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Support\JavaScript;

/**
 * 字段扩展
 * Class KindEditor
 * @package App\Admin\Extensions\Form
 */
class KindEditor extends Field
{
    protected $view = 'sparkinzy.dcat-kindeditor::kindeditor';

    protected $options  = [
        'width'           => '100%',
        'height'          => '100px',
        'uploadJson'      => '',
        'fileSizeLimit'   => '10MB',
        'fileUploadLimit' => '10',
        'readonly'        => false,
        'items' => [
            'source',
            '|','formatblock', 'fontsize', '|', 'justifyleft', 'justifycenter', 'justifyright',
            'justifyfull', 'insertorderedlist', 'insertunorderedlist',
            'forecolor', 'hilitecolor', 'bold',
            'italic', 'underline', 'lineheight',
            'table',  'insertimages',
            'preview',
            'fullscreen',
        ]
    ];
    protected $disk;

    protected $imageUploadDirectory = 'images';

    public function __construct($column, $arguments = [])
    {
        parent::__construct($column, $arguments);

        /**
         * 应对外部上传接口，返回数据格式化
         */
//        $this->options['afterUploaded'] = JavaScript::make(
//            <<<JS
//function(data)
//{
//    var result = {};
//    if (data.code === 0){
//        result.error = 0;
//        result.url = data.data.url;
//    }else{
//        result.error = data.code;
//        result.message = data.msg;
//    }
//    return result;
//}
//JS
//        );
    }

    /**
     * 设置文件上传存储配置.
     *
     * @param string $disk
     *
     * @return $this
     */
    public function disk(string $disk)
    {
        $this->disk = $disk;

        return $this;
    }
    /**
     * 设置图片上传文件夹.
     *
     * @param string $dir
     *
     * @return $this
     */
    public function imageDirectory(string $dir)
    {
        $this->imageUploadDirectory = $dir;

        return $this;
    }


    /**
     * @return string
     */
    protected function defaultImageUploadUrl()
    {
        return $this->formatUrl(admin_route(('sparkinzy.kindeditor.upload')));
    }
    /**
     * @param string $url
     *
     * @return string
     */
    protected function formatUrl(string $url)
    {
        return Helper::urlWithQuery(
            $url,
            [
                '_token' => csrf_token(),
                'disk'   => $this->disk,
                'dir'    => $this->imageUploadDirectory,
            ]
        );
    }


    public function options($options = [])
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }
    /**
     * 获取所有工具栏目
     * @return mixed
     */
    public function getToolbars()
    {
        return $this->options['items'];
    }

    /**
     * 追加工具栏，也可在指定栏目后面追加栏目
     * @param $item_name
     * @param $after_item_name
     *
     * @return $this
     */
    public function appendToolbar($item_names,$after_item_name='')
    {
        if (empty($item_names)){
            return $this;
        }
        if (!is_array($item_names)){
            $item_names = [$item_names];
        }
        $items = $this->getToolbars();
        if (!empty($after_item_name)){
            $index = array_search($after_item_name,$items);
            if ($index !== false){
                foreach ($item_names as $item_name){
                    array_splice($items, $index+1,0,$item_name);
                }
            }else{
                // 没找到对应元素，直接追加到最后
                $items = array_merge($items, $item_names);
            }
        }else{
            $items = array_merge($items, $item_names);
        }
        $this->toolbar($items);
        return $this;
    }

    /**
     * 移除指定工具栏项目
     *
     * @param $item_name
     *
     * @return $this
     */
    public function removeToolbar($item_names)
    {
        if (empty($item_names)){
            return $this;
        }
        if (!is_array($item_names)){
            $item_names = [$item_names];
        }
        $items = $this->getToolbars();
        foreach ($item_names as $item_name){
            $index = array_search($item_name,$items);
            if ($index !== false){
                array_splice($items, $index,1);
            }
        }
        $this->toolbar($items);
        return $this;
    }

    public function url(string $url)
    {
        $this->options['uploadJson'] =  $this->formatUrl(admin_url($url));
        return $this;
    }

    /**
     * @param array $toolbars
     * @return $this
     */
    public function toolbar(array $toolbars)
    {
        $this->options['items'] = $toolbars;
        return $this;
    }

    public function afterUploaded(JavaScript $js)
    {
        $this->options['afterUploaded'] = $js;
        return $this;
    }


    /**
     * @return array
     */
    protected function formatOptions()
    {
        $this->options['readonly'] = ! empty($this->attributes['readonly']) || ! empty($this->attributes['disabled']);

        if (empty($this->options['uploadJson'])) {
            $this->options['uploadJson'] = $this->defaultImageUploadUrl();
        }

        return $this->options;
    }

    public function render()
    {
        $this->addVariables([
            // 过滤空数据，有些变量是需要设置为false，所以这里信任传入数据，不再过滤
//            'options' => JavaScript::format(array_filter($this->formatOptions()))
            'options' => JavaScript::format($this->formatOptions())
        ]);
        return parent::render();
    }

}
