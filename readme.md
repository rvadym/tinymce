x_tinymce
=========

### Composer


    "require": {
        "rvadym/x_tinymce": "dev-master"
    }


### Instalation with Composer

        # install addon with composer
        php composer.phar update

        # create required dirs in js dir
        cd public/js
        mkdir rvadym
        cd rvadym
        mkdir x_tinymce
        cd x_tinymce

        # create simlink to addon js files
        ln -s ../../../../vendor/rvadym/x_tinymce/templates/js/


### Usage


    $this->add('rvadym/x_tinymce/Controller_TinyMCE');
    $this->TinyMCE->addEditorTo(
        $this->getElement('description'),
        array('theme'=>'simple','height'=>'100'));

