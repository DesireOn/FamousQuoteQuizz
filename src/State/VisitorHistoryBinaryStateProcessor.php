<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

class VisitorHistoryBinaryStateProcessor implements ProcessorInterface
{
    public function __construct(private ProcessorInterface $persistProcessor)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $result = $this->persistProcessor->process($data, $operation, $uriVariables, $context);

        return $result;
    }
}
