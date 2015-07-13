<?PHP
require_once (dirname(__FILE__) . '/../ObjectAPI.php');
require_once (dirname(__FILE__) . '/../KiiContext.php');
require_once (dirname(__FILE__) . '/../CloudException.php');

class KiiObjectAPI implements ObjectAPI {
    private $context;

    public function __construct($context) {
        $this->context = $context;
    }
    
    public function create(KiiBucket $bucket, $data) {
        $c = $this->context;
        $url = $c->getServerUrl().
            '/apps/'. $c->getAppId().
            $bucket->getPath(). 
            '/objects';

        $client = $c->getNewClient();
        $client->setUrl($url);
        $client->setMethod(HttpClient::HTTP_POST);
        $client->setKiiHeader($c, TRUE);
        $client->setContentType('application/json');

        $resp = $client->sendJson($data);
        if ($resp->getStatus() != 201) {
            throw new CloudException($resp->getStatus(), $resp->getAsJson());
        }
        $respJson = $resp->getAsJson();
        $respHeaders = $resp->getAllHeaders();
        $version = $respHeaders['etag'];
        $id = $respJson['objectID'];

        $kiiobj = new KiiObject($bucket, $id, $data);
        $kiiobj->version = $version;
        return $kiiobj;
    }

    public function update(KiiObject $object) {
        $c = $this->context;
        $url = $c->getServerUrl().
            '/apps/'. $c->getAppId().
            $object->getPath();

        $client = $c->getNewClient();
        $client->setUrl($url);
        $client->setMethod(HttpClient::HTTP_PUT);
        $client->setKiiHeader($c, TRUE);
        $client->setContentType('application/json');

        $resp = $client->sendJson($object->data);
        if ($resp->getStatus() == 200) {
            $respJson = $resp->getAsJson();
            $respHeaders = $resp->getAllHeaders();
            $version = $respHeaders['etag'];
            $object->version = $version;
            return $object;
        } else if ($resp->getStatus() == 201) {
            $respHeaders = $resp->getAllHeaders();
            $version = $respHeaders['etag'];
            $object->version = $version;
            return $object;
        }
        throw new CloudException($resp->getStatus(), $resp->getAsJson());
    }

    public function updatePatch(KiiObject $object, $patch) {
        $c = $this->context;
        $url = $c->getServerUrl().
            '/apps/'. $c->getAppId().
            $object->getPath();

        $client = $c->getNewClient();
        $client->setUrl($url);
        $client->setMethod(HttpClient::HTTP_POST);
        $client->setKiiHeader($c, TRUE);
        $client->setContentType('application/json');
        $client->setHeader('X-HTTP-Method-Override', 'PATCH');

        $resp = $client->sendJson($patch);
        if ($resp->getStatus() == 200) {
            $respJson = $resp->getAsJson();
            $respHeaders = $resp->getAllHeaders();
            $version = $respHeaders['etag'];
            $object->version = $version;
            // update
            foreach ($patch as $k => $v) {
                $object->data[$k] = $v;
            }
            return $object;
        } else if ($resp->getStatus() == 201) {
            $respHeaders = $resp->getAllHeaders();
            $version = $respHeaders['etag'];
            $object->version = $version;
            return $object;
        }
        throw new CloudException($resp->getStatus(), $resp->getAsJson());
    }

    public function updateIfUnmodified(KiiObject $object) {
        $c = $this->context;
        $url = $c->getServerUrl().
            '/apps/'. $c->getAppId().
            $object->getPath();

        $client = $c->getNewClient();
        $client->setUrl($url);
        $client->setMethod(HttpClient::HTTP_PUT);
        $client->setKiiHeader($c, TRUE);
        $client->setHeader('If-Match', $object->version);
        $client->setContentType('application/json');

        $resp = $client->sendJson($object->data);
        if ($resp->getStatus() == 200) {
            $respJson = $resp->getAsJson();
            $respHeaders = $resp->getAllHeaders();
            $version = $respHeaders['etag'];            
            $object->version = $version;
            return $object;
        } else if ($resp->getStatus() == 201) {
            $respHeaders = $resp->getAllHeaders();
            $version = $respHeaders['etag'];                        
            $object->version = $version;
            return $object;
        }
        throw new CloudException($resp->getStatus(), $resp->getAsJson());
    }
    
    public function delete(KiiObject $object) {
        $c = $this->context;
        $url = $c->getServerUrl().
            '/apps/'. $c->getAppId().
            $object->getPath();

        $client = $c->getNewClient();
        $client->setUrl($url);
        $client->setMethod(HttpClient::HTTP_DELETE);
        $client->setKiiHeader($c, TRUE);

        $resp = $client->send();
        if ($resp->getStatus() != 204) {
            throw new CloudException($resp->getStatus(), $resp->getAsJson());
        }
    }

    public function updateBody(KiiObject $object, $contentType, $data) {    
        $c = $this->context;
        $url = $c->getServerUrl().
            '/apps/'. $c->getAppId().
            $object->getPath().
            '/body';

        $client = $c->getNewClient();
        $client->setUrl($url);
        $client->setMethod(HttpClient::HTTP_PUT);
        $client->setKiiHeader($c, TRUE);
        $client->setContentType($contentType);

        $resp = $client->sendFile($data);
        if ($resp->getStatus() == 200) {
            $respJson = $resp->getAsJson();
            return $object;
        } else if ($resp->getStatus() == 201) {
            return $object;
        }
        throw new CloudException($resp->getStatus(), $resp->getAsJson());
    }

    public function downloadBody(KiiObject $object, $fp) {
        $c = $this->context;
        $url = $c->getServerUrl().
            '/apps/'. $c->getAppId().
            $object->getPath().
            '/body';

        $client = $c->getNewClient();
        $client->setUrl($url);
        $client->setMethod(HttpClient::HTTP_GET);
        $client->setKiiHeader($c, TRUE);

        $resp = $client->sendForDownload($fp);
        if ($resp->getStatus() == 200) {
            return TRUE;
        } else if ($resp->getStatus() == 201) {
            return TRUE;
        }
        throw new CloudException($resp->getStatus(), $resp->getAsJson());
    }

    public function publish(KiiObject $object) {
        $c = $this->context;
        $url = $c->getServerUrl().
            '/apps/'. $c->getAppId().
            $object->getPath().
            '/body/publish';

        $client = $c->getNewClient();
        $client->setUrl($url);
        $client->setMethod(HttpClient::HTTP_POST);
        $client->setKiiHeader($c, TRUE);
        $client->setContentType('application/vnd.kii.ObjectBodyPublicationRequest+json');

        $resp = $client->sendJson(null);
        if ($resp->getStatus() == 201) {
            $respJson = $resp->getAsJson();
            return $respJson['url'];
        }
        throw new CloudException($resp->getStatus(), $resp->getAsJson());        
    }
}

?>