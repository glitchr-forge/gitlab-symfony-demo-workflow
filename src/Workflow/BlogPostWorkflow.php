<?php

namespace App\Workflow;

use App\Entity\Article;
use Base\Enum\WorkflowState;
use Base\Service\Model\WorkflowInterface;
use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

//
// Guard events, audit trail, etc. are not defined in Base\[..]\WorkflowPass
class BlogPostWorkflow extends Workflow implements WorkflowInterface
{
    public static function getWorkflowName(): string
    {
        return 'blog_post';
    }

    public static function getWorkflowType(): string
    {
        return 'workflow';
    }

    public static function supports(): array
    {
        return [Article::class];
    }

    public static function supportStrategy(): ?string
    {
        return null;
    }

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $definitionBuilder = new DefinitionBuilder();
        $definition = $definitionBuilder->addPlaces(WorkflowState::getPermittedValues())
            // Transitions are defined with a unique name, an origin place and a destination place
            ->addTransition(new Transition('to_review', WorkflowState::PENDING, WorkflowState::REVIEWING))
            ->addTransition(new Transition('publish', WorkflowState::REVIEWING, WorkflowState::APPROVED))
            ->addTransition(new Transition('reject', WorkflowState::REVIEWING, WorkflowState::REJECTED))
            ->build();

        $singleState = true; // true if the subject can be in only one state at a given time
        $property = 'state'; // subject property name where the state is stored
        $marking = new MethodMarkingStore($singleState, $property);

        parent::__construct($definition, $marking, $dispatcher, self::getWorkflowName());
    }
}
