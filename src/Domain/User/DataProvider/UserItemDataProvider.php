<?php

declare(strict_types=1);

namespace Domain\User\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Conversation;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\Exception\ResourceAccessException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class UserItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(
        private Security $security,
        private UserRepository $userRepository
    ) {
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?User
    {
        $userFind = $this->userRepository->find($id);

        if (null === $userFind) {
            return null;
        }

        /** @var User $user */
        $user = $this->security->getUser();

        if ($userFind != $user) {
            throw new ResourceAccessException(Response::HTTP_FORBIDDEN, ResourceAccessException::RESOURCE_ACCESS_EXCEPTION);
        }

        return $user;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return User::class === $resourceClass;
    }
}
