<?php
include 'config.php';
include 'headers.php';
require "verif_auth.php";

//recup de produit(s)
if ($_SERVER['REQUEST_METHOD'] == 'GET') :
    //1 produit dont on a l'id
    if( isset($_GET['id_produits'])) :
        //requête avec jointure. on renomme les champs ambigus avec 'AS'
        $sql = sprintf("SELECT produits.label, produits.prix, produits.id, categories.label AS label_cat, categories.id AS id_categories FROM produits LEFT JOIN categories ON categories.id = produits.id_categories WHERE produits.id = %d",
            $_GET['id_produits']
        );
        $response['response'] = 'One product with id '.$_GET['id_produits'];
    else :
        //tous les produits
        $sql = "SELECT produits.label, produits.prix, produits.id, categories.label AS label_cat, categories.id AS id_categories FROM produits LEFT JOIN categories ON categories.id = produits.id_categories ORDER BY produits.label ASC";
        $response['response'] = 'All products';
    endif;

    $result = $connect->query($sql);
    echo $connect->error;

    $response['data'] = $result->fetch_all(MYSQLI_ASSOC);
    $response['nb_hits'] = $result->num_rows;
endif; //end GET

//suppression d'un produit
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') :
    //a-t-on l'id ?
    if( isset($_GET['id_produits']) ) :
    $sql = sprintf("DELETE FROM produits WHERE id=%d",
        $_GET['id_produits']
    );
    $connect->query($sql);
    echo $connect->error;
    $response['response'] = "Delete product id {$_GET['id_produits']}";
    //si pas d'id
    else :
        $response['response'] = "Il manque l'id";
        $response['code'] = 500;
    endif;
    //exit;
endif;

//add produit
if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    //extraction de l'objet json du paquet HTTP
    $json = file_get_contents('php://input');
    //décodage du format json, ça génère un object PHP
    $objectPOST = json_decode($json);
    //test si la cat correspondant à id_categories existe dans DB
    $sql = sprintf("SELECT * FROM categories WHERE id = %d", $objectPOST->id_categories);
    $result = $connect->query($sql);
    echo $connect->error;
    //echo $result->num_rows;
    //exit;
    // si la catégorie existe, on ajoute le produit
    if($result->num_rows > 0):
        $sql = sprintf("INSERT INTO produits SET label='%s', prix='%s, id_categories=%s'",
            strip_tags(addslashes($objectPOST->label)), //lire une propriété d'un objet PHP
            strip_tags($objectPOST->prix),
            isset($arrayPOST['id_categories']) ? strip_tags($arrayPOST['id_categories']) : 'NULL',// si on a l'id_categories, on l'utilise, sinon retourne NULL, d'où l'usage du %s pour l'id_categories dans $sql
        );
        /*
        $sql = sprintf("INSERT INTO personnes SET nom='%s', prenom='%s'",
            $_POST['nom'], 
            $_POST['prenom']
        );
        */
        $connect->query($sql);
        echo $connect->error;
        $response['response'] = "Ajout un produit avec id " . $connect->insert_id;
        $response['new_id'] = $connect->insert_id;
        //si id la cat n'exsite pas
        else :
        $response['response'] = "l'id catégorie n'existe pas";
        $response['code'] = 500;
    endif;  
    //exit;
endif; //END POST


//edit produit
if ($_SERVER['REQUEST_METHOD'] == 'PUT') :
    //extraction de l'objet json du paquet HTTP
    $json = file_get_contents('php://input');
    //décodage du format json, ça génère un object PHP
    //$objectPOST = json_decode($json);
    $arrayPOST = json_decode($json, true);

    //si on a l'id du produit, le 'label' et le 'prix'
    if( isset($arrayPOST['label']) AND isset($arrayPOST['prix']) AND $_GET['id_produits']) :
        $sql = sprintf("UPDATE produits SET label='%s', prix=%d, id_categories=%s WHERE id= %d",
            strip_tags(addslashes($arrayPOST['label'])), //lire une propriété d'un objet PHP
            strip_tags($arrayPOST['prix']),
            isset($arrayPOST['id_categories']) ? strip_tags($arrayPOST['id_categories']) : 'NULL',// si on a l'id_categories, on l'utilise, sinon retourne NULL, d'où l'usage du %s pour l'id_categories dans $sql
            $_GET['id_produits']
        );
        $response['sql'] = $sql;
        $connect->query($sql);
        echo $connect->error;
        $response['response'] = "Edit unn produit avec id " . $_GET['id_produits'];
        $response['new_data'] = $arrayPOST;
    else :
        //si pas de label
        $response['response'] = "Il manque des données ou l'id";
        $response['code'] = 500;
    endif;
endif; //END PUT
//
//generation du code 200 par défaut si le code n'est pas encore défini
$response['code'] = ( isset($response['code']) ) ? $response['code'] : 200;
//définition de la ate et heure de la requête
$response['time'] = date('Y-m-d,H:i:s');
//encodage en json et affichage
echo json_encode($response);