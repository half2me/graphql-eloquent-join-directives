<?php


namespace Half2me\EloquentGraphqlJoinDirectives\Directives;


use Fico7489\Laravel\EloquentJoin\EloquentJoinBuilder;
use Nuwave\Lighthouse\Schema\Directives\InDirective;

class InJoinDirective extends InDirective
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'SDL'
directive @inJoin(
  """
  Specify the database column to compare.
  Only required if database column has a different name than the attribute in your schema.
  """
  key: String
) on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
SDL;
    }

    /**
     * Apply a simple "WHERE IN $values" clause.
     *
     * @param EloquentJoinBuilder $builder
     * @param mixed $values
     * @return EloquentJoinBuilder
     */
    public function handleBuilder($builder, $values)
    {
        return $builder->whereInJoin(
            $this->directiveArgValue('key', $this->nodeName()),
            $values
        );
    }
}
