import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\DashboardController::dashboard
 * @see app/Http/Controllers/DashboardController.php:21
 * @route '/wealth/dashboard'
 */
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/wealth/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DashboardController::dashboard
 * @see app/Http/Controllers/DashboardController.php:21
 * @route '/wealth/dashboard'
 */
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DashboardController::dashboard
 * @see app/Http/Controllers/DashboardController.php:21
 * @route '/wealth/dashboard'
 */
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DashboardController::dashboard
 * @see app/Http/Controllers/DashboardController.php:21
 * @route '/wealth/dashboard'
 */
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\DashboardController::dashboard
 * @see app/Http/Controllers/DashboardController.php:21
 * @route '/wealth/dashboard'
 */
    const dashboardForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: dashboard.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\DashboardController::dashboard
 * @see app/Http/Controllers/DashboardController.php:21
 * @route '/wealth/dashboard'
 */
        dashboardForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboard.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\DashboardController::dashboard
 * @see app/Http/Controllers/DashboardController.php:21
 * @route '/wealth/dashboard'
 */
        dashboardForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboard.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    dashboard.form = dashboardForm
/**
* @see \App\Http\Controllers\MutasiController::mutasi
 * @see app/Http/Controllers/MutasiController.php:22
 * @route '/wealth/mutasi'
 */
export const mutasi = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mutasi.url(options),
    method: 'get',
})

mutasi.definition = {
    methods: ["get","head"],
    url: '/wealth/mutasi',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\MutasiController::mutasi
 * @see app/Http/Controllers/MutasiController.php:22
 * @route '/wealth/mutasi'
 */
mutasi.url = (options?: RouteQueryOptions) => {
    return mutasi.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\MutasiController::mutasi
 * @see app/Http/Controllers/MutasiController.php:22
 * @route '/wealth/mutasi'
 */
mutasi.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mutasi.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\MutasiController::mutasi
 * @see app/Http/Controllers/MutasiController.php:22
 * @route '/wealth/mutasi'
 */
mutasi.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: mutasi.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\MutasiController::mutasi
 * @see app/Http/Controllers/MutasiController.php:22
 * @route '/wealth/mutasi'
 */
    const mutasiForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: mutasi.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\MutasiController::mutasi
 * @see app/Http/Controllers/MutasiController.php:22
 * @route '/wealth/mutasi'
 */
        mutasiForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: mutasi.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\MutasiController::mutasi
 * @see app/Http/Controllers/MutasiController.php:22
 * @route '/wealth/mutasi'
 */
        mutasiForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: mutasi.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    mutasi.form = mutasiForm
const wealth = {
    dashboard: Object.assign(dashboard, dashboard),
mutasi: Object.assign(mutasi, mutasi),
}

export default wealth