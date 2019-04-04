<?php
/**
 * Description of conexao
 *Conexão Com o banco de dados
 * @author Luan
 */
header('Content-Type: text/html; charset=utf-8');
class Conexao {
    //Atributos
    private $servidor;
    private $usuario;
    private $senha;
    private $banco;
    public $conexao;
    
    //construtor
    
    public function __construct() {
        $this->setServidor("172.31.255.200");
        $this->setUsuario("managerdb");
        $this->setSenha("M4n4g3rMySQL");
        $this->setBanco("monitor");      
    }
    
    function conectar(){
        $conexao = new mysqli($this->getServidor(), $this->getUsuario(), $this->getSenha(), $this->getBanco());
        $this->setConexao($conexao);
        // Check connection
        if ($this->getConexao()->connect_error) {
            die("Connection failed: " . $this->getConexao()->connect_error);
            print_r($this->getConexao());
        }
        // Change character set to utf8
        mysqli_set_charset($conexao,"utf8");
   
    }
    
    function desconectar(){
        mysqli_close($this->getConexao());
    }
      
    function getServidor() {
        return $this->servidor;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getSenha() {
        return $this->senha;
    }

    function getBanco() {
        return $this->banco;
    }

    function getConexao() {
        return $this->conexao;
    }

    function setServidor($servidor) {
        $this->servidor = $servidor;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setConexao($conexao) {
        $this->conexao = $conexao;
    }


}
