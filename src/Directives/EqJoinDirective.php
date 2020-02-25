<?php


namespace Half2me\GraphqlEloquentJoinDirectives\Directives;


use Fico7489\Laravel\EloquentJoin\EloquentJoinBuilder;
use Nuwave\Lighthouse\Schema\Directives\EqDirective;

class EqJoinDirective extends EqDirective
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'SDL'
directive @eqJoin(
  """
  Specify the database column to compare.
  Only required if database column has a different name than the attribute in your schema.
  """
  key: String
) on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
SDL;
    }

    /**
     * Apply a "WHERE = $value" clause.
     *
     * @param EloquentJoinBuilder $builder
     * @param mixed $value
     * @return EloquentJoinBuilder
     */
    public function handleBuilder($builder, $value)
    {
        return $builder->whereJoin(
            $this->directiveArgValue('key', $this->nodeName()),
            '=',
            $value
        );
    }
}
