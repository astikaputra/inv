
<?php
	$this->tree->setFolderImage('asset/images/');
	$this->tree->addToArray(100,'Contents Category',0);
	foreach($menu->result_array() as $rows) {
		$this->tree->addToArray($rows['id_menu'], $rows['menu'],$rows['parent'], base_url().'web/'.$rows['id_menu']);		
	}
	
	$this->tree->writeCSS();
	$this->tree->writeJavascript();
	$this->tree->drawTree();
?>