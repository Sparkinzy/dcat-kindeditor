<?php

namespace Sparkinzy\Dcat\Kindeditor;

use Dcat\Admin\Extend\Setting as Form;

class Setting extends Form
{
    public function form()
    {
        $this->text('readme')->required();
    }
}
