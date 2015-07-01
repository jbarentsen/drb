<?php

namespace DwsAuth\Adapter;

use NcpUser\Model\User;
use NcpUser\Service\UserService;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Http\Request;

class HmacValidationAdapter implements AdapterInterface
{

    /**
     * Required name for HMAC Header
     */
    const HMAC_VALIDATION_HEADER_KEY = 'X-HMAC';

    /**
     * Time in seconds that a timestamp can differ (earlier or later) from server time.
     * Currently 5min
     */
    const HMAC_EXPIRATION_TIME = 300;

    /**
     * @var Request $request
     */
    protected $request;
    /**
     * @var UserService $service
     */
    protected $service;

    /**
     * @param Request $request
     * @param UserService $service
     */
    public function __construct(
        Request $request,
        UserService $service
    ) {
        $this->request = $request;
        $this->service = $service;
    }

    /**
     * @return Result
     */
    public function authenticate()
    {
        // @TODO: Finish actual HMAC authentication. Based on the concept below.
        // For now, return true
        return new Result(Result::SUCCESS, 'a');

        $request = $this->request;
        $headers = $request->getHeaders();

        // Check Authorization header presence
        if (!$headers->has(self::HMAC_VALIDATION_HEADER_KEY)) {
            return new Result(Result::FAILURE, null, [
                'HMAC Authorization header missing'
            ]);
        }
        // Check Authorization prefix
        $authorization = $headers->get(self::HMAC_VALIDATION_HEADER_KEY)->getFieldValue();

        // Validate public key
        list($publicKey, $signature, $timestamp) = $this->extract($authorization);

        // Check if required parameters were found
        if ($publicKey === null || $signature === null) {
            $code = Result::FAILURE_CREDENTIAL_INVALID;
            return new Result($code, null, [
                'Client not found based on signature'
            ]);
        }

        // Check for valid timestamp
        if (!$this->validateTimestamp($timestamp)) {
            $code = Result::FAILURE_CREDENTIAL_INVALID;
            return new Result($code, null, [
                'Signature expired'
            ]);
        }

        //$apiClient = $this->service->findByPublicKey($publicKey);
        $apiClient = new \stdClass(); // Debug
        // @TODO: to be replaced by ApiClient
        if (null === $apiClient) {
            $code = Result::FAILURE_IDENTITY_NOT_FOUND;
            return new Result($code, null, [
                'Client not found based on signature'
            ]);
        }

        // Validate signature
        $hmac = $this->createHmac($request, $apiClient, $timestamp);
        if ($signature !== $hmac) {
            $code = Result::FAILURE_CREDENTIAL_INVALID;
            return new Result($code, null, [
                'Signature does not match'
            ]);
        }

        return new Result(Result::SUCCESS, $apiClient);
    }

    /**
     * @param string $hmac
     * @return array
     */
    private function extract($hmac)
    {
        // Expect: <PublicKey>:<Signature>:UTC Timestamp
        $extraction = explode(':', $hmac);
        if (count($extraction) !== 3) {
            return [null, null, 0];
        }
        return $extraction;
    }

    /**
     * @param Request $request
     * @param User $apiClient
     * @param string $timestamp
     * @return string
     */
    private function createHmac(Request $request, User $apiClient, $timestamp)
    {
        $method = $request->getMethod();
        $uri = $request->getUri()->getPath();
        $query = $request->getQuery();
        $query->offsetUnset('q');
        $query->toString();
        // Remove internal routing parameter
        if (isset($query['q'])) {
            unset($query['q']);
        }

        //$key = $apiClient->getUsername();
        $key = 'testuser'; // Debug
        $input = trim(join(' ', [$timestamp, $method, $uri, $query->toString()]));
        return hash_hmac('sha256', $input, $key, false);
    }

    /**
     * @param int $timestamp
     * @return bool
     */
    private function validateTimestamp($timestamp)
    {
        return (abs(time() - $timestamp)) < self::HMAC_EXPIRATION_TIME;
    }
}