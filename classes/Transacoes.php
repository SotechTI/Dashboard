<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'Funcoes.php';
require_once 'Conexao.php';

//Classe que terá todos os métodos de transações
class Transacoes{

    //Atributos
    
    private $con;
    private $fun;

    public function __construct() {
        $this->con = new Conexao();
        $this->con->conectar();
        $this->fun = new Funcoes;
    }

    //Busca total de transações do dia anterior de cada rede
    public function totalizarTransacoesRedeIndex($redes) {
        //Contador das Redes
        $banesecard = 0;
        $bin = 0;
        $cielo = 0;
        $userede = 0;
        
        //Select de consulta com as 4 principais redes
        $sql = "SELECT DISTINCT sequencial, rede FROM cadastro_transacoes_tef WHERE (rede LIKE '%" . $redes["Banese"] . "%' OR "
                . "rede LIKE '" . $redes["Bin"] . "%' OR rede LIKE '" . $redes["Cielo"] . "%'"
                . "  OR rede LIKE '" . $redes["Redecard"] . "%' OR rede LIKE '" . $redes["Userede"] . "%') AND transacao_inicio BETWEEN "
                . "CURRENT_DATE() - INTERVAL '1' DAY AND CURRENT_DATE()";
        
        //executa o select
        $resultado = $this->con->conexao->query($sql);
        
        //Pega o resultado do select e grava em um array multidimensional
        $rows = mysqli_fetch_all($resultado);
        
        //Retorna o tamanho do array
        $totalArray =  count($rows);
        
        //Percorre o array e totaliza as transações de cada rede
        for($i = 0; $i < $totalArray; $i++){
            if(($this->fun->like($redes["Banese"], $rows[$i][1])) || ($this->fun->like($redes["Banesecard"], $rows[$i][1]))){
                $banesecard++;
            }else if($this->fun->like($redes["Bin"], $rows[$i][1])){
                $bin++;
            }else if($this->fun->like($redes["Cielo"], $rows[$i][1])){
                $cielo++;
            }else if(($this->fun->like($redes["Redecard"], $rows[$i][1])) || ($this->fun->like($redes["Userede"], $rows[$i][1]))){
                $userede++;
            }
        }
        
        //retorna um array com os valores totais
        return $results = array("Banesecard" => $banesecard, "Bin" => $bin, "Cielo" => $cielo, "Userede" => $userede);
    }
    
    public function totalizarTransacoesRedeDetalhada($rede) {
        
        //Select de consulta com as 4 principais redes
        if($rede == "Userede"){
            $sql = "SELECT DISTINCT sequencial, rede FROM cadastro_transacoes_tef WHERE (rede LIKE '%" . $rede . "%' OR rede LIKE 'Redecard') AND transacao_inicio BETWEEN "
                    . "CURRENT_DATE() - INTERVAL '1' DAY AND CURRENT_DATE()";
        }else{
            $sql = "SELECT DISTINCT sequencial, rede FROM cadastro_transacoes_tef WHERE (rede LIKE '%" . $rede . "%') AND transacao_inicio BETWEEN "
                . "CURRENT_DATE() - INTERVAL '1' DAY AND CURRENT_DATE()";
        }
        //executa o select
        $resultado = $this->con->conexao->query($sql);
        
        return $resultado->num_rows;
        
    }

    //Busca total de transações do dia anterior de redes com mais de um nome
    public function totalizarGraficoMensal($periodos, $redes) {
        $totalBanesecard = array ("Trinta" => 0,"Sessenta" => 0,"Noventa" => 0);
        
        $totalBin = array ("Trinta" => 0,"Sessenta" => 0,"Noventa" => 0);
        
        $totalCielo = array ("Trinta" => 0,"Sessenta" => 0,"Noventa" => 0);
        
        $totalUserede = array ("Trinta" => 0,"Sessenta" => 0,"Noventa" => 0);
        //Traz as transações das 4 principais redes dos ultimos 3 meses
        $sql = "SELECT * FROM cadastro_total_transacoes_rede WHERE (rede = '".$redes["Banesecard"]."' OR rede = '".$redes["Bin"]."' OR rede = '".$redes["Cielo"]."' OR rede = '".$redes["Userede"]."' OR rede = '".$redes["Redecard"]."') AND (periodo = '".$periodos["Trinta"]."' OR periodo = '".$periodos["Sessenta"]."' OR periodo = '".$periodos["Noventa"]."')";
        
        
        //Executa a Query
        $resultado = $this->con->conexao->query($sql);
        
        //Gravaos dados da Query em um Array Multidimensional
        $rows = mysqli_fetch_all($resultado);
        
        //Retorna o tamanho do Array
        $totalArray =  count($rows);
        
        for($i = 0; $i<$totalArray; $i++){
            if($rows[$i][1] == $redes["Banesecard"]){
                switch($rows[$i][2]){
                    case $periodos["Trinta"]:
                        $totalBanesecard["Trinta"] = $rows[$i][3];
                        break;
                    case $periodos["Sessenta"]:
                        $totalBanesecard["Sessenta"] = $rows[$i][3];
                        break;
                    case $periodos["Noventa"]:
                        $totalBanesecard["Noventa"] = $rows[$i][3];
                        break;
                }
            }elseif ($rows[$i][1] == $redes["Bin"]){
                switch($rows[$i][2]){
                    case $periodos["Trinta"]:
                        $totalBin["Trinta"] = $rows[$i][3];
                        break;
                    case $periodos["Sessenta"]:
                        $totalBin["Sessenta"] = $rows[$i][3];
                        break;
                    case $periodos["Noventa"]:
                        $totalBin["Noventa"] = $rows[$i][3];
                        break;
                }
            }elseif ($rows[$i][1] == $redes["Cielo"]){
                switch($rows[$i][2]){
                    case $periodos["Trinta"]:
                        $totalCielo["Trinta"] = $rows[$i][3];
                        break;
                    case $periodos["Sessenta"]:
                        $totalCielo["Sessenta"] = $rows[$i][3];
                        break;
                    case $periodos["Noventa"]:
                        $totalCielo["Noventa"] = $rows[$i][3];
                        break;
                }
            }elseif (($rows[$i][1] == $redes["Userede"]) || ($rows[$i][1] == $redes["Redecard"])){
                switch($rows[$i][2]){
                    case $periodos["Trinta"]:
                        $totalUserede["Trinta"] = $rows[$i][3];
                        break;
                    case $periodos["Sessenta"]:
                        $totalUserede["Sessenta"] = $rows[$i][3];
                        break;
                    case $periodos["Noventa"]:
                        $totalUserede["Noventa"] = $rows[$i][3];
                        break;
                }
            }
        }
        return $total = array ("Banesecard" => $totalBanesecard, "Bin" => $totalBin, "Cielo" => $totalCielo, "Userede" => $totalUserede);
    }

    //Busca Total de transações dos principais Estabelecimentos
    public function totalizarTranEstabelecimento($estabelecimentos) {
        $mahalo = 0;
        $login = 0;
        $WaveBeach =0;
        $tamar = 0;
        $newOtica = 0;
        
        $sql = "SELECT DISTINCT sequencial, estabelecimento FROM cadastro_transacoes_tef WHERE (estabelecimento LIKE '" . $estabelecimentos['1'] . "%' OR estabelecimento LIKE '" . $estabelecimentos['2'] . "%' OR estabelecimento LIKE '" . $estabelecimentos['3'] . "%' OR estabelecimento LIKE '" . $estabelecimentos['4'] . "%' OR estabelecimento LIKE '" . $estabelecimentos['5'] . "%' OR estabelecimento LIKE '" . $estabelecimentos['6'] . "%' OR estabelecimento LIKE '" . $estabelecimentos['7'] . "%') AND transacao_inicio BETWEEN CURRENT_DATE() - INTERVAL '1' DAY AND CURRENT_DATE()";
        
        $resultado = $this->con->conexao->query($sql);
        
        $rows = mysqli_fetch_all($resultado);
        
        $totalArray =  count($rows);
        
        for($i = 0; $i < $totalArray; $i++){
            if($this->fun->like($estabelecimentos[1], $rows[$i][1])){
                $mahalo++;
            }else if($this->fun->like($estabelecimentos[2], $rows[$i][1])){
                $login++;
            }else if($this->fun->like($estabelecimentos[3], $rows[$i][1])){
                $WaveBeach++;
            }else if($this->fun->like($estabelecimentos[4], $rows[$i][1])){
                $tamar++;
            }else if(($this->fun->like($estabelecimentos[5], $rows[$i][1])) || ($this->fun->like($estabelecimentos[6], $rows[$i][1])) || ($this->fun->like($estabelecimentos[7], $rows[$i][1]))){
                $newOtica++;
            }
        }
        
        return $results = array("Mahalo" => $mahalo, "login" => $login, "WaveBeach" => $WaveBeach, "Tamar" => $tamar, "NewOtica" => $newOtica);
    }
    
    //Busca as 10 ultimas transações de todos servidores
    public function totalizarUltimasTrans() {
        $sql = "SELECT estabelecimento, rede, transacao_valor, tipo_cartao, administrador, ds_servidor_tef  FROM cadastro_transacoes_tef WHERE transacao_inicio BETWEEN CURRENT_DATE() - INTERVAL '1' DAY AND CURRENT_DATE() ORDER BY transacao_inicio DESC LIMIT 10";

        return $resultado = $this->con->conexao->query($sql);
    }
    
    public function totalizarTransRedeDetalhada($rede) {
        
        if($rede == "Userede"){
            $sql = "SELECT DISTINCT sequencial, ip_servidor_tef, administrador, tipo_cartao, transacao_pagamento, "
                    . "rede FROM `cadastro_transacoes_tef` WHERE (rede = '$rede' OR rede = 'Redecard') "
                    . "AND transacao_inicio BETWEEN CURRENT_DATE() - INTERVAL '1' DAY AND CURRENT_DATE()";
        }else{
            $sql = "SELECT DISTINCT sequencial, ip_servidor_tef, administrador, tipo_cartao, transacao_pagamento, "
                    . "rede FROM `cadastro_transacoes_tef` WHERE (rede LIKE '%" . $rede. "%') "
                    . "AND transacao_inicio BETWEEN CURRENT_DATE() - INTERVAL '1' DAY AND CURRENT_DATE()";
        }
        //executa o select
        $resultado = $this->con->conexao->query($sql);
        
        //Pega o resultado do select e grava em um array multidimensional
        $rows = mysqli_fetch_all($resultado);
        
        //Retorna o tamanho do array
        $totalArray =  count($rows);
        
        //Retorna o total de transações por servidor da rede selecionada
        $totalTransServer = $this->totalizarTransacoesRedeServ($rows);
        
        $totalTransBandeiras = $this->totalizarTransacoesRedeBandeiras($rows);
       
        //Array com aos detalhes de transação da rede
        $totalTransRede = array("Débito" => 0, "Crédito" => 0, 
            "A Vista" => 0, "Parcelado" => $totalParcelado =0, 
            "Pré-Datado" => 0);
        
        
        //Percorre o array e totaliza as transações de cada rede
        for($i = 0; $i < $totalArray; $i++){
            switch($rows[$i][3]){
                case "Débito": 
                    $totalTransRede["Débito"]++;
                    break;
                case "Crédito": 
                    $totalTransRede["Crédito"]++;
                    break;
            }
            switch ($rows[$i][4]){
                case "A vista":
                    $totalTransRede["A Vista"]++;
                    break;
                case "Parcelado":
                    $totalTransRede["Parcelado"]++;
                    break;
                case "Pré-datado":
                    $totalTransRede["Pré-datado"]++;
                    break;
            }
        }
        return array ($totalTransRede, $totalTransServer, $totalTransBandeiras);
    }
    
    public function totalizarTransacoesRedeServ($array){
        $totalArray =  count($array);
        $servers = array("VSP10" => 0, "VSP12" => 0, "VSP14" => 0, "VSP16" => 0, "VSP18" => 0, "VSP20" => 0, 
            "VSP22" => 0, "VSP24" => 0, "VSP26" => 0, "VSP28" => 0, "VSP30" => 0, "VSP32" => 0, "VSP34" => 0, 
            "VSP36" => 0, "VSP38" => 0, "VSP40" => 0, "VSP42" => 0, "VSP44" => 0, "VSP46" => 0, "VSP48" => 0,
            "VSP50" => 0);
        
        for($i = 0; $i<$totalArray; $i++){
            switch ($array[$i][1]){
                case "172.31.255.10":
                    $servers["VSP10"]++;
                    break;
                case "172.31.255.12":
                    $servers["VSP12"]++;
                    break;
                case "172.31.255.14":
                    $servers["VSP14"]++;
                    break;
                case "172.31.255.16":
                    $servers["VSP16"]++;
                    break;
                case "172.31.255.18":
                    $servers["VSP18"]++;
                    break;
                case "172.31.255.20":
                    $servers["VSP20"]++;
                    break;
                case "172.31.255.22":
                    $servers["VSP22"]++;
                    break;
                case "172.31.255.24":
                    $servers["VSP24"]++;
                    break;
                case "172.31.255.26":
                    $servers["VSP26"]++;
                    break;
                case "172.31.255.28":
                    $servers["VSP28"]++;
                    break;
                case "172.31.255.30":
                    $servers["VSP30"]++;
                    break;
                case "172.31.255.32":
                    $servers["VSP32"]++;
                    break;
                case "172.31.255.34":
                    $servers["VSP34"]++;
                    break;
                case "172.31.255.36":
                    $servers["VSP36"]++;
                    break;
                case "172.31.255.38":
                    $servers["VSP38"]++;
                    break;
                case "172.31.255.40":
                    $servers["VSP40"]++;
                    break;
                case "172.31.255.42":
                    $servers["VSP42"]++;
                    break;
                case "172.31.255.44":
                    $servers["VSP44"]++;
                    break;
                case "172.31.255.46":
                    $servers["VSP46"]++;
                    break;
                case "172.31.255.48":
                    $servers["VSP48"]++;
                    break;
                case "172.31.255.50":
                    $servers["VSP50"]++;
                    break;
                
            }
        }
        return $servers;
    }
    
    public function totalizarTransacoesRedeBandeiras($array){
        $totalArray =  count($array);
        
        $totalBandeiras = array("Amex" => 0, "Banesecard" => 0, "Elo" => 0, "Diners" => 0, "Hipercard" => 0, 
            "Mastercard" => 0, "Visa" => 0);
        for($i = 0; $i < $totalArray; $i++){
            if($this->fun->like($this->fun->getBandeiras()["Amex"], $array[$i][2])){
                $totalBandeiras["Amex"]++;
            }elseif($this->fun->like($this->fun->getBandeiras()["Banese"], $array[$i][2])) {
                $totalBandeiras["Banesecard"]++;
            }elseif($this->fun->like($this->fun->getBandeiras()["Elo"], $array[$i][2])) {
                $totalBandeiras["Elo"]++;
            }elseif($this->fun->like($this->fun->getBandeiras()["Diners"], $array[$i][2])) {
                $totalBandeiras["Diners"]++;
            }elseif($this->fun->like($this->fun->getBandeiras()["Hiper"], $array[$i][2])) {
                $totalBandeiras["Hipercard"]++;
            }elseif($this->fun->like($this->fun->getBandeiras()["Mastercard"], $array[$i][2])) {
                $totalBandeiras["Mastercard"]++;
            }elseif($this->fun->like($this->fun->getBandeiras()["Visa"], $array[$i][2])) {
                $totalBandeiras["Visa"]++;
            }
        } 
        return $totalBandeiras;
        
    }
    
    //Traz o total de transações do dia anterior
    public function totalizarTodasRedes(){
        $sql = "SELECT DISTINCT sequencial FROM cadastro_transacoes_tef WHERE transacao_inicio BETWEEN CURRENT_DATE() - INTERVAL '1' DAY AND CURRENT_DATE()";
        
        $resultado = $this->con->conexao->query($sql);
        
        $rows = $resultado->num_rows;
        
        return $rows;
    }
    
    public function totalizarGraficoServidores($periodos){
        //Traz as transações das 4 principais redes dos ultimos 3 meses
        $sql = "SELECT * FROM cadastro_total_transacoes_server WHERE (periodo = '".$periodos["Trinta"]."' OR periodo = '".$periodos["Sessenta"]."' OR periodo = '".$periodos["Noventa"]."')";
        
        
        //Executa a Query
        $resultado = $this->con->conexao->query($sql);
        
        //Gravaos dados da Query em um Array Multidimensional
        $rows = mysqli_fetch_all($resultado);
        
        return $this->totalizarTranGraficoServers($rows, $periodos);
    }
    
    public function totalizarTranGraficoServers($array, $periodos){
        $totalArray =  count($array);
        $totalServers = array("VSP10:30" => 0, "VSP10:60" => 0, "VSP10:90" => 0, 
            "VSP12:30" => 0, "VSP12:60" => 0, "VSP12:90" => 0, 
            "VSP14:30" => 0, "VSP14:60" => 0, "VSP14:90" => 0, 
            "VSP16:30" => 0, "VSP16:60" => 0, "VSP16:90" => 0, 
            "VSP18:30" => 0, "VSP18:60" => 0, "VSP18:90" => 0, 
            "VSP20:30" => 0, "VSP20:60" => 0, "VSP20:90" => 0, 
            "VSP22:30" => 0, "VSP22:60" => 0, "VSP22:90" => 0, 
            "VSP24:30" => 0, "VSP24:60" => 0, "VSP24:90" => 0, 
            "VSP26:30" => 0, "VSP26:60" => 0, "VSP26:90" => 0,
            "VSP28:30" => 0, "VSP28:60" => 0, "VSP28:90" => 0,
            "VSP30:30" => 0, "VSP30:60" => 0, "VSP30:90" => 0, 
            "VSP32:30" => 0, "VSP32:60" => 0, "VSP32:90" => 0,
            "VSP34:30" => 0, "VSP34:60" => 0, "VSP34:90" => 0, 
            "VSP36:30" => 0, "VSP36:60" => 0, "VSP36:90" => 0, 
            "VSP36:30" => 0, "VSP36:60" => 0, "VSP36:90" => 0, 
            "VSP40:30" => 0, "VSP40:60" => 0, "VSP40:90" => 0, 
            "VSP42:30" => 0, "VSP42:60" => 0, "VSP42:90" => 0, 
            "VSP44:30" => 0, "VSP44:60" => 0, "VSP44:90" => 0, 
            "VSP46:30" => 0, "VSP46:60" => 0, "VSP46:90" => 0, 
            "VSP48:30" => 0, "VSP48:60" => 0, "VSP48:90" => 0, 
            "VSP50:30" => 0, "VSP50:60" => 0, "VSP50:90" => 0);
        
        for($i = 0; $i<$totalArray; $i++){
            if($array[$i][1] == "172.31.255.10"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP10:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP10:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP10:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.12"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP12:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP12:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP12:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.14"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP14:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP14:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP14:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.16"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP16:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP16:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP16:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.18"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP18:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP18:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP18:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.20"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP20:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP20:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP20:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.22"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP22:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP22:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP22:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.24"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP24:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP24:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP24:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.26"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP26:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP26:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP26:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.28"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP28:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP28:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP28:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.30"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP30:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP30:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP30:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.32"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP32:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP32:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP32:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.34"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP34:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP34:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP34:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.36"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP36:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP36:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP36:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.38"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP38:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP38:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP38:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.40"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP40:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP40:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP40:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.42"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP42:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP42:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP42:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.44"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP44:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP44:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP44:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.46"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP46:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP46:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP46:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.48"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP48:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP48:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP48:90"] = $array[$i][4];
                        break;
                }
            }else if($array[$i][1] == "172.31.255.50"){
                switch ($array[$i][3]){
                    case $periodos["Trinta"]:
                        $totalServers["VSP50:30"] = $array[$i][4];
                        break;
                    case $periodos["Sessenta"]:
                        $totalServers["VSP50:60"] = $array[$i][4];
                        break;
                    case $periodos["Noventa"]:
                        $totalServers["VSP50:90"] = $array[$i][4];
                        break;
                }
            }
        }
        return $totalServers;
    }
    
    public function totalizarGraficoAnual($ano){
        $periodo = array("janeiro" => 0, "fevereiro" => 0, "março" => 0, "abril" => 0, "maio" => 0, "junho" => 0, 
            "julho" => 0, "agosto" => 0, "setembro" => 0, "outubro" => 0, "novembro" => 0, "dezembro" => 0);
        //Traz as transações das 4 principais redes dos ultimos 3 meses
        $sql = "SELECT * FROM cadastro_total_transacoes_ano WHERE periodo between '".$ano."-01' and '".$ano."-12'";
       
        //Executa a Query
        $resultado = $this->con->conexao->query($sql);
        
        //Gravaos dados da Query em um Array Multidimensional
        $rows = mysqli_fetch_all($resultado);
        
        //Retorna o tamanho do Array
        $totalArray =  count($rows);
        
        for($i=0; $i<$totalArray; $i++){
            if($rows[$i][1] == "".$ano."-01"){
                $periodo["janeiro"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$ano."-02"){
                $periodo["fevereiro"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$ano."-03"){
                $periodo["março"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$ano."-04"){
                $periodo["abril"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$ano."-05"){
                $periodo["maio"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$ano."-06"){
                $periodo["junho"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$ano."-07"){
                $periodo["julho"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$ano."-08"){
                $periodo["agosto"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$ano."-09"){
                $periodo["setembro"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$ano."-10"){
                $periodo["outubro"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$ano."-11"){
                $periodo["novembro"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$ano."-12"){
                $periodo["dezembro"] = $rows[$i][2];
            }
        }
        return $periodo; 
    }
    public function totalizarClientesServer(){
        $server = "172.31.255.10";
        
        if(date('m') == 01){
            $mes = 12;
            $ano = date('Y') -1;
        }else{
            $ano = date('Y');
            $mes = date('m')-1;
        }
        if($mes < 10){
            $mes = str_pad($mes, 2, '0', STR_PAD_LEFT);
        }
        //Busca o total de clientes em cada servidor do mês passado
        while($server <= "172.31.255.50"){
            
            //Verifica se ja foi feita a totalização de clientes do mês anterior
            $consultarTotalizador = "SELECT DISTINCT * FROM cadastro_total_clientes_server WHERE ip_servidor = '$server' AND periodo = '".$ano."-".$mes."'";


            //Executa a Query
            $resultado = $this->con->conexao->query($consultarTotalizador);
            
            if($resultado->num_rows != 0){
                echo "<br>Server ".$server." no Periodo ".$ano."-0".$mes." Já Totalizado";
            }else{
                $sql = "SELECT DISTINCT estabelecimento, loja, ip_servidor_tef FROM cadastro_transacoes_tef "
                        . "WHERE ip_servidor_tef = '$server' AND transacao_inicio LIKE '".$ano."-".$mes."%'";

                $resultTotalCli = $this->con->conexao->query($sql);

                $total = $resultTotalCli->num_rows;
                
                $sqlInsert = "INSERT INTO cadastro_total_clientes_server (ip_servidor, periodo, total) VALUES ('$server', '".$ano."-".$mes."', '$total')";


                if ($resultInsert = $this->con->conexao->query($sqlInsert) === TRUE) {
                    echo "<br>Server ".$server." no Periodo ".$ano."-".$mes." Totalizado Com Sucesso!";
                } else {
                    echo "Error: " . $sqlInsert . "<br>" . $this->con->conexao->error;
                }
            }
            $server++;
            $server++;
        }
        unset($server);
    }
    
    public function totalizarGraficoClientesServer(){
        if(date('m') == 01){
            $mes = 12;
            $ano = date('Y') -1;
        }else{
            $ano = date('Y');
            $mes = date('m')-1;
        }
        if($mes < 10){
            $mes = str_pad($mes, 2, '0', STR_PAD_LEFT);
        }
        
        $sql = "SELECT * FROM cadastro_total_clientes_server WHERE periodo LIKE '".$ano."-".$mes."%'";
        
        $resultado = $this->con->conexao->query($sql);
        
        $rows = mysqli_fetch_all($resultado);
        
        $total = $this->totalizarResultClientServer($rows);
        
        return $total;
    }
    
    public function totalizarResultClientServer($array){
        $totalArray =  count($array);
        $servers = array("VSP10" => 0, "VSP12" => 0, "VSP14" => 0, "VSP16" => 0, "VSP18" => 0, "VSP20" => 0, 
            "VSP22" => 0, "VSP24" => 0, "VSP26" => 0, "VSP28" => 0, "VSP30" => 0, "VSP32" => 0, "VSP34" => 0, 
            "VSP36" => 0, "VSP38" => 0, "VSP40" => 0, "VSP42" => 0, "VSP44" => 0, "VSP46" => 0, "VSP48" => 0,
            "VSP50" => 0);
        
        for($i = 0; $i<$totalArray; $i++){
            switch ($array[$i][1]){
                case "172.31.255.10":
                    $servers["VSP10"] = $array[$i][3];
                    break;
                case "172.31.255.12":
                    $servers["VSP12"] = $array[$i][3];
                    break;
                case "172.31.255.14":
                    $servers["VSP14"] = $array[$i][3];
                    break;
                case "172.31.255.16":
                    $servers["VSP16"] = $array[$i][3];
                    break;
                case "172.31.255.18":
                    $servers["VSP18"] = $array[$i][3];
                    break;
                case "172.31.255.20":
                    $servers["VSP20"] = $array[$i][3];
                    break;
                case "172.31.255.22":
                    $servers["VSP22"] = $array[$i][3];
                    break;
                case "172.31.255.24":
                    $servers["VSP24"] = $array[$i][3];
                    break;
                case "172.31.255.26":
                    $servers["VSP26"] = $array[$i][3];
                    break;
                case "172.31.255.28":
                    $servers["VSP28"] = $array[$i][3];
                    break;
                case "172.31.255.30":
                    $servers["VSP30"] = $array[$i][3];
                    break;
                case "172.31.255.32":
                    $servers["VSP32"] = $array[$i][3];
                    break;
                case "172.31.255.34":
                    $servers["VSP34"] = $array[$i][3];
                    break;
                case "172.31.255.36":
                    $servers["VSP36"] = $array[$i][3];
                    break;
                case "172.31.255.38":
                    $servers["VSP38"] = $array[$i][3];
                    break;
                case "172.31.255.40":
                    $servers["VSP40"] = $array[$i][3];
                    break;
                case "172.31.255.42":
                    $servers["VSP42"] = $array[$i][3];
                    break;
                case "172.31.255.44":
                    $servers["VSP44"] = $array[$i][3];
                    break;
                case "172.31.255.46":
                    $servers["VSP46"] = $array[$i][3];
                    break;
                case "172.31.255.48":
                    $servers["VSP48"] = $array[$i][3];
                    break;
                case "172.31.255.50":
                    $servers["VSP50"] = $array[$i][3];
                    break;
                
            }
        }
        return $servers;
    }
    
    public function totalizarGraficoValorAnual($rede){
       $mesesAno = array("janeiro" => 0, "fevereiro" => 0, "março" => 0, "abril" => 0, "maio" => 0, "junho" => 0, 
            "julho" => 0, "agosto" => 0, "setembro" => 0, "outubro" => 0, "novembro" => 0, "dezembro" => 0); 
       $adquirentes = array('Bin' => 10, 'Cielo' => 11, 'Redecard' => 19, 'Userede' => 24);
       $anoAtual = date('Y');
       if($rede == "Userede"){
            return $this->totalizarGraficoValorAnualUserede($adquirentes, $anoAtual, $mesesAno);
       }else{
            $sql = "SELECT idAdquirente, periodo, valor FROM `valorTotalRede` WHERE idAdquirente = '".$adquirentes[$rede]."' AND periodo like '$anoAtual%'";
       
        //Executa a Query
        $resultado = $this->con->conexao->query($sql);
        
        $rows = mysqli_fetch_all($resultado);
        
        $totalArray =  count($rows);
        
        for($i=0; $i<$totalArray; $i++){
            if($rows[$i][1] == "".$anoAtual."-01"){
                $mesesAno["janeiro"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$anoAtual."-02"){
                $mesesAno["fevereiro"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$anoAtual."-03"){
                $mesesAno["março"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$anoAtual."-04"){
                $mesesAno["abril"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$anoAtual."-05"){
                $mesesAno["maio"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$anoAtual."-06"){
                $mesesAno["junho"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$anoAtual."-07"){
                $mesesAno["julho"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$anoAtual."-08"){
                $mesesAno["agosto"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$anoAtual."-09"){
                $mesesAno["setembro"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$anoAtual."-10"){
                $mesesAno["outubro"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$anoAtual."-11"){
                $mesesAno["novembro"] = $rows[$i][2];
            }else if($rows[$i][1] == "".$anoAtual."-12"){
                $mesesAno["dezembro"] = $rows[$i][2];
            }
        }
        return $mesesAno;
       }
       
   }
   public function totalizarGraficoValorAnualUserede($adquirentes, $anoAtual, $mesesAno){
       $sqlUserede = "SELECT idAdquirente, periodo, valor FROM `valorTotalRede` WHERE (idAdquirente = '".$adquirentes['Userede']."') AND periodo like '$anoAtual%'";
       $sqlRedecard = "SELECT idAdquirente, periodo, valor FROM `valorTotalRede` WHERE (idAdquirente = '".$adquirentes['Redecard']."') AND periodo like '$anoAtual%'";
       
       $resultUserede = $this->con->conexao->query($sqlUserede);
       $resultRedecard = $this->con->conexao->query($sqlRedecard);
       
       $rowsUserede = mysqli_fetch_all($resultUserede);
       $rowsRedecard = mysqli_fetch_all($resultRedecard);
       
       $totalArrayUserede =  count($rowsUserede);
       $totalArrayRedecard =  count($rowsRedecard);
        
        for($i=0; $i<$totalArrayUserede; $i++){
            if($rowsUserede[$i][1] == "".$anoAtual."-01"){
                $mesesAno["janeiro"] = $rowsUserede[$i][2];
            }else if($rowsUserede[$i][1] == "".$anoAtual."-02"){
                $mesesAno["fevereiro"] = $rowsUserede[$i][2];
            }else if($rowsUserede[$i][1] == "".$anoAtual."-03"){
                $mesesAno["março"] = $rowsUserede[$i][2];
            }else if($rowsUserede[$i][1] == "".$anoAtual."-04"){
                $mesesAno["abril"] = $rowsUserede[$i][2];
            }else if($rowsUserede[$i][1] == "".$anoAtual."-05"){
                $mesesAno["maio"] = $rowsUserede[$i][2];
            }else if($rowsUserede[$i][1] == "".$anoAtual."-06"){
                $mesesAno["junho"] = $rowsUserede[$i][2];
            }else if($rowsUserede[$i][1] == "".$anoAtual."-07"){
                $mesesAno["julho"] = $rowsUserede[$i][2];
            }else if($rowsUserede[$i][1] == "".$anoAtual."-08"){
                $mesesAno["agosto"] = $rowsUserede[$i][2];
            }else if($rowsUserede[$i][1] == "".$anoAtual."-09"){
                $mesesAno["setembro"] = $rowsUserede[$i][2];
            }else if($rowsUserede[$i][1] == "".$anoAtual."-10"){
                $mesesAno["outubro"] = $rowsUserede[$i][2];
            }else if($rowsUserede[$i][1] == "".$anoAtual."-11"){
                $mesesAno["novembro"] = $rowsUserede[$i][2];
            }else if($rowsUserede[$i][1] == "".$anoAtual."-12"){
                $mesesAno["dezembro"] = $rowsUserede[$i][2];
            }
        }
        for($i=0; $i<$totalArrayRedecard; $i++){
            if($rowsRedecard[$i][1] == "".$anoAtual."-01"){
                $mesesAno["janeiro"] = $mesesAno["janeiro"] + $rowsRedecard[$i][2];
            }else if($rowsRedecard[$i][1] == "".$anoAtual."-02"){
                $mesesAno["fevereiro"] = $mesesAno["fevereiro"] + $rowsRedecard[$i][2];
            }else if($rowsRedecard[$i][1] == "".$anoAtual."-03"){
                $mesesAno["março"] = $mesesAno["março"] + $rowsRedecard[$i][2];
            }else if($rowsRedecard[$i][1] == "".$anoAtual."-04"){
                $mesesAno["abril"] = $mesesAno["abril"] + $rowsRedecard[$i][2];
            }else if($rowsRedecard[$i][1] == "".$anoAtual."-05"){
                $mesesAno["maio"] = $mesesAno["maio"] + $rowsRedecard[$i][2];
            }else if($rowsRedecard[$i][1] == "".$anoAtual."-06"){
                $mesesAno["junho"] = $mesesAno["junho"] + $rowsRedecard[$i][2];
            }else if($rowsRedecard[$i][1] == "".$anoAtual."-07"){
                $mesesAno["julho"] = $mesesAno["julho"] + $rowsRedecard[$i][2];
            }else if($rowsRedecard[$i][1] == "".$anoAtual."-08"){
                $mesesAno["agosto"] = $mesesAno["agosto"] + $rowsRedecard[$i][2];
            }else if($rowsRedecard[$i][1] == "".$anoAtual."-09"){
                $mesesAno["setembro"] = $mesesAno["setembro"] + $rowsRedecard[$i][2];
            }else if($rowsRedecard[$i][1] == "".$anoAtual."-10"){
                $mesesAno["outubro"] = $mesesAno["outubro"] + $rowsRedecard[$i][2];
            }else if($rowsRedecard[$i][1] == "".$anoAtual."-11"){
                $mesesAno["novembro"] = $mesesAno["novembro"] + $rowsRedecard[$i][2];
            }else if($rowsRedecard[$i][1] == "".$anoAtual."-12"){
                $mesesAno["dezembro"] = $mesesAno["dezembro"] + $rowsRedecard[$i][2];
            }
        }
        
        return $mesesAno;
   }
   
   public function totalizarGraficoValorBandeira($adquirente, $periodo) {
       $adquirentes = array('Bin' => 10, 'Cielo' => 11, 'Redecard' => 19, 'Userede' => 24);
       $bandeiras = array('Amex' => 0, 'EloCredito' => 0, 'EloDebito' => 0, 'HiperCredito' => 0, 'HiperDebito' => 0, 
            'MasterCredito' => 0, 'MasterDebito' => 0, 'VisaCredito' => 0, 'VisaDebito' => 0);
       if($adquirente == "Userede"){
           return $this->totalizarGraficoValorBandeiraUserede($adquirentes, $adquirente, $bandeiras, $periodo);
       }else{
            $select = "SELECT idAdquirente, idTipoTransacao, idBandeira, periodo, valorTotal FROM `valorTotalBandeirasRede` WHERE idAdquirente = '".$adquirentes[$adquirente]."' AND periodo LIKE '$periodo%'";

            $result = $this->con->conexao->query($select);

            $rows = mysqli_fetch_all($result);

            $totalRows = count($rows);

            for($i = 0; $i < $totalRows; $i++){
                if($rows[$i][1] == 1){
                    switch ($rows[$i][2]){
                        case 1: $bandeiras['Amex'] = $rows[$i][4];
                            break;
                        case 2: $bandeiras['EloCredito'] = $rows[$i][4];
                            break;
                        case 3: $bandeiras['HiperCredito'] = $rows[$i][4];
                            break;
                        case 4: $bandeiras['MasterCredito'] = $rows[$i][4];
                            break;
                        case 5: $bandeiras['VisaCredito'] = $rows[$i][4];
                            break;
                    }
                }else if($rows[$i][1] == 2){
                    switch ($rows[$i][2]){
                        case 1: $bandeiras['Amex'] = $rows[$i][4];
                            break;
                        case 2: $bandeiras['EloDebito'] = $rows[$i][4];
                            break;
                        case 3: $bandeiras['HiperDebito'] = $rows[$i][4];
                            break;
                        case 4: $bandeiras['MasterDebito'] = $rows[$i][4];
                            break;
                        case 5: $bandeiras['VisaDebito'] = $rows[$i][4];
                            break;
                    }
                }
            }
            return $bandeiras;
       }       
   }
   public function totalizarGraficoValorBandeiraUserede($adquirentes,$adquirente, $bandeiras, $periodo){
        $selectUserede = "SELECT idAdquirente, idTipoTransacao, idBandeira, periodo, valorTotal FROM `valorTotalBandeirasRede` WHERE idAdquirente = '".$adquirentes[$adquirente]."' AND periodo LIKE '$periodo%'";
        $selectRedecard = "SELECT idAdquirente, idTipoTransacao, idBandeira, periodo, valorTotal FROM `valorTotalBandeirasRede` WHERE idAdquirente = '".$adquirentes["Redecard"]."' AND periodo LIKE '$periodo%'";

        $resultUserede = $this->con->conexao->query($selectUserede);
        $resultRedecard = $this->con->conexao->query($selectRedecard);

        $rowsUserede = mysqli_fetch_all($resultUserede);
        $rowsRedecard = mysqli_fetch_all($resultRedecard);

        $totalRowsUserede = count($rowsUserede);
        $totalRowsRedecard = count($rowsRedecard);

        for($i = 0; $i < $totalRowsUserede; $i++){
            if($rowsUserede[$i][1] == 1){
                switch ($rowsUserede[$i][2]){
                    case 1: $bandeiras['Amex'] = $rowsUserede[$i][4];
                        break;
                    case 2: $bandeiras['EloCredito'] = $rowsUserede[$i][4];
                        break;
                    case 3: $bandeiras['HiperCredito'] = $rowsUserede[$i][4];
                        break;
                    case 4: $bandeiras['MasterCredito'] = $rowsUserede[$i][4];
                        break;
                    case 5: $bandeiras['VisaCredito'] = $rowsUserede[$i][4];
                        break;
                }
            }else if($rowsUserede[$i][1] == 2){
                switch ($rowsUserede[$i][2]){
                    case 1: $bandeiras['Amex'] = $rowsUserede[$i][4];
                        break;
                    case 2: $bandeiras['EloDebito'] = $rowsUserede[$i][4];
                        break;
                    case 3: $bandeiras['HiperDebito'] = $rowsUserede[$i][4];
                        break;
                    case 4: $bandeiras['MasterDebito'] = $rowsUserede[$i][4];
                        break;
                    case 5: $bandeiras['VisaDebito'] = $rowsUserede[$i][4];
                        break;
                }
            }
        }
        for($i = 0; $i < $totalRowsRedecard; $i++){
            if($rowsRedecard[$i][1] == 1){
                switch ($rowsRedecard[$i][2]){
                    case 1: $bandeiras['Amex'] = $bandeiras['Amex'] + $rowsRedecard[$i][4];
                        break;
                    case 2: $bandeiras['EloCredito'] = $bandeiras['EloCredito'] + $rowsRedecard[$i][4];
                        break;
                    case 3: $bandeiras['HiperCredito'] = $bandeiras['HiperCredito'] + $rowsRedecard[$i][4];
                        break;
                    case 4: $bandeiras['MasterCredito'] = $bandeiras['MasterCredito'] + $rowsRedecard[$i][4];
                        break;
                    case 5: $bandeiras['VisaCredito'] = $bandeiras['VisaCredito'] + $rowsRedecard[$i][4];
                        break;
                }
            }else if($rowsRedecard[$i][1] == 2){
                switch ($rowsRedecard[$i][2]){
                    case 1: $bandeiras['Amex'] = $bandeiras['Amex'] + $rowsRedecard[$i][4];
                        break;
                    case 2: $bandeiras['EloDebito'] = $bandeiras['EloDebito'] + $rowsRedecard[$i][4];
                        break;
                    case 3: $bandeiras['HiperDebito'] = $bandeiras['HiperDebito'] + $rowsRedecard[$i][4];
                        break;
                    case 4: $bandeiras['MasterDebito'] = $bandeiras['MasterDebito'] + $rowsRedecard[$i][4];
                        break;
                    case 5: $bandeiras['VisaDebito'] = $bandeiras['VisaDebito'] + $rowsRedecard[$i][4];
                        break;
                }
            }
        }
        return $bandeiras;
   }
}