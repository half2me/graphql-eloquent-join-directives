<?php


namespace Half2me\EloquentGraphqlJoinDirectives\Directives;

use Fico7489\Laravel\EloquentJoin\EloquentJoinBuilder;
use GraphQL\Language\AST\EnumTypeDefinitionNode;
use GraphQL\Language\AST\FieldDefinitionNode;
use GraphQL\Language\AST\InputValueDefinitionNode;
use Illuminate\Support\Str;
use Nuwave\Lighthouse\OrderBy\OrderByDirective;
use Nuwave\Lighthouse\Schema\AST\PartialParser;

class OrderByJoinDirective extends OrderByDirective
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'SDL'
"""
Sort a result list by one or more given columns.
"""
directive @orderByJoin(
    """
    Restrict the allowed column names to a well-defined list.
    This improves introspection capabilities and security.
    Mutually exclusive with the `columnsEnum` argument.
    """
    columns: [String!]

    """
    Use an existing enumeration type to restrict the allowed columns to a predefined list.
    This allowes you to re-use the same enum for multiple fields.
    Mutually exclusive with the `columns` argument.
    """
    columnsEnum: String
) on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
SDL;
    }

    /**
     * Apply an "ORDER BY" clause.
     *
     * @param EloquentJoinBuilder $builder
     * @param string[] $value
     * @return EloquentJoinBuilder
     */
    public function handleBuilder($builder, $value)
    {
        foreach ($value as $orderByClause) {
            $builder->orderByJoin(
            // TODO deprecated in v5
                $orderByClause[config('lighthouse.orderBy', 'field')],
                $orderByClause['order']
            );
        }

        return $builder;
    }

    /**
     * Create the Enum that holds the allowed columns.
     *
     * @param InputValueDefinitionNode $argDefinition
     * @param FieldDefinitionNode $parentField
     * @param string[] $allowedColumns
     * @param string $allowedColumnsEnumName
     * @return EnumTypeDefinitionNode
     */
    protected function createAllowedColumnsEnum(
        InputValueDefinitionNode &$argDefinition,
        FieldDefinitionNode &$parentField,
        array $allowedColumns,
        string $allowedColumnsEnumName
    ): EnumTypeDefinitionNode
    {
        $enumDef = collect($allowedColumns)
            ->map(fn($c) => strtoupper(
                    Str::snake(str_replace('.', '_', $c))
                ) . "@enum(value: \"$c\")")
            ->implode("\n");

        $enumDef =
            "\"Allowed column names for the `{$argDefinition->name->value}` argument on the query `{$parentField->name->value}`.\"\n" .
            "enum $allowedColumnsEnumName {\n$enumDef\n}";

        return PartialParser::enumTypeDefinition($enumDef);
    }
}
