<?php

namespace Sparkinzy\Dcat\Kindeditor;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Form as BaseForm;

class DcatKindeditorServiceProvider extends ServiceProvider
{
	protected $js = [
	    'js/kindeditor-all-min.js?v=1.0.18',
        'js/index.js?v=1.0.18',
    ];
	protected $css = [
		'css/themes/default/default.min.css?v=1.0.18',
	];

	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

        Admin::requireAssets('@sparkinzy.dcat-kindeditor');
        $this->loadViewsFrom(__DIR__.'/../resources/views', '@sparkinzy.dcat-kindeditor');
        BaseForm::extend('kindeditor', KindEditor::class);

	}

//	public function settingForm()
//	{
//		return new Setting($this);
//	}
}
