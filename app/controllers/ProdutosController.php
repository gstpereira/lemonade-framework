<?php

class ProdutosController extends \Lemonade\Controller{

	protected $components = array("cache","mail", "auth");

	public function index(){
		// $redirector = new RedirectorHelper();
		// $redirector->redirect(array("action" => "novos"));
		// echo $this->route->getAction();
		$this->view("produtosIndex",array("name" => "Gustavo"));
	}

	public function novos(){
		// $b = Produtos::find(array("fields"=> array("id","nome"),"where" => "ativo=1", "limit" => "2", "offset" => "3"));
		// Produtos::explain();
		// pr($this->paginator->set("Produtos", 2)->get());
		// pr($this->paginator->get());
		// pr($_SERVER);
		// $this->validator->set("email", "gustavo")->isString();
		// $this->validator->validate();
		// pr($this->validator->getErrors());
		// $this->response->goToUrl("http://www.google.com");
		// if($this->request->isPost()){
		// 	$caminho = $this->appDir() . "uploads";
		// 	$this->upload->set($this->request->getFile("arquivo"), $caminho);
		// 	if($this->upload->upload()){
		// 		echo "FOI";
		// 	}else{
		// 		pr($this->upload->getError());
		// 	}
		// }
		// echo $this->appDir . "uploads";
		// 
		// $texto = $this->cache->get("nome");
		// if(is_null($texto)){
		// 	$texto = "Gustavo " . date("H:i:s");
		// 	$this->cache->set("nome", $texto, 10);
		// }
		// $this->mail->setAddress(array("Gustavo" => "guustavo0.henrique@gmail.com"));
		// $this->mail->send("teste", "Teste");
		// $form = new FormProdutos();
		// if($this->request->isPost()){
		// 	$a = new FormProdutos($this->request->getPost());
		// 	if(!$a->isValid()){
		// 		foreach ($a->getErrors() as $errors) {
		// 			foreach ($errors as $value) {
		// 				echo $value . "<br />";
		// 			}
		// 		}
		// 	}
		// }
		// pr($this->auth->getUser());
		$texto = Produtos::all();
		$this->view("produtosNovos", array("name" => $texto));
	}

	public function logout(){
		$this->auth->logout();
	}

	public function pesquisa(){
		$retorno = Produtos::findById(array("fields" => array("nome"), "id" => $this->request->getPost("name")));
		$this->ajax($retorno);
	}

	public function retorna(){
		return 1;
	}

}

	