<?php

namespace Half2me\EloquentGraphqlJoinDirectives;

use Illuminate\Contracts\Events\Dispatcher as EventsDispatcher;
use Illuminate\Support\ServiceProvider;
use Nuwave\Lighthouse\Events\RegisterDirectiveNamespaces;

class GraphqlEloquentJoinDirectivesServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(EventsDispatcher $eventsDispatcher)
    {
        parent::boot();

        $eventsDispatcher->listen(
            RegisterDirectiveNamespaces::class,
            function (RegisterDirectiveNamespaces $registerDirectiveNamespaces): string {
                return __NAMESPACE__.'\Directives';
            }
        );
    }
}
