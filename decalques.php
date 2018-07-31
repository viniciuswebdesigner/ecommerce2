<?php 

use \Hcode\Page;
use \Hcode\Model\Product;

$app->get("/decalques/", function(){

	$products = Product::listAll();

	$page = new Page();

	$page->setTpl("decalques", [
		'products'=>Product::checkList($products)
	]);

});

 ?>