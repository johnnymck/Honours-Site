<?php

namespace Forms;

use Symfony\Component\Form\Forms;

class FormType
{
    protected $form;

    public function __construct()
    {
        $this->form = Forms::createFormFactoryBuilder()
            ->getFormFactory();
    }
}
