<h3 class="flex items-center font-normal text-white mb-6 text-base no-underline">
    <span class="sidebar-label">
        {{ __('Dashboard Manager') }}
    </span>
</h3>

<ul class="list-reset mb-8">
        @foreach($dashboards as $resource)
        <li class="leading-tight mb-4 ml-8 text-sm">
            <router-link
                class="text-white text-justify no-underline dim"
                :to="{
                    name: 'nova-dashboard',
                    params: {
                        dashboardKey: '{!! $resource->resourceUri() !!}'
                    },
                    query: {
                        dashboardId: {{ $resource->resourceId() }}
                    }
                }">
                {{ $resource->resourceLabel() }}
            </router-link>
        </li>
    @endforeach

    <li>
        <h4 class="ml-8 mb-4 text-xs text-white-50% uppercase tracking-wide">{{ __('Configuration') }}</h4>
    </li>

        <li class="leading-wide mb-2 text-sm">
            <router-link :to="{
                    name: 'index',
                    params: {
                        resourceName: '{{ NovaBi\NovaDashboardManager\Nova\DashboardConfiguration::uriKey() }}',
                    }
                }" class="text-white ml-8 no-underline dim">
                - {{ __('Dashboard') }}
            </router-link>
        </li>
        <li class="leading-wide mb-2 text-sm">
            <router-link :to="{
                    name: 'index',
                    params: {
                        resourceName: '{{ \NovaBi\NovaDashboardManager\Nova\Datawidget::uriKey() }}',
                    }
                }" class="text-white ml-8 no-underline dim">
                - {{ __('Widgets') }}
            </router-link>
        </li>
        <li class="leading-wide mb-2 text-sm">
            <router-link :to="{
                    name: 'index',
                    params: {
                        resourceName: '{{ \NovaBi\NovaDashboardManager\Nova\Datafilter::uriKey() }}',
                    }
                }" class="text-white ml-8 no-underline dim">
                - {{ __('Filter') }}
            </router-link>
        </li>
</ul>
