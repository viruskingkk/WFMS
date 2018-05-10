<?php


class View {
	private $master_content;
	private $nav_content;
	private $sidebar_content;
	private $scripts;
	private $title;
	private $part;
	private $non_base;

	public function __construct($master,$nav,$sidebar,$title,$part,$non_base = false){
		$this->load($master,$nav,$sidebar);
		$this->title = $title;
		$this->part = $part;
		$this->non_base = $non_base;
		ob_start();
	}

	private function load($master,$nav,$sidebar){
		ob_start();
		include($master);
		$this->master_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		include($nav);
		$this->nav_content = ob_get_contents();
		ob_end_clean();
		
		if($sidebar!=''){
			ob_start();
			include($sidebar);
			$this->sidebar_content = ob_get_contents();
			ob_end_clean();
		}
	}
	
	public function addMeta($name,$meta_content){
		$this->scripts .= sprintf('<meta name="%s" content="%s" />'.PHP_EOL,$name,$meta_content);
	}

	public function addScript($url,$type="text/javascript"){
		$this->scripts .= sprintf('<script type="%s" src="%s"></script>'.PHP_EOL,$type,$url);
	}

	public function addCSS($url,$type="text/css"){
		$this->scripts .= sprintf('<link type="%s" rel="stylesheet" href="%s" />'.PHP_EOL,$type,$url);
	}
	
	public function render(){
		$content = ob_get_contents();
		ob_end_clean();
		
		echo strtr($this->master_content,array(
			'{title}' => $this->title,
			'{part}' => $this->part,
			'{style}' => $this->non_base ? '../style.css' : './style.css',
			'{scripts}' => $this->scripts,
			'{nav}' => $this->nav_content,
			'{sidebar}' => $this->sidebar_content,
			'{content}' => $content
		));
		@ob_flush();
		flush();
	}
};