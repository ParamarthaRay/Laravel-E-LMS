<?php

use Carbon\Carbon;

function newFeedback($title = 'Operation Successful', $body = 'The operation was successfully completed.', $type = 'success')
{
    $session = session()->has('feedbacks') ? session()->get('feedbacks') : [];
    $session[] = ['title' => $title, 'body' => $body, 'type' => $type];
    session()->flash('feedbacks', $session);
}

function dateFromGregorian($date, $format = 'd-m-Y')
{
    // Convert the string date in d-m-Y format to a Carbon instance and return it in specified format
    return $date ? Carbon::createFromFormat('d-m-Y', $date)->format($format) : null;
}

function getGregorianFromFormat($date, $format = 'd-m-Y')
{
    // Convert the Carbon date to desired format
    return Carbon::createFromFormat('d-m-Y', $date)->format($format);
}

function createFromCarbon(Carbon $carbon)
{
    // Return the carbon instance in default d-m-Y format
    return $carbon->format('d-m-Y');
}

function hasPermissionTo($permission): bool
{
    return auth()->check() && auth()->user()->hasPermissionTo($permission);
}
