<?php

namespace Shrikeh\PagerDuty\Application\Provider\Repository\Users;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Shrikeh\PagerDuty\Application\Provider\Client;
use Shrikeh\PagerDuty\Application\Provider\Repository\Users as UsersRepositoryProvider;
use Shrikeh\PagerDuty\Repository\Users\Users as UsersRepository;
use Shrikeh\PagerDuty\Application\Provider\Hydrator\User as UserHydratorProvider;

final class Users implements UsersRepositoryProvider, ServiceProviderInterface
{
    use \Shrikeh\PagerDuty\Application\Provider\RegisterWith;

    public function register(Container $container)
    {
        $container = $this->addResourceProviders($container);
        $container[static::PROVIDER_REPOSITORY_USERS] = function(Container $c) {
            return new UsersRepository(
                $c[Client::PROVIDER_CLIENT],
                $c[UserHydratorProvider::PROVIDER_HYDRATOR_USER]
            );
        };
    }

    private function addResourceProviders(Container $container)
    {
        if (!$container->offsetExists(UserHydratorProvider::PROVIDER_HYDRATOR_USER)) {
            UserHydratorProvider::registerWith($container);
        }
        return $container;
    }
}
