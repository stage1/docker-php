<?php

/*
 * This file has been auto generated by Jane,
 *
 * Do no edit it directly.
 */

namespace Docker\API\V1_28\Resource;

use Joli\Jane\OpenApi\Runtime\Client\QueryParam;
use Joli\Jane\OpenApi\Runtime\Client\Resource;

class SecretResource extends Resource
{
    /**
     * @param array $parameters {
     *
     *     @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to process on the secrets list. Available filters:

     - `names=<secret name>`

     * }
     *
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Docker\API\V1_28\Model\Secret[]|\Docker\API\V1_28\Model\ErrorResponse
     */
    public function secretList($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('filters', null);
        $url     = '/v1.28/secrets';
        $url     = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost', 'Accept' => ['application/json']], $queryParam->buildHeaders($parameters));
        $body    = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $promise = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('200' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\Secret[]', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
            if ('503' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * @param \Docker\API\V1_28\Model\SecretsCreatePostBody $body
     * @param array                                         $parameters List of parameters
     * @param string                                        $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Docker\API\V1_28\Model\SecretsCreatePostResponse201|\Docker\API\V1_28\Model\ErrorResponse
     */
    public function secretCreate(\Docker\API\V1_28\Model\SecretsCreatePostBody $body, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url        = '/v1.28/secrets/create';
        $url        = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers    = array_merge(['Host' => 'localhost', 'Accept' => ['application/json'], 'Content-Type' => 'application/json'], $queryParam->buildHeaders($parameters));
        $body       = $this->serializer->serialize($body, 'json');
        $request    = $this->messageFactory->createRequest('POST', $url, $headers, $body);
        $promise    = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('201' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\SecretsCreatePostResponse201', 'json');
            }
            if ('409' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
            if ('503' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * @param string $id         ID of the secret
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null|\Docker\API\V1_28\Model\ErrorResponse
     */
    public function secretDelete($id, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url        = '/v1.28/secrets/{id}';
        $url        = str_replace('{id}', urlencode($id), $url);
        $url        = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers    = array_merge(['Host' => 'localhost', 'Accept' => ['application/json']], $queryParam->buildHeaders($parameters));
        $body       = $queryParam->buildFormDataString($parameters);
        $request    = $this->messageFactory->createRequest('DELETE', $url, $headers, $body);
        $promise    = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('204' == $response->getStatusCode()) {
                return null;
            }
            if ('404' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
            if ('503' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * @param string $id         ID of the secret
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Docker\API\V1_28\Model\Secret|\Docker\API\V1_28\Model\ErrorResponse
     */
    public function secretInspect($id, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url        = '/v1.28/secrets/{id}';
        $url        = str_replace('{id}', urlencode($id), $url);
        $url        = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers    = array_merge(['Host' => 'localhost', 'Accept' => ['application/json']], $queryParam->buildHeaders($parameters));
        $body       = $queryParam->buildFormDataString($parameters);
        $request    = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $promise    = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('200' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\Secret', 'json');
            }
            if ('404' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
            if ('503' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * @param string                             $id         The ID or name of the secret
     * @param \Docker\API\V1_28\Model\SecretSpec $body       The spec of the secret to update. Currently, only the Labels field can be updated. All other fields must remain unchanged from the [SecretInspect endpoint](#operation/SecretInspect) response values.
     * @param array                              $parameters {
     *
     *     @var int $version The version number of the secret object being updated. This is required to avoid conflicting writes.
     * }
     *
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null|\Docker\API\V1_28\Model\ErrorResponse
     */
    public function secretUpdate($id, \Docker\API\V1_28\Model\SecretSpec $body, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setRequired('version');
        $url     = '/v1.28/secrets/{id}/update';
        $url     = str_replace('{id}', urlencode($id), $url);
        $url     = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body    = $this->serializer->serialize($body, 'json');
        $request = $this->messageFactory->createRequest('POST', $url, $headers, $body);
        $promise = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('200' == $response->getStatusCode()) {
                return null;
            }
            if ('404' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
            if ('503' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_28\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }
}
