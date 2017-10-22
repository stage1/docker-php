<?php

/*
 * This file has been auto generated by Jane,
 *
 * Do no edit it directly.
 */

namespace Docker\API\V1_32\Resource;

use Joli\Jane\OpenApi\Runtime\Client\QueryParam;
use Joli\Jane\OpenApi\Runtime\Client\Resource;

class ImageResource extends Resource
{
    /**
     * Returns a list of images on the server. Note that it uses a different, smaller representation of an image than inspecting a single image.
     *
     * @param array $parameters {
     *
     *     @var bool $all Show all images. Only images from a final layer (no children) are shown by default.
     *     @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to process on the images list. Available filters:

     *     @var bool $digests Show digest information as a `RepoDigests` field on each image.
     * }
     *
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Docker\API\V1_32\Model\ImageSummary[]|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imageList($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('all', false);
        $queryParam->setDefault('filters', null);
        $queryParam->setDefault('digests', false);
        $url     = '/v1.32/images/json';
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
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ImageSummary[]', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * Build an image from a tar archive with a `Dockerfile` in it.

     The `Dockerfile` specifies how the image is built from the tar archive. It is typically in the archive's root, but can be at a different path or have a different name by specifying the `dockerfile` parameter. [See the `Dockerfile` reference for more information](https://docs.docker.com/engine/reference/builder/).

     The Docker daemon performs a preliminary validation of the `Dockerfile` before starting the build, and returns an error if the syntax is incorrect. After that, each instruction is run one-by-one until the ID of the new image is output.

     The build is canceled if the client drops the connection by quitting or being killed.

     *
     * @param string $inputStream a tar archive compressed with one of the following algorithms: identity (no compression), gzip, bzip2, xz
     * @param array  $parameters  {
     *
     *     @var string $dockerfile Path within the build context to the `Dockerfile`. This is ignored if `remote` is specified and points to an external `Dockerfile`.
     *     @var string $t A name and optional tag to apply to the image in the `name:tag` format. If you omit the tag the default `latest` value is assumed. You can provide several `t` parameters.
     *     @var string $extrahosts Extra hosts to add to /etc/hosts
     *     @var string $remote A Git repository URI or HTTP/HTTPS context URI. If the URI points to a single text file, the file’s contents are placed into a file called `Dockerfile` and the image is built from that file. If the URI points to a tarball, the file is downloaded by the daemon and the contents therein used as the context for the build. If the URI points to a tarball and the `dockerfile` parameter is also specified, there must be a file with the corresponding path inside the tarball.
     *     @var bool $q suppress verbose build output
     *     @var bool $nocache do not use the cache when building the image
     *     @var string $cachefrom JSON array of images used for build cache resolution
     *     @var string $pull attempt to pull the image even if an older image exists locally
     *     @var bool $rm remove intermediate containers after a successful build
     *     @var bool $forcerm always remove intermediate containers, even upon failure
     *     @var int $memory set memory limit for build
     *     @var int $memswap Total memory (memory + swap). Set as `-1` to disable swap.
     *     @var int $cpushares CPU shares (relative weight)
     *     @var string $cpusetcpus CPUs in which to allow execution (e.g., `0-3`, `0,1`).
     *     @var int $cpuperiod the length of a CPU period in microseconds
     *     @var int $cpuquota microseconds of CPU time that the container can get in a CPU period
     *     @var int $buildargs JSON map of string pairs for build-time variables. Users pass these values at build-time. Docker uses the buildargs as the environment context for commands run via the `Dockerfile` RUN instruction, or for variable expansion in other `Dockerfile` instructions. This is not meant for passing secret values. [Read more about the buildargs instruction.](https://docs.docker.com/engine/reference/builder/#arg)
     *     @var int $shmsize Size of `/dev/shm` in bytes. The size must be greater than 0. If omitted the system uses 64MB.
     *     @var bool $squash Squash the resulting images layers into a single layer. *(Experimental release only.)*
     *     @var string $labels arbitrary key/value labels to set on the image, as a JSON map of string pairs
     *     @var string $networkmode Sets the networking mode for the run commands during build. Supported standard values are: `bridge`, `host`, `none`, and `container:<name|id>`. Any other value is taken as a custom network's name to which this container should connect to.
     *     @var string $Content-type
     *     @var string $X-Registry-Config This is a base64-encoded JSON object with auth configurations for multiple registries that a build may refer to

     * }
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imageBuild($inputStream, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('dockerfile', 'Dockerfile');
        $queryParam->setDefault('t', null);
        $queryParam->setDefault('extrahosts', null);
        $queryParam->setDefault('remote', null);
        $queryParam->setDefault('q', false);
        $queryParam->setDefault('nocache', false);
        $queryParam->setDefault('cachefrom', null);
        $queryParam->setDefault('pull', null);
        $queryParam->setDefault('rm', true);
        $queryParam->setDefault('forcerm', false);
        $queryParam->setDefault('memory', null);
        $queryParam->setDefault('memswap', null);
        $queryParam->setDefault('cpushares', null);
        $queryParam->setDefault('cpusetcpus', null);
        $queryParam->setDefault('cpuperiod', null);
        $queryParam->setDefault('cpuquota', null);
        $queryParam->setDefault('buildargs', null);
        $queryParam->setDefault('shmsize', null);
        $queryParam->setDefault('squash', null);
        $queryParam->setDefault('labels', null);
        $queryParam->setDefault('networkmode', null);
        $queryParam->setDefault('Content-type', 'application/x-tar');
        $queryParam->setHeaderParameters(['Content-type']);
        $queryParam->setDefault('X-Registry-Config', null);
        $queryParam->setHeaderParameters(['X-Registry-Config']);
        $url     = '/v1.32/build';
        $url     = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost', 'Accept' => ['application/json'], 'Content-Type' => 'application/json'], $queryParam->buildHeaders($parameters));
        $body    = $inputStream;
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
            if ('400' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Docker\API\V1_32\Model\BuildPrunePostResponse200|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function buildPrune($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url        = '/v1.32/build/prune';
        $url        = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers    = array_merge(['Host' => 'localhost', 'Accept' => ['application/json']], $queryParam->buildHeaders($parameters));
        $body       = $queryParam->buildFormDataString($parameters);
        $request    = $this->messageFactory->createRequest('POST', $url, $headers, $body);
        $promise    = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('200' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\BuildPrunePostResponse200', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * Create an image by either pulling it from a registry or importing it.
     *
     * @param string $inputImage Image content if the value `-` has been specified in fromSrc query parameter
     * @param array  $parameters {
     *
     *     @var string $fromImage Name of the image to pull. The name may include a tag or digest. This parameter may only be used when pulling an image. The pull is cancelled if the HTTP connection is closed.
     *     @var string $fromSrc Source to import. The value may be a URL from which the image can be retrieved or `-` to read the image from the request body. This parameter may only be used when importing an image.
     *     @var string $repo Repository name given to an image when it is imported. The repo may include a tag. This parameter may only be used when importing an image.
     *     @var string $tag Tag or digest. If empty when pulling an image, this causes all tags for the given image to be pulled.
     *     @var string $X-Registry-Auth A base64-encoded auth configuration. [See the authentication section for details.](#section/Authentication)
     * }
     *
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imageCreate($inputImage, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('fromImage', null);
        $queryParam->setDefault('fromSrc', null);
        $queryParam->setDefault('repo', null);
        $queryParam->setDefault('tag', null);
        $queryParam->setDefault('X-Registry-Auth', null);
        $queryParam->setHeaderParameters(['X-Registry-Auth']);
        $url     = '/v1.32/images/create';
        $url     = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost', 'Accept' => ['application/json'], 'Content-Type' => 'application/json'], $queryParam->buildHeaders($parameters));
        $body    = $inputImage;
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
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * Return low-level information about an image.
     *
     * @param string $name       Image name or id
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Docker\API\V1_32\Model\Image|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imageInspect($name, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url        = '/v1.32/images/{name}/json';
        $url        = str_replace('{name}', urlencode($name), $url);
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
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\Image', 'json');
            }
            if ('404' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * Return parent layers of an image.
     *
     * @param string $name       Image name or ID
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Docker\API\V1_32\Model\ImagesNameHistoryGetResponse200Item[]|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imageHistory($name, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url        = '/v1.32/images/{name}/history';
        $url        = str_replace('{name}', urlencode($name), $url);
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
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ImagesNameHistoryGetResponse200Item[]', 'json');
            }
            if ('404' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * Push an image to a registry.

     If you wish to push an image on to a private registry, that image must already have a tag which references the registry. For example, `registry.example.com/myimage:latest`.

     The push is cancelled if the HTTP connection is closed.

     *
     * @param string $name       image name or ID
     * @param array  $parameters {
     *
     *     @var string $tag the tag to associate with the image on the registry
     *     @var string $X-Registry-Auth A base64-encoded auth configuration. [See the authentication section for details.](#section/Authentication)
     * }
     *
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imagePush($name, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('tag', null);
        $queryParam->setRequired('X-Registry-Auth');
        $queryParam->setHeaderParameters(['X-Registry-Auth']);
        $url     = '/v1.32/images/{name}/push';
        $url     = str_replace('{name}', urlencode($name), $url);
        $url     = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body    = $queryParam->buildFormDataString($parameters);
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
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * Tag an image so that it becomes part of a repository.
     *
     * @param string $name       image name or ID to tag
     * @param array  $parameters {
     *
     *     @var string $repo The repository to tag in. For example, `someuser/someimage`.
     *     @var string $tag The name of the new tag.
     * }
     *
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imageTag($name, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('repo', null);
        $queryParam->setDefault('tag', null);
        $url     = '/v1.32/images/{name}/tag';
        $url     = str_replace('{name}', urlencode($name), $url);
        $url     = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body    = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('POST', $url, $headers, $body);
        $promise = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('201' == $response->getStatusCode()) {
                return null;
            }
            if ('400' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
            if ('404' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
            if ('409' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * Remove an image, along with any untagged parent images that were.
     referenced by that image.

     Images can't be removed if they have descendant images, are being
     used by a running container or are being used by a build.

     *
     * @param string $name       Image name or ID
     * @param array  $parameters {
     *
     *     @var bool $force Remove the image even if it is being used by stopped containers or has other tags
     *     @var bool $noprune Do not delete untagged parent images
     * }
     *
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Docker\API\V1_32\Model\ImageDeleteResponseItem[]|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imageDelete($name, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('force', false);
        $queryParam->setDefault('noprune', false);
        $url     = '/v1.32/images/{name}';
        $url     = str_replace('{name}', urlencode($name), $url);
        $url     = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost', 'Accept' => ['application/json']], $queryParam->buildHeaders($parameters));
        $body    = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('DELETE', $url, $headers, $body);
        $promise = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('200' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ImageDeleteResponseItem[]', 'json');
            }
            if ('404' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
            if ('409' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * Search for an image on Docker Hub.
     *
     * @param array $parameters {
     *
     *     @var string $term Term to search
     *     @var int $limit Maximum number of results to return
     *     @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to process on the images list. Available filters:

     * }
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Docker\API\V1_32\Model\ImagesSearchGetResponse200Item[]|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imageSearch($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setRequired('term');
        $queryParam->setDefault('limit', null);
        $queryParam->setDefault('filters', null);
        $url     = '/v1.32/images/search';
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
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ImagesSearchGetResponse200Item[]', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * @param array $parameters {
     *
     *     @var string $filters Filters to process on the prune list, encoded as JSON (a `map[string][]string`). Available filters:

     - `dangling=<boolean>` When set to `true` (or `1`), prune only
     unused *and* untagged images. When set to `false`
     * }
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Docker\API\V1_32\Model\ImagesPrunePostResponse200|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imagePrune($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('filters', null);
        $url     = '/v1.32/images/prune';
        $url     = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost', 'Accept' => ['application/json']], $queryParam->buildHeaders($parameters));
        $body    = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('POST', $url, $headers, $body);
        $promise = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('200' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ImagesPrunePostResponse200', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * @param \Docker\API\V1_32\Model\ContainerConfig $containerConfig The container configuration
     * @param array                                   $parameters      {
     *
     *     @var string $container The ID or name of the container to commit
     *     @var string $repo Repository name for the created image
     *     @var string $tag Tag name for the create image
     *     @var string $comment Commit message
     *     @var string $author Author of the image (e.g., `John Hannibal Smith <hannibal@a-team.com>`)
     *     @var bool $pause Whether to pause the container before committing
     *     @var string $changes `Dockerfile` instructions to apply while committing
     * }
     *
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\Docker\API\V1_32\Model\IdResponse|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imageCommit(\Docker\API\V1_32\Model\ContainerConfig $containerConfig, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('container', null);
        $queryParam->setDefault('repo', null);
        $queryParam->setDefault('tag', null);
        $queryParam->setDefault('comment', null);
        $queryParam->setDefault('author', null);
        $queryParam->setDefault('pause', true);
        $queryParam->setDefault('changes', null);
        $url     = '/v1.32/commit';
        $url     = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost', 'Accept' => ['application/json'], 'Content-Type' => 'application/json'], $queryParam->buildHeaders($parameters));
        $body    = $this->serializer->serialize($containerConfig, 'json');
        $request = $this->messageFactory->createRequest('POST', $url, $headers, $body);
        $promise = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('201' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\IdResponse', 'json');
            }
            if ('404' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * Get a tarball containing all images and metadata for a repository.

     If `name` is a specific name and tag (e.g. `ubuntu:latest`), then only that image (and its parents) are returned. If `name` is an image ID, similarly only that image (and its parents) are returned, but with the exclusion of the `repositories` file in the tarball, as there were no image names referenced.

     ### Image tarball format

     An image tarball contains one directory per image layer (named using its long ID), each containing these files:

     - `VERSION`: currently `1.0` - the file format version
     - `json`: detailed layer information, similar to `docker inspect layer_id`
     - `layer.tar`: A tarfile containing the filesystem changes in this layer

     The `layer.tar` file contains `aufs` style `.wh..wh.aufs` files and directories for storing attribute changes and deletions.

     If the tarball defines a repository, the tarball should also include a `repositories` file at the root that contains a list of repository and tag names mapped to layer IDs.

     ```json
     {
     "hello-world": {
     "latest": "565a9d68a73f6706862bfe8409a7f659776d4d60a8d096eb4a3cbce6999cc2a1"
     }
     }
     ```

     *
     * @param string $name       Image name or ID
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imageGet($name, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url        = '/v1.32/images/{name}/get';
        $url        = str_replace('{name}', urlencode($name), $url);
        $url        = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers    = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body       = $queryParam->buildFormDataString($parameters);
        $request    = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $promise    = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('200' == $response->getStatusCode()) {
                return null;
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * Get a tarball containing all images and metadata for several image repositories.

     For each value of the `names` parameter: if it is a specific name and tag (e.g. `ubuntu:latest`), then only that image (and its parents) are returned; if it is an image ID, similarly only that image (and its parents) are returned and there would be no names referenced in the 'repositories' file for this image ID.

     For details on the format, see [the export image endpoint](#operation/ImageGet).

     *
     * @param array $parameters {
     *
     *     @var array $names Image names to filter by
     * }
     *
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imageGetAll($parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('names', null);
        $url     = '/v1.32/images/get';
        $url     = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost'], $queryParam->buildHeaders($parameters));
        $body    = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $promise = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('200' == $response->getStatusCode()) {
                return null;
            }
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }

    /**
     * Load a set of images and tags into a repository.

     For details on the format, see [the export image endpoint](#operation/ImageGet).

     *
     * @param string $imagesTarball Tar archive containing images
     * @param array  $parameters    {
     *
     *     @var bool $quiet Suppress progress details during load.
     * }
     *
     * @param string $fetch Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null|\Docker\API\V1_32\Model\ErrorResponse
     */
    public function imageLoad($imagesTarball, $parameters = [], $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('quiet', false);
        $url     = '/v1.32/images/load';
        $url     = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(['Host' => 'localhost', 'Accept' => ['application/json'], 'Content-Type' => 'application/json'], $queryParam->buildHeaders($parameters));
        $body    = $imagesTarball;
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
            if ('500' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'Docker\\API\\V1_32\\Model\\ErrorResponse', 'json');
            }
        }

        return $response;
    }
}
