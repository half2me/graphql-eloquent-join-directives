# What is this?
This package contains GraphQL directives for use with [Lighthouse](https://github.com/nuwave/lighthouse).
These directives provide an easy way to use the extra clauses provided by the [Laravel Eloquent Join](https://github.com/fico7489/laravel-eloquent-join) package in a similar way to using plain eloquent clauses.

# Installation
Install with composer
```
composer require half2me/graphql-eloquent-join-directives
```

# Available Directives
The package provides the following list of directives which each behave exactly like their non `*-Join` counterparts with the difference being they call the join methods on the query builder.

- `@eqJoin`
- `@inJoin`
- `@orderByJoin`
- `@whereJoin`
