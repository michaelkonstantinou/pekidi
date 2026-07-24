<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Strengths
    |--------------------------------------------------------------------------
    */
    'positive_net_worth' =>
        'Your declared assets exceed your liabilities by :amount, resulting in a positive net worth.',

    'no_liabilities' =>
        'No financial liabilities were declared.',

    'low_debt_ratio' =>
        'Your liabilities represent only :ratio of your declared assets.',

    'liquid_reserves' =>
        'Liquid assets of :amount provide immediate financial flexibility.',

    'healthy_investment_allocation' =>
        ':ratio of your declared assets are allocated to financial investments.',

    /*
    |--------------------------------------------------------------------------
    | Weaknesses
    |--------------------------------------------------------------------------
    */

    'negative_net_worth' =>
        'Your declared liabilities exceed your assets by :amount.',

    'high_debt_ratio' =>
        'Your liabilities represent :ratio of your declared assets, indicating a high level of indebtedness.',

    'elevated_debt_ratio' =>
        'Your liabilities represent :ratio of your declared assets, indicating a moderate level of indebtedness.',

    'no_liquid_reserves' =>
        'No liquid assets were declared, which may reduce financial flexibility.',

    'low_liquidity' =>
        'Only :ratio of your declared assets are held as liquid assets.',

    'low_investment_exposure' =>
        'Only :ratio of your declared assets are allocated to financial investments.',

    'asset_concentration' =>
        ':ratio of your declared assets are concentrated in :category.',

    'credit_card_debt' =>
        'Credit card debt of :amount was declared.',

    'other_debt' =>
        'Liabilities of :amount are classified as other debt and may require further review.',

    'asset_categories' => [
        'real_estates'      => 'real estate',
        'vehicles'          => 'vehicles',
        'businesses'        => 'businesses',
        'investments'       => 'investments',
        'deposits'          => 'deposits',
        'additional_assets' => 'additional assets',
    ],

];
