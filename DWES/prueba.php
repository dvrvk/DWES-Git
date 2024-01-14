<?php
try {
    $pdo->prepare("INSERT INTO users VALUES (NULL,?,?,?,?)")->execute($data);
} catch (PDOException $e) {
    $existingkey = "Integrity constraint violation: 1062 Duplicate entry";
    if (strpos($e->getMessage(), $existingkey) !== FALSE) {

        // Take some action if there is a key constraint violation, i.e. duplicate name
    } else {
        throw $e;
    }
}
?>
