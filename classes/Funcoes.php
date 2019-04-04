<?php

//Funções e Variáveis Estáticas
class Funcoes {
    
    //Redes
    private $principaisRedes = array("Banese" => "Banese", "Banesecard" => "Banesecard", "Bin" => "Bin", 
        "Cielo" => "Cielo", "Redecard" => "Redecard", "Userede" => "Userede");
    //Principais Estabelecimentos
    private $estabelecimentos = array(1 => "Mahalo", 2 => "Login", 3 => "WaveBeach", 4 => "ProTamar", 5 => "NewOtica", 
                                    6 => "OFL", 7 => "MFA");
    //Tipo de cartão
    private $tipoCartao = array("Debito" => "Débito", "Credito" => "Crédito");
    //Tipo transação
    private $tipoTransacao = array("AVista" => "A vista", "Parcelado" => "Parcelado", "PreDatado" => "Pré-datado");
    //Bandeiras
    private $bandeiras = array("AleloBeneficios" => "Alelo Beneficios", "AlimentacaoPass" => "Alimentacao Pass", 
        "Amex" => "Amex", "Banese" => "Banese", "Banesecard" => "Banesecard", "Banricompras" => "Banricompras", 
        "Cabal" => "Cabal", "Calcard" => "Calcard", "Credishop" => "Credishop", "Credsystem" => "Credsystem", 
        "Credz" => "Credz", "Diners" => "Diners", "Dacasacard" => "Dacasacard", "Discover" => "Discover", "Elo" => "Elo",
        "FlexCar" => "Flex Car", "Fortbrasil" => "Fortbrasil", "Goodcard" => "Goodcard", "Greencard" => "Greencard", 
        "Hiper" => "Hiper", "Hipercard" => "Hipercard", "Jcb" => "Jcb", "Mais" => "Mais", "Mastercard" => "Mastercard", 
        "Nutricash" => "Nutricash", "Personalcard" => "Personalcard",  "Planvale" => "Planvale", "Policard" => "Policard",
        "RedeCompras" => "Rede Compras", "Sodexo" => "Sodexo", "Sorocred" => "Sorocred", "Ticket" => "Ticket", 
        "Triocard" => "Triocard", "Up" => "Up", "Uzecard" => "Uzecard", "Valecard" => "Valecard", 
        "VendaCrediario" => "Venda Crediario", "Verdecard" => "Verdecard", "Verocard" => "Verocard", 
        "Verocheque" => "Verocheque", "Visa" => "Visa", "Vr" => "Vr");

    
    //Funções e Métodos
    //Verifica se existe uma palavra dentro da String
    public function like($needle, $haystack){
        $regex = '/' . str_replace('%', '.*?', $needle) . '/';

         if(preg_match($regex, $haystack) > 0){
             return 1;
         }else{
             return 0;
         }
    }
    
    //Retorna dia Anterior da Data Atual
    
    public function dataAnterior(){
        $dia = date('d') - 1;
        $mes = date('m');
        $ano = date('Y');
        return $data = mktime(0, 0, 0, $mes, $dia, $ano);
    }
    
    public function retornarPeriodos(){
        $mes = date('m');
        
        if($mes == 01){
            $mes = 12;
            $ano = date('Y') - 1;
            $trinta = $mes;
            $sessenta = $mes - 1;
            $noventa =  $mes - 2;
        }else{
            $trinta =   $mes - 1;
            $sessenta = $mes - 2;
            $noventa =  $mes - 3;
            $ano = date('Y');
        }
        if($trinta < 10){
            $trinta = str_pad($trinta, 2, '0', STR_PAD_LEFT);
        }
        if($sessenta < 10){
            $sessenta = str_pad($sessenta, 2, '0', STR_PAD_LEFT);
        }
        if($noventa < 10){
            $noventa = str_pad($noventa, 2, '0', STR_PAD_LEFT);
        }
        
        return $periodos = array("Trinta" => "$ano-".$trinta, "Sessenta" => "$ano-".$sessenta, "Noventa" => "$ano-".$noventa);
    }
            
    function getPrincipaisRedes() {
        return $this->principaisRedes;
    }

    function getEstabelecimentos() {
        return $this->estabelecimentos;
    }

    function setPrincipaisRedes($principaisRedes) {
        $this->principaisRedes = $principaisRedes;
    }

    function setEstabelecimentos($estabelecimentos) {
        $this->estabelecimentos = $estabelecimentos;
    }
    function getTipoCartao() {
        return $this->tipoCartao;
    }

    function getTipoTransacao() {
        return $this->tipoTransacao;
    }

    function getBandeiras() {
        return $this->bandeiras;
    }

    function setTipoCartao($tipoCartao) {
        $this->tipoCartao = $tipoCartao;
    }

    function setTipoTransacao($tipoTransacao) {
        $this->tipoTransacao = $tipoTransacao;
    }

    function setBandeiras($bandeiras) {
        $this->bandeiras = $bandeiras;
    }



}
