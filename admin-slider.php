<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Slider;

$app->get("/admin/slider/", function(){

	User::verifyLogin();  //verificar se está logado

	$slider = Slider::listAll();  //listar slider

	$page = new PageAdmin();  //construir página

	$page->setTpl("slider", [
		"slider" => $slider
	]);


});

$app->get("/admin/slider/create", function(){

	User::verifyLogin();  //verificar se está logado

	$slider = new Slider();

	$slider->saveImg();
	
	$page = new PageAdmin();  //construir página

	$page->setTpl("slider-create"); //pega a página slider-create.html

});

$app->post("/admin/slider/create", function(){
 
	User::verifyLogin();  //verificar se está logado
 
	$slider = new Slider();  //chama a classe
 
	$slider->saveImg();
 
   $slider->setPhoto($_FILES["file"]);
 
	header("Location: /admin/slider");
	exit;
 
});

$app->get("/admin/slider/:idslider", function($idslider){

	User::verifyLogin();  //verificar se está logado

	$slider = new Slider();  //chama a classe

	$slider->get((int)$idslider);

	$page = new PageAdmin();

	$page->setTpl("slider-update", [
		'slider'=>$slider->getValues()
	]);

});

$app->post("/admin/sliders/:idslider", function($idslider){

	User::verifyLogin();

	$slider = new Slider();

	$slider->get((int)$idslider);

	$slider->setData($_POST);

	$slider->save();

	if($_FILES["file"]["name"] !== "") $slider->setPhoto($_FILES["file"]);

	header('Location: /admin/sliders');
	exit;

});

$app->get("/admin/sliders/:idslider/delete", function($idslider){

	User::verifyLogin();

	$slider = new Slider();

	$slider->get((int)$idslider);

	$slider->delete();

	header('Location: /admin/sliders');
	exit;

});

 ?>