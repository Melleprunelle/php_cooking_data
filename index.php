<?php

// EXCICE DICO.
// appel du dico.
$string = file_get_contents("dictionnaire.txt", FILE_USE_INCLUDE_PATH);
$dico = explode("\n", $string);


// nombre de mots dans le dico.
echo 'Le dico contient '.count($dico).' mots.<br/>';

// nombre de mots contenant 15 lettres.
$compteur = 0;
for($i = 0; $i < count($dico); $i++) {
    if (strlen($dico[$i]) == 15) {
        $compteur++;
    }
}
echo 'Le dico contient '.$compteur.' mots de 15 lettres.<br/>';

// nombre de mots contenant la lettre "w".
$compteur2 = 0;
for($i = 0; $i < count($dico); $i++) {
    if (preg_match("/w/i", $dico[$i])) {
        $compteur2++;
    }
}
echo 'Le dico contient '.$compteur2.' mots contenant la lettre "w".<br/>';

// nombre de mots se terminant par "q".
$compteur3 = 0;
for($i = 0; $i < count($dico); $i++) {
    $mot = $dico[$i];
    $derniere_lettre = $mot{strlen($mot)-1};
    if ($derniere_lettre == "q") {
        $compteur3++;
    }
}
echo 'Le dico contient '.$compteur3.' mots se terminant par "q".<br/><br/>';


// EXERCICE FILMS
// appel des films
$string = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
$brut = json_decode($string, true);
$top = $brut["feed"]["entry"];

// le top 10 des films.
echo '<ol>';
for($i = 0; $i < 10; $i++) {
        echo '<li>'.$top[$i]['im:name']['label']."</li>"; 
}
echo '</ol>';

//trouver le classement de gravity.
for($i = 0; $i < count($top); $i++) {
        if($top[$i-1]['im:name']['label'] == "Gravity") {
            echo "Gravity se trouve à la place ".$i.".</br>";
        } 
}

//Réalisateur du film lego movie.
for($i = 0; $i < count($top); $i++) {
        if($top[$i]['im:name']['label'] == "The LEGO Movie") {
            echo "Les auteurs de The LEGO Movie sont ".$top[$i]['im:artist']['label'].".</br>";
        } 
}

//Nombre de films sortie avant 2000.
$compteur4 = 0;
for($i = 0; $i < count($top); $i++) {
        if($top[$i]['im:releaseDate']['label'] < "2000") {
            $compteur4++;
        } 
}
echo "Il y a ".$compteur4." films sortie avant les années 2000.</br>";

//film plus vieux et plus recent.
$date_ancien =  $top[0]['im:releaseDate']['label'];
$date_recent =  $top[0]['im:releaseDate']['label'];
for ($i = 1; $i < count($top); $i++) {
        if ($date_ancien > $top[$i]['im:releaseDate']['label']) {
            $date_ancien = $top[$i]['im:releaseDate']['label'];
            $nom_ancien = $top[$i]['im:name']['label'];
        }
    if ($date_recent < $top[$i]['im:releaseDate']['label']) {
            $date_recent = $top[$i]['im:releaseDate']['label'];
            $nom_recent = $top[$i]['im:name']['label'];
        }
} 
echo "Le film le plus ancien est : ".$nom_ancien.' de '.$date_ancien.".<br/>";
echo "Le film le plus recent est : ".$nom_recent.' de '.$date_recent.".<br/>";

//categorie plus représentée film
$tab = [];
for($i = 0; $i < count($top); $i++) {
    $valeur = $top[$i]['category']['attributes']['label'];
    array_push($tab, $valeur);
}
$tab = array_count_values($tab);
$indice_max = array_search(max($tab), $tab);
echo "La catégorie la plus présente est ".$indice_max.'.</br>';

//realisateur present dans le top 100.
$tab2 = [];
for($i = 0; $i < 100; $i++) {
    $valeur2 = $top[$i]['im:artist']['label'];
    array_push($tab2, $valeur2);
}
$tab2 = array_count_values($tab2);
$indice_max2 = array_search(max($tab2), $tab2);
echo "La catégorie la plus présente est ".$indice_max2.'.</br>';

//acheter top 10 et louer top 10
$total = 0;
for($i = 0; $i <= 10; $i++) {
        $total = $total + $top[$i]['im:price']['attributes']['amount'];
        
}
$total2 = 0;
for($i = 0; $i <= 10; $i++) {
        $total2 = $total2 + $top[$i]['im:rentalPrice']['attributes']['amount'];
        
}
echo "Le prix du top 10 est de ".$total."$.</br>";
echo "Le location du top 10 est de ".$total2."$.</br>";

//le mois ayant plus de vues
$tab3 = [];
for($i = 0; $i < 100; $i++) {
    $valeur2 = $top[$i]['im:releaseDate']['attributes']["label"];
    array_push($tab3, $valeur2);
}
$tab3 = array_count_values($tab3);
$indice_max3 = array_search(max($tab3), $tab3);
$indice_max3 = stristr($indice_max3, ' ', true);
echo "Il y a eu le plus de sortie durant ".$indice_max3.'.</br>';

//les dix meilleurs films à voir avec budget limité
$tab4 = [];
foreach ( $top as $index => $films ) {
    if ( ! empty(return_label('im:rentalPrice', $index, $top)) ) {
    $price = explode( '$', return_label('im:rentalPrice', $index, $top) )[1];
    $title = return_label('im:name', $index, $top);
    $tab4[$title] = $price;
    }
}
asort($tab4);
echo "<ol>";
for ($index = 0; $index < 10; $index++) {
    echo '<li>'.key($tab4).'</li>'."\n";
    array_shift($tab4);
}
echo "</ol>";

echo "<pre>";
print_r($top);
echo "<pre/>";

?>


