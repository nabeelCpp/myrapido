<?php

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

/**
 * Check if admin is authorized to perform an action
 *
 */
function is_admin_authorized() {
    $admin = Auth::guard(request()->whoIs)->user();
    if(!$admin->region || !$admin->region->status) {
        abort(403, 'Unauthorized action.');
    }
    return $admin;
}

/**
 * Get active plans
 */
function get_active_plans() {
    return Plan::where(['status' => 1])->get();
}
