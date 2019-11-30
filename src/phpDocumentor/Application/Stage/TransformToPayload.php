<?php

declare(strict_types=1);

namespace phpDocumentor\Application\Stage;

use phpDocumentor\Descriptor\ProjectDescriptorBuilder;

final class TransformToPayload
{
    private $descriptorBuilder;

    public function __construct(ProjectDescriptorBuilder $descriptorBuilder)
    {
        $this->descriptorBuilder = $descriptorBuilder;
    }

    public function __invoke(array $configuration)
    {
        return new Payload($configuration, $this->descriptorBuilder);
    }
}
