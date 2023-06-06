<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ServiceSubscriberTraits\JsonRequestDecoderAware;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * controller for customer api requests
 *
 * @package   App\Controller
 * @version   0.0.1
 * @since     0.0.1
 */
class DefaultController extends AbstractController
{
    use JsonRequestDecoderAware;

    /**
     * Use this response code for al failed responses to be able to change them in one place.
     */
    const HTTP_BAD_REQUEST = Response::HTTP_BAD_REQUEST;

    /**
     * getJsonFailedResponse
     *
     * @param \Exception $ex
     * @param int        $status
     * @param array      $headers
     * @param array      $context
     *
     * @return JsonResponse
     */
    public function getJsonFailedResponse(
        \Exception $ex,
        int $status = self::HTTP_BAD_REQUEST,
        array $headers = [],
        array $context = []
    ): JsonResponse {
        $msg = $ex->getMessage();
        // @todo allow to display only AgentNoticeException
        // @todo show default translated message for all other exceptions

        return $this->json(
            [
                'result'  => false,
                'message' => $msg,
            ],
            $status,
            $headers,
            $context
        );
    }
}