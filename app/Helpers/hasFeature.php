<?php
function hasFeature(string $featureKey): bool
{
    $user = auth()->user();
    if (!$user) return false;

    $package = $user->activePackage();
    if (!$package) return false;

    return $package->features()
        ->where('key', $featureKey)
        ->wherePivot('is_enabled', true)
        ->exists();
}

