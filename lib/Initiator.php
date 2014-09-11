<?php
/**
 * Created by PhpStorm.
 * User: vadym
 * Date: 11/09/14
 * Time: 17:46
 */
namespace rvadym\tinymce;
class Initiator extends \AbstractController {
    function init() {
        parent::init();
        if(isset($this->app->rvadym_tinymce) && is_object($this->app->rvadym_tinymce)) {
            // do nothing
        } else {
            $this->app->rvadym_tinymce = $this;
            $this->addLocations();
        }
    }
    protected function addLocations() {

        // private TODO not sure if this is needed for plugins
        /*$this->app->rvadym_tinymce->private = $this->pathfinder->addLocation(array(
            'php'=>array('../../shared/lib'),
        ))->setBasePath($this->pathfinder->base_location->getPath());*/

        // public
        $this->app->rvadym_tinymce->public = $this->pathfinder->addLocation(array(
            'js'=>array('rvadym/tinymce/js'),
        ))
            ->setBasePath($this->pathfinder->base_location->getPath().'/public')
            ->setBaseUrl($this->url('/'))
        ;
    }
}