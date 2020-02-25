<?php

namespace Half2me\GraphqlEloquentJoinDirectives;

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
        $eventsDispatcher->listen(
            RegisterDirectiveNamespaces::class,
            function (RegisterDirectiveNamespaces $registerDirectiveNamespaces): string {
                return __NAMESPACE__.'\Directives';
            }
        );
    }
}
