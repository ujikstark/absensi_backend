<?php

declare(strict_types=1);

namespace Domain\User\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\User;
use Model\User\UpdateUserDTO;
use Symfony\Component\Security\Core\Security;

class UpdateUserDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private ValidatorInterface $validator,
        private Security $security
    ) {
    }

    /**
     * @param UpdateUserDTO $object
     * 
     * @throws ValidationException
     */
    
    public function transform($object, string $to, array $context = []): User
    {
        $user = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE];
        
        $this->validator->validate($object);

        $user
            ->setName($object->getName())
            ->setBirthDate($object->getBirthDate())
            ->setGender($object->getGender())
            ->setStatus($object->getStatus())
            ->setDescription($object->getDescription())
            ->setPhoneNumber($object->getPhoneNumber())
            ->setAddress($object->getAddress());
        
        return $user;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return isset($context['input']['class']) && UpdateUserDTO::class === $context['input']['class'];
    }


}