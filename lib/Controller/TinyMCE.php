<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadym
 * Date: 4/11/13
 * Time: 12:03 PM
 * To change this template use File | Settings | File Templates.
 */
namespace rvadym\x_tinymce;
class Controller_TinyMCE extends \AbstractController {
    function init(){
   		parent::init();
        //if (!($this->owner instanceof \Form)) throw $this->exception('This Controller must be connected to Form only');

        $this->owner->TinyMCE = $this;

//		// add add-on locations to pathfinder
//		$l = $this->api->locate('addons',__NAMESPACE__,'location');
//		$addon_location = $this->api->locate('addons',__NAMESPACE__);
//		$this->api->pathfinder->addLocation($addon_location,array(
//			'js'=>'templates/js',
//			'css'=>'templates/css',
//           'template'=>'templates',
//		))->setParent($l);
		
		// add add-on locations to pathfinder
		$l = $this->api->locate('addons',__NAMESPACE__,'location');
		$addon_location = $this->api->locate('addons',__NAMESPACE__);
		$this->api->pathfinder->addLocation('public',array(
			'js'=>'js/'.str_replace('\\','/',__NAMESPACE__).'/js',
			'css'=>'templates/css/'.str_replace('\\','/',__NAMESPACE__),
            'template'=>'templates',
		))->setParent($l);

        $this->owner->api->jquery->addStaticInclude(
            $this->api->public_location->getURL('js/'.__NAMESPACE__.'/js/tiny_mce/tiny_mce_dev.js')
        );
    }

    /*
     * Configs for Editor
     *
     * TODO: "elements" can be regexp /(mceEditor|mceRichText)/
     */
    private $field = false;
    private $editor_theme = 'simple';
    private $language = 'en';
    private $caption = false;
    private $height = 500;
    private $width = null;
    function addEditorTo(\Form_Field_Text $field, $editor_config=array()) {
        $this->field = $field;
        $this->configureEditor($editor_config);

        $this->owner->js(true,'
            tinyMCE.init({
                    mode : "exact",
                    elements : "'.$this->field->name.'",
                    height : "'.$this->height.'",
                    '.($this->width?
                    'width : "'.$this->width.'",'
                    :'').'
                    theme : "'.$this->editor_theme.'",
                    language : "'.$this->language.'",
                    plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

                    // Theme options
                    theme_advanced_buttons1 : "bold,bullist,numlist, link,unlink, pastetext, spellchecke, code",
                    //theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
                    //theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                    //theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                    //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_toolbar_align : "left",
                    theme_advanced_statusbar_location : "bottom",
                    theme_advanced_resizing : true,
		    extended_valid_elements: "iframe[class|src|frameborder=0|alt|title|width|height|align|name]",


                    setup : function(ed) {
                              ed.onChange.add(function(ed, l) {
                                      console.debug("\n\n Editor contents was modified. Contents: \n\n" + l.content);
                                      $("#'.$this->field->name.'").val(tinyMCE.activeEditor.getContent());
                              });
                    }
            });
        ');
    }
    private function prepareEditor() {
        if ( $this->caption ) $this->field->setCaption('');
    }
    private function configureEditor($conf) {
        foreach ($conf as $k=>$v) {
            switch ($k) {
                case 'theme':
                    $this->editor_theme = $v;
                    break;
                case 'caption':
                    $this->caption = $v;
                    break;
                case 'height':
                    $this->height = $v;
                    break;
                case 'width':
                    $this->width = $v;
                    break;
                case 'language':
                    $this->language = $v;
                    break;
            }
        }
    }
}
