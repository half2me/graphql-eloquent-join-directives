<?php


namespace App\GraphQL\Directives;


use Fico7489\Laravel\EloquentJoin\EloquentJoinBuilder;
use Nuwave\Lighthouse\Schema\Directives\WhereDirective;

class WhereJoinDirective extends WhereDirective
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'SDL'
"""
Use an input value as a [where filter](https://laravel.com/docs/queries#where-clauses).
"""
directive @whereJoin(
  """
  Specify the operator to use within the WHERE condition.
  """
  operator: String = "="

  """
  Specify the database column to compare.
  Only required if database column has a different name than the attribute in your schema.
  """
  key: String

  """
  Use Laravel\'s where clauses upon the query builder.
  """
  clause: String
) on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
SDL;
    }

    /**
     * @param EloquentJoinBuilder $builder
     * @param mixed $value
     * @return EloquentJoinBuilder
     */
    public function handleBuilder($builder, $value)
    {
        // Allow users to overwrite the default "where" clause, e.g. "whereYear"
        $clause = $this->directiveArgValue('clause', 'whereJoin');

        return $builder->{$clause}(
            $this->directiveArgValue('key', $this->nodeName()),
            $operator = $this->directiveArgValue('operator', '='),
            $value
        );
    }
}
