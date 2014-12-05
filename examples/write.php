<?php

require __DIR__ . "/../src/MongoDB/QueryFlags.php";
require __DIR__ . "/../src/MongoDB/CursorType.php";
require __DIR__ . "/../src/MongoDB/Collection.php";


$manager = new MongoDB\Manager("mongodb://localhost:27017");


$collection = new MongoDB\Collection($manager, "crud.examples");
$hannes = array(
	"name"    => "Hannes", 
	"nick"    => "bjori",
	"citizen" => "Iceland",
);
$hayley = array(
	"name"    => "Hayley",
	"nick"    => "Ninja",
	"citizen" => "USA",
);
$bobby = array(
    "name" => "Robert Fischer",
    "nick" => "Bobby Fischer",
    "citizen" => "USA",
);

try {
    $result = $collection->insertOne($hannes);
    printf("Inserted: %s (out of expected 1)\n", $result->getNumInserted());
    $result = $collection->insertOne($hayley);
    printf("Inserted: %s (out of expected 1)\n", $result->getNumInserted());
    $result = $collection->insertOne($bobby);
    printf("Inserted: %s (out of expected 1)\n", $result->getNumInserted());

    $count = $collection->count(array("nick" => "bjori"));
    printf("Searching for nick => bjori, should have only one result: %d\n", $count);

    $result = $collection->updateOne(
        array("citizen" => "USA"),
        array('$set' => array("citizen" => "Iceland"))
    );
    printf("Updated: %s (out of expected 1)\n", $result->getNumModified());

    $result = $collection->find(array("citizen" => "Iceland"), array("comment" => "Excellent query"));
    echo "Searching for citizen => Iceland, verify Hayley is now Icelandic\n";
    foreach($result as $document) {
        var_dump($document);
    }
} catch(Exception $e) {
    echo $e->getMessage(), "\n";
    exit;
}

try {
    $result = $collection->find();
    echo "Find all docs, should be 3, verify 1x USA citizen, 2x Icelandic\n";
    foreach($result as $document) {
        var_dump($document);
    }
    $result = $collection->distinct("citizen");
    echo "Distinct countries:\n";
    var_dump($result);

    echo "aggregate\n";
    $aggregate = $collection->aggregate(array(array('$project' => array("name" => 1, "_id" => 0))), array("useCursor" => true));
    printf("Should be 3 different people\n");
    foreach($aggregate as $person) {
        var_dump($person);
    }

    $result = $collection->updateMany(
        array("citizen" => "Iceland"),
        array('$set' => array("viking" => true))
    );

    printf("Updated: %d (out of expected 2), verify Icelandic people are vikings\n", $result->getNumModified());
    $result = $collection->find();
    foreach($result as $document) {
        var_dump($document);
    }
    $result = $collection->replaceOne(
        array("nick" => "Bobby Fischer"),
        array("name" => "Magnus Carlsen", "nick" => "unknown", "citizen" => "Norway")
    );
    printf("Replaced: %d (out of expected 1), verify Bobby has been replaced with Magnus\n", $result->getNumModified());
    $result = $collection->find();
    foreach($result as $document) {
        var_dump($document);
    }

    $result = $collection->deleteOne($document);
    printf("Deleted: %d (out of expected 1)\n", $result->getNumRemoved());

    $result = $collection->deleteMany(array("citizen" => "Iceland"));
    printf("Deleted: %d (out of expected 2)\n", $result->getNumRemoved());
} catch(Exception $e) {
    echo $e->getMessage(), "\n";
    exit;

}

