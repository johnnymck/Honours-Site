<?php
namespace Forms;

class NewUserForm extends FormType
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $this->form
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->getForm()
            ->createView();
    }
}
