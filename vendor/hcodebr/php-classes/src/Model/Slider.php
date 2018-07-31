<?php 

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;

class Slider{

	public static function listAll()
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_sliders ORDER BY desslider DESC");

	}

	public static function checkList($list)
	{

		foreach ($list as &$row) {
			
			$p = new Slider();
			$p->setData($row);
			$row = $p->getValues();

		}

		return $list;

	}

	public function saveImg()
	{

		$sql = new Sql();

		$msg = false;

		if (isset($_FILES['file'])) {

			$extensao = strtolower(substr($_FILES['file']['name'], -4)); //pega a extensão do arquivo
			$novo_nome = md5(time()) . $extensao; //define o nome do arquivo pela hora criptografada
			$diretorio = "/res/site/img/sliders/"; //pasta onde ficará as imagens

			move_uploaded_file($_FILES['file']['tmp_name'], $diretorio . $novo_nome); //faz o upload

			$sql_code = "INSERT INTO db_ecommerce (idslider, desslider, desdate) VALUES (null, '$novo_nome', NOW())";

			if($mysqli -> query($sql_code))
				$msg = "Arquivo enviado com sucesso!";
			else
				$msg = "Falha ao enviar o arquivo.";

		}



	}

	public function get($idslider)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_sliders WHERE idslider = :idslider", [
			':idslider'=>$idslider
		]);

		$this->setData($results[0]);

	}

	public function delete()
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_sliders WHERE idslider = :idslider", [
			':idslider'=>$this->getidslider()
		]);

	}

	public function checkPhoto()
	{

		if (file_exists( //verifica se uma imagem foi enviada
			$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"res" . DIRECTORY_SEPARATOR . 
			"site" . DIRECTORY_SEPARATOR . 
			"img" . DIRECTORY_SEPARATOR . 
			"sliders" . DIRECTORY_SEPARATOR . 
			$this->getidslider() . ".png"
			)) {

			$url = "/res/site/img/sliders/" . $this->getidslider() . ".png";

		} else {

			$url = "/res/site/img/image-default.png";

		}

		return $this->setdesphoto($url);

	}

	public function getValues()
	{

		$this->checkPhoto();

		$values = parent::getValues();

		return $values;

	}

	public function setPhoto($file)
	{

		$extension = explode('.', $file['name']); //procurar por um ponto
		$extension = end($extension); //pega a última palavra que é a extensão

		switch ($extension) { //coloca a imagem na pasta temporária

			case "jpg":
			case "jpeg":
			$image = imagecreatefromjpeg($file["tmp_name"]);
			break;

			case "gif":
			$image = imagecreatefromgif($file["tmp_name"]);
			break;

			case "png":
			$image = imagecreatefrompng($file["tmp_name"]);
			break;

		}

		$dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"res" . DIRECTORY_SEPARATOR . 
			"site" . DIRECTORY_SEPARATOR . 
			"img" . DIRECTORY_SEPARATOR . 
			"sliders" . DIRECTORY_SEPARATOR . 
			$this->getidslider() . ".png";

		imagesavealpha($image, true);

		imagepng($image, $dist); //pega a imagem e coloca no destino

		imagedestroy($image);

		$this->checkPhoto(); //vai para a memória do desphoto

	}

	public function getFromURL($desurl)
	{

		$sql = new Sql();

		$rows = $sql->select("SELECT * FROM tb_sliders WHERE desurl = :desurl LIMIT 1", [
			':desurl'=>$desurl
		]);

		$this->setData($rows[0]);

	}

}

 ?>