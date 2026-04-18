<?php

function arquivo($tipo){
        if($tipo == "texto"){
            return "dados/questoes_texto.txt";
        }

        return "dados/questoes_multipla.txt";
    }

function criarArquivo($tipo){
    $nome = arquivo($tipo);

    if(!file_exists($nome)){

        $arq = fopen($nome,"w");

        if($tipo == "texto"){
            fwrite($arq,"pergunta;resposta\n");
        }else{
            fwrite($arq,"pergunta;A;B;C;D;gabarito\n");
        }

        fclose($arq);
    }
}

function listar($tipo){
    criarArquivo($tipo);

    $dados = [];

    $arq = fopen(arquivo($tipo),"r");

    fgets($arq);

    while($linha = fgets($arq)){

        if(trim($linha) == "") continue;

        $dados[] = explode(";",trim($linha));
    }

    fclose($arq);

    return $dados;
}

function salvar($tipo,$linha){
    criarArquivo($tipo);

    $arq = fopen(arquivo($tipo),"a");

    fwrite($arq,$linha."\n");

    fclose($arq);
}

function excluir($tipo,$id){
    $linhas = file(arquivo($tipo));

    $novo = $linhas[0];

    for($i=1;$i<count($linhas);$i++){

        if(($i-1) != $id){
            $novo .= $linhas[$i];
        }
    }

    file_put_contents(arquivo($tipo),$novo);
}

function editar($tipo,$id,$novaLinha){
    $linhas = file(arquivo($tipo));

    $novo = $linhas[0];

    for($i=1;$i<count($linhas);$i++){

        if(($i-1) == $id){
            $novo .= $novaLinha."\n";
        }else{
            $novo .= $linhas[$i];
        }
    }

    file_put_contents(arquivo($tipo),$novo);
}
?>