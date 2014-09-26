<?php 
class SummernoteHelper extends AppHelper {
	public $view;
	public $helpers = array('Html', 'Form');
	/**
	 * asset for load plugin
	 */
	public $asset = array(
		'css' => array(
			'Summernote.summernote-bootstrap',
			'Summernote.summernote',
			'Summernote.font-awesome.min'
		),
		'js' => array(
			'Summernote.summernote'
		)
	);
	/**
	 * Default options for editor
	 */
	public $defaultOptions = array(
		'toolbar' => array(
			array('insert', array('picture', 'link')),
			array('table', array('table')),
			array('style', array('style')),
			array('fontsize', array('fontsize')),
			array('color', array('color')),
			array('style', array('bold', 'italic', 'underline', 'clear')),
			array('para', array('ul', 'ol', 'paragraph')),
			array('height', array('height')),
			//array('help', array('help')),
		),
		'height' => 300,
		'onblur' => '%s'
	);

	public $onblur = "function(e){\$('#id').val(\$(this).code()[0]);}"; 

	public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
    }

    /**
     * Add asset with Html Helper
     * @return none
     */
    public function initAsset() {
    	$this->Html->css($this->asset['css'],array('inline' => false));
		$this->Html->script($this->asset['js'],array('inline' => false));
    }

    /**
     * generate Summernet Text Editor
     * @param  string $text    default text
     * @param  array  $options summernet options
     * @return string          summernote output
     */
	public function input($name, $options = array()) {
		$this->initAsset();
		$id = 'summernote' . strtotime('now');
		$textAreaOptions = array('type' => 'textarea', 'id' => $id);
		if (!empty($options['label'])) {
			$textAreaOptions = array_merge($textAreaOptions, array('label' => $options['label']));
		}
		$output = $this->Form->input($name, $textAreaOptions);
		$options = array_merge($this->defaultOptions, $options);
		$options = str_replace('"%s"', '%s', json_encode($options));
		$this->onblur = str_replace('#id', '#'.$id, $this->onblur);
		$options = sprintf($options, $this->onblur);
		$script = "$(function(){
						$('#%s').summernote(%s);
					});";
		$script = sprintf($script, $id, $options);
		$this->Html->scriptBlock($script, array('safe' => false, 'block' => 'script'));
		return $this->output($output);
	}
}
?>