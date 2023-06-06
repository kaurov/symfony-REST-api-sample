<?php

namespace App\Service\ServiceSubscriberTraits;

use App\Service\JsonRequestDecoder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Contracts\Service\Attribute\SubscribedService;

/**
 * JsonRequestDecoderAware
 * @package App\Service\ServiceSubscriberTraits
 */
trait JsonRequestDecoderAware
{
    /**
     * Injects TransactionEmailSender
     * @return JsonRequestDecoder
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[SubscribedService]
    protected function getJsonRequestDecoder(): JsonRequestDecoder
    {
        try {
            // for controllers
            return $this->container->get(JsonRequestDecoder::class);
        } catch (\Exception) {
            // continue to service injector
        }

        return $this->container->get(__CLASS__ . '::' . __FUNCTION__);
    }
}