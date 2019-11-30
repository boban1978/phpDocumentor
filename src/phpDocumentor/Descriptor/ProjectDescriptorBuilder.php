<?php

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Descriptor;

use InvalidArgumentException;
use phpDocumentor\Descriptor\Builder\AssemblerFactory;
use phpDocumentor\Descriptor\Builder\AssemblerInterface;
use phpDocumentor\Descriptor\Filter\Filter;
use phpDocumentor\Descriptor\Filter\Filterable;
use phpDocumentor\Reflection\Php\Project;
use function get_class;
use function is_iterable;
use function strlen;
use function substr;

/**
 * Builds a Project Descriptor and underlying tree.
 */
class ProjectDescriptorBuilder
{
    /** @var string */
    public const DEFAULT_PROJECT_NAME = 'Untitled project';

    /** @var AssemblerFactory $assemblerFactory */
    protected $assemblerFactory;

    /** @var Filter $filter */
    protected $filter;

    /** @var ProjectDescriptor $project */
    protected $project;

    /** @var string */
    private $defaultPackage;

    public function __construct(AssemblerFactory $assemblerFactory, Filter $filterManager)
    {
        $this->assemblerFactory = $assemblerFactory;
        $this->filter = $filterManager;
    }

    public function createProjectDescriptor() : void
    {
        $this->project = new ProjectDescriptor(self::DEFAULT_PROJECT_NAME);
    }

    /**
     * Returns the project descriptor that is being built.
     */
    public function getProjectDescriptor() : ProjectDescriptor
    {
        return $this->project;
    }

    /**
     * Takes the given data and attempts to build a Descriptor from it.
     *
     * @param mixed $data
     *
     * @return DescriptorAbstract|Collection|null
     *
     * @throws InvalidArgumentException If no Assembler could be found that matches the given data.
     */
    public function buildDescriptor($data)
    {
        $assembler = $this->getAssembler($data);
        if (!$assembler) {
            throw new InvalidArgumentException(
                'Unable to build a Descriptor; the provided data did not match any Assembler ' .
                get_class($data)
            );
        }

        if ($assembler instanceof Builder\AssemblerAbstract) {
            $assembler->setBuilder($this);
        }

        // create Descriptor and populate with the provided data
        $descriptor = $assembler->create($data);

        if ($descriptor instanceof DescriptorAbstract) {
            return $this->filterDescriptor($descriptor);
        }

        if (is_iterable($descriptor)) {
            return $this->filterEachDescriptor($descriptor);
        }

        return null;
    }

    /**
     * Attempts to find an assembler matching the given data.
     *
     * @param mixed $data
     */
    public function getAssembler($data) : ?AssemblerInterface
    {
        return $this->assemblerFactory->get($data);
    }

    /**
     * Analyzes a Descriptor and alters its state based on its state or even removes the descriptor.
     */
    public function filter(Filterable $descriptor) : Filterable
    {
        return $this->filter->filter($descriptor);
    }

    /**
     * Filters each descriptor, validates them, stores the validation results and returns a collection of transmuted
     * objects.
     *
     * @param DescriptorAbstract[] $descriptor
     */
    private function filterEachDescriptor(iterable $descriptor) : Collection
    {
        $descriptors = new Collection();
        foreach ($descriptor as $key => $item) {
            $item = $this->filterDescriptor($item);
            if (!$item) {
                continue;
            }

            $descriptors[$key] = $item;
        }

        return $descriptors;
    }

    /**
     * Filters a descriptor, validates it, stores the validation results and returns the transmuted object or null
     * if it is supposed to be removed.
     */
    protected function filterDescriptor(DescriptorAbstract $descriptor) : ?DescriptorAbstract
    {
        if (!$descriptor instanceof Filterable) {
            return $descriptor;
        }

        // filter the descriptor; this may result in the descriptor being removed!
        $descriptor = $this->filter($descriptor);
        if (!$descriptor instanceof DescriptorAbstract) {
            return null;
        }

        return $descriptor;
    }

    public function build(Project $project) : void
    {
        $packageName = $project->getRootNamespace()->getFqsen()->getName();
        $this->defaultPackage = $packageName;

        foreach ($project->getFiles() as $file) {
            $descriptor = $this->buildDescriptor($file);
            if (!$descriptor) {
                return;
            }

            $this->getProjectDescriptor()->getFiles()->set($descriptor->getPath(), $descriptor);
        }

        $namespaces = $this->getProjectDescriptor()->getIndexes()->get('namespaces', new Collection());

        foreach ($project->getNamespaces() as $namespace) {
            $namespaces->set((string) $namespace->getFqsen(), $this->buildDescriptor($namespace));
        }
    }

    public function getDefaultPackage(): ?string
    {
        return $this->defaultPackage;
    }

    public function setVisibility(array $apiConfig) : void
    {
        $visibilities = $apiConfig['visibility'];
        $visibility = null;

        foreach ($visibilities as $item) {
            switch ($item) {
                case 'public':
                    $visibility |= ProjectDescriptor\Settings::VISIBILITY_PUBLIC;
                    break;
                case 'protected':
                    $visibility |= ProjectDescriptor\Settings::VISIBILITY_PROTECTED;
                    break;
                case 'private':
                    $visibility |= ProjectDescriptor\Settings::VISIBILITY_PRIVATE;
                    break;
            }
        }

        $this->project->getSettings()->setVisibility($visibility);
    }

    public function setName(string $title) : void
    {
        $this->project->setName($title);
    }

    public function setPartials(Collection $partials) : void
    {
        $this->project->setPartials($partials);
    }

    public function setMarkers(array $markers) : void
    {
        $this->project->getSettings()->setMarkers($markers);
    }

    public function setIncludeSource(bool $includeSources) : void
    {
        if ($includeSources) {
            $this->project->getSettings()->includeSource();
        } else {
            $this->project->getSettings()->excludeSource();
        }
    }
}
