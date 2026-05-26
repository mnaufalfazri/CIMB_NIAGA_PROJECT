import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Internal\AccountController::store
 * @see app/Http/Controllers/Internal/AccountController.php:27
 * @route '/api/internal/accounts'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/internal/accounts',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Internal\AccountController::store
 * @see app/Http/Controllers/Internal/AccountController.php:27
 * @route '/api/internal/accounts'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Internal\AccountController::store
 * @see app/Http/Controllers/Internal/AccountController.php:27
 * @route '/api/internal/accounts'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Internal\AccountController::store
 * @see app/Http/Controllers/Internal/AccountController.php:27
 * @route '/api/internal/accounts'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Internal\AccountController::store
 * @see app/Http/Controllers/Internal/AccountController.php:27
 * @route '/api/internal/accounts'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\Internal\AccountController::balance
 * @see app/Http/Controllers/Internal/AccountController.php:54
 * @route '/api/internal/balance/{nomor_rekening}'
 */
export const balance = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: balance.url(args, options),
    method: 'get',
})

balance.definition = {
    methods: ["get","head"],
    url: '/api/internal/balance/{nomor_rekening}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Internal\AccountController::balance
 * @see app/Http/Controllers/Internal/AccountController.php:54
 * @route '/api/internal/balance/{nomor_rekening}'
 */
balance.url = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { nomor_rekening: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    nomor_rekening: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        nomor_rekening: args.nomor_rekening,
                }

    return balance.definition.url
            .replace('{nomor_rekening}', parsedArgs.nomor_rekening.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Internal\AccountController::balance
 * @see app/Http/Controllers/Internal/AccountController.php:54
 * @route '/api/internal/balance/{nomor_rekening}'
 */
balance.get = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: balance.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Internal\AccountController::balance
 * @see app/Http/Controllers/Internal/AccountController.php:54
 * @route '/api/internal/balance/{nomor_rekening}'
 */
balance.head = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: balance.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Internal\AccountController::balance
 * @see app/Http/Controllers/Internal/AccountController.php:54
 * @route '/api/internal/balance/{nomor_rekening}'
 */
    const balanceForm = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: balance.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Internal\AccountController::balance
 * @see app/Http/Controllers/Internal/AccountController.php:54
 * @route '/api/internal/balance/{nomor_rekening}'
 */
        balanceForm.get = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: balance.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Internal\AccountController::balance
 * @see app/Http/Controllers/Internal/AccountController.php:54
 * @route '/api/internal/balance/{nomor_rekening}'
 */
        balanceForm.head = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: balance.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    balance.form = balanceForm
/**
* @see \App\Http\Controllers\Internal\AccountController::validate
 * @see app/Http/Controllers/Internal/AccountController.php:78
 * @route '/api/internal/validate-account/{nomor_rekening}'
 */
export const validate = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: validate.url(args, options),
    method: 'get',
})

validate.definition = {
    methods: ["get","head"],
    url: '/api/internal/validate-account/{nomor_rekening}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Internal\AccountController::validate
 * @see app/Http/Controllers/Internal/AccountController.php:78
 * @route '/api/internal/validate-account/{nomor_rekening}'
 */
validate.url = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { nomor_rekening: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    nomor_rekening: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        nomor_rekening: args.nomor_rekening,
                }

    return validate.definition.url
            .replace('{nomor_rekening}', parsedArgs.nomor_rekening.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Internal\AccountController::validate
 * @see app/Http/Controllers/Internal/AccountController.php:78
 * @route '/api/internal/validate-account/{nomor_rekening}'
 */
validate.get = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: validate.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Internal\AccountController::validate
 * @see app/Http/Controllers/Internal/AccountController.php:78
 * @route '/api/internal/validate-account/{nomor_rekening}'
 */
validate.head = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: validate.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Internal\AccountController::validate
 * @see app/Http/Controllers/Internal/AccountController.php:78
 * @route '/api/internal/validate-account/{nomor_rekening}'
 */
    const validateForm = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: validate.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Internal\AccountController::validate
 * @see app/Http/Controllers/Internal/AccountController.php:78
 * @route '/api/internal/validate-account/{nomor_rekening}'
 */
        validateForm.get = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: validate.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Internal\AccountController::validate
 * @see app/Http/Controllers/Internal/AccountController.php:78
 * @route '/api/internal/validate-account/{nomor_rekening}'
 */
        validateForm.head = (args: { nomor_rekening: string | number } | [nomor_rekening: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: validate.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    validate.form = validateForm
/**
* @see \App\Http\Controllers\Internal\AccountController::debit
 * @see app/Http/Controllers/Internal/AccountController.php:96
 * @route '/api/internal/debit'
 */
export const debit = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: debit.url(options),
    method: 'post',
})

debit.definition = {
    methods: ["post"],
    url: '/api/internal/debit',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Internal\AccountController::debit
 * @see app/Http/Controllers/Internal/AccountController.php:96
 * @route '/api/internal/debit'
 */
debit.url = (options?: RouteQueryOptions) => {
    return debit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Internal\AccountController::debit
 * @see app/Http/Controllers/Internal/AccountController.php:96
 * @route '/api/internal/debit'
 */
debit.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: debit.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Internal\AccountController::debit
 * @see app/Http/Controllers/Internal/AccountController.php:96
 * @route '/api/internal/debit'
 */
    const debitForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: debit.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Internal\AccountController::debit
 * @see app/Http/Controllers/Internal/AccountController.php:96
 * @route '/api/internal/debit'
 */
        debitForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: debit.url(options),
            method: 'post',
        })
    
    debit.form = debitForm
/**
* @see \App\Http\Controllers\Internal\AccountController::credit
 * @see app/Http/Controllers/Internal/AccountController.php:125
 * @route '/api/internal/credit'
 */
export const credit = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: credit.url(options),
    method: 'post',
})

credit.definition = {
    methods: ["post"],
    url: '/api/internal/credit',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Internal\AccountController::credit
 * @see app/Http/Controllers/Internal/AccountController.php:125
 * @route '/api/internal/credit'
 */
credit.url = (options?: RouteQueryOptions) => {
    return credit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Internal\AccountController::credit
 * @see app/Http/Controllers/Internal/AccountController.php:125
 * @route '/api/internal/credit'
 */
credit.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: credit.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Internal\AccountController::credit
 * @see app/Http/Controllers/Internal/AccountController.php:125
 * @route '/api/internal/credit'
 */
    const creditForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: credit.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Internal\AccountController::credit
 * @see app/Http/Controllers/Internal/AccountController.php:125
 * @route '/api/internal/credit'
 */
        creditForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: credit.url(options),
            method: 'post',
        })
    
    credit.form = creditForm
const AccountController = { store, balance, validate, debit, credit }

export default AccountController