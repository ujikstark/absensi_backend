<?php

declare(strict_types=1);

namespace Model\Attendance;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Attendance\UpdateDescriptionController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


#[ApiResource(
    collectionOperations: [
        'updateDescription' => [
            'controller' => UpdateDescriptionController::class,
            'path' => UpdateDescriptionController::PATH,
            'input' => UpdateDescriptionDTO::class,
            'method' => Request::METHOD_POST,
            
        ] 
    ],
    itemOperations: [],
    formats: ['json'],
    
    
)]
class UpdateDescriptionDTO
{   
    #[Assert\Length(max: 100)]
    public string $description;

    public function getDescription(): string 
    {
        return $this->description;
    }
}
