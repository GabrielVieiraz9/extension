<?php

$content = file_get_contents('H:/Desktop_G/Importante/ExerciciosGitHub/Chuva/exercicios-2023/php/assets/origin.html');

$dom = new DOMDocument();
$dom->loadHTML($content);

$primario = array();
$secundario = array();
$main = array();

foreach ($dom->getElementsByTagName('a') as $a) {
    if ($a->getAttribute('class') === 'paper-card p-lg bd-gradient-left') {
        $columns1 = array(); // Inicialize o array para autores e instituições
        $data = array(); // Inicialize o array para autores e instituições
        // Buscar os elementos ID, Title e Type dentro do link ($a)


        foreach ($a->getElementsByTagName('span') as $span) {
            
            $id = $a->getElementsByTagName('div')->item(3);
            if (!empty($id)) {
                $data['ID'] = $id->nodeValue;
            }
    
            $title = $a->getElementsByTagName('h4')->item(0);
            if (!empty($title)) {
                $data['Title'] = $title->nodeValue;
            }
    
            $type = $a->getElementsByTagName('div')->item(2);
            if (!empty($type)) {
                $data['Type'] = $type->nodeValue;
            }

            $authorAux = trim($span->nodeValue);
            if (!empty($authorAux)) {
                $columns1['Author'] = $authorAux;
            }

            $institutionAux = $span->getAttribute('title');
            if (!empty($institutionAux)) {
                $columns1['Author Institution'] = $institutionAux;
            }
        }

        if (!empty($columns1)) {
            $primario[] = $data;  //Ordem de [61]
                      
        }
    }
}

foreach ($dom->getElementsByTagName('div') as $div) {


    // Verificar se o elemento div possui a classe "authors"
    if ($div->getAttribute('class') === 'authors') {
        $columns2 = array();
        $type = $div->getElementsByTagName('class') === 'tags mr-sm';

        foreach ($div->getElementsByTagName('span') as $span) {
            $author = trim($span->nodeValue);
            $institution = $span->getAttribute('title');

            if (!empty($author)) {
                $columns2[] = $author;
            }

            if (!empty($institution)) {
                $columns2[] = $institution;
            }
        }

        if (!empty($columns2)) {
            $secundario[] = $columns2;  //Ordem de [61] 
        }
    }
}

if (count($primario) == count($secundario)) {                //Verificar se a array $primario e $secundario possuem mesmo comprimento
    $main = [];

    for ($i = 0; $i < count($primario); $i++) {
        $combinedResult = $primario[$i];
        $combinedResult['Author'] = $secundario[$i];

        $main[] = $combinedResult;
    }

} else {
    echo "Erro: As listas não têm o mesmo comprimento.";
}

print_r($main);

?>