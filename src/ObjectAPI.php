<?php
require_once (dirname(__FILE__). '/KiiBucket.php');
require_once (dirname(__FILE__). '/KiiObject.php');
interface ObjectAPI {
    public function create(KiiBucket $bucket, array $data);
    
    public function update(KiiObject $object);

    public function updatePatch(KiiObject $object, array $patch);

    public function updateIfUnmodified(KiiObject $object);

    public function delete(KiiObject $object);

    public function updateBody(KiiObject $object, string $contentType, $data);

    public function downloadBody(KiiObject $object, $fp);

    public function publish(KiiObject $object);
}

?>