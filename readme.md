x_tinymce
=========

### Composer


    "require": {
        "rvadym/x_tinymce": "dev-master"
    }


### Usage


    $this->add('rvadym/x_tinymce/Controller_TinyMCE');
    $this->TinyMCE->addEditorTo(
        $this->getElement('description'),
        array('theme'=>'simple','height'=>'100'));

